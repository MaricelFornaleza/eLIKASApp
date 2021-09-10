<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\DeliveryRequest;
use App\Models\DisasterResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\EvacuationCenter;
use App\Models\FamilyMember;
use App\Models\Evacuee;
use App\Models\ReliefRecipient;
use App\Models\Family;

use App\Models\Inventory;

use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $role = Auth::user()->officer_type;

        if ($role == 'Administrator') {
            if (Admin::count() == 0) {
                return view('admin.admin_resource.config-body');
            } else {
                $disaster_responses = DisasterResponse::where('date_ended', '=', null)
                    ->orderBy('created_at', 'DESC')
                    ->get();
                return view('admin.home')->with('disaster_responses', $disaster_responses);
            }

            // dd($disaster_responses);
        } elseif ($role == 'Barangay Captain') {
            $user = Auth::user();
            $barangay_captain = DB::table('barangay_captains')->where('user_id', $user->id)->first();
            $disaster_responses = DisasterResponse::where('date_ended', '=', null)->get();

            // $relief_recipients = DB::table('relief_recipients')
            // ->where('relief_recipients.recipient_type', 'Non-evacuee')
            // ->select('relief_recipients.family_code')
            // ->groupBy('relief_recipients.family_code')
            // ->get();

            $residents = 0;
            $female = 0;
            $male = 0;
            $children = 0;
            $lactating = 0;
            $pwd = 0;
            $pregnant = 0;
            $senior_citizen  = 0;
            $solo_parent = 0;

            $family_members = FamilyMember::where('barangay', $barangay_captain->barangay)->get();
            if ($family_members != null) {
                $female = $female + $family_members->where('gender', 'Female')->count();
                $male = $male + $family_members->where('gender', 'Male')->count();
                $children = $children + $family_members->where('sectoral_classification', 'Children')->count();
                $lactating = $lactating + $family_members->where('sectoral_classification', 'Lactating')->count();
                $pwd = $pwd + $family_members->where('sectoral_classification', 'Person with Disability')->count();
                $pregnant = $pregnant + $family_members->where('sectoral_classification', 'Pregnant')->count();
                $senior_citizen  = $senior_citizen + $family_members->where('sectoral_classification', 'Senior Citizen')->count();
                $solo_parent = $solo_parent + $family_members->where('sectoral_classification', 'Solo Parent')->count();

                $residents = $residents + $family_members->count();
            }



            $non_evacuees = DB::table('family_members')
                ->leftJoin('relief_recipients', function ($join) {
                    $join->on('family_members.family_code', '=', 'relief_recipients.family_code')
                        ->where('relief_recipients.recipient_type', '=', 'Non-evacuee')
                        ->leftJoin(
                            'disaster_responses',
                            function ($join) {
                                $join->on('relief_recipients.disaster_response_id', '=', 'disaster_responses.id')
                                    ->whereNotNull('disaster_responses.date_ended');
                            }
                        );
                })
                ->whereNotNull('family_members.family_code')
                ->where('family_members.barangay', $barangay_captain->barangay)
                ->select('name')
                ->get();

            $bc_inventory = Inventory::where('user_id', '=', $user->id)->first();

            return view(
                'barangay-captain.home',
                [
                    'disaster_responses', $disaster_responses,
                    'barangay_captain' => $barangay_captain,
                    'residents' => $residents,
                    'female' => $female,
                    'male' => $male,
                    'children' => $children,
                    'lactating' => $lactating,
                    'pwd' => $pwd,
                    'pregnant' => $pregnant,
                    'senior_citizen' => $senior_citizen,
                    'solo_parent' => $solo_parent,
                    'bc_inventory' => $bc_inventory,
                    'non_evacuees' => $non_evacuees,
                ]
            );
        } elseif ($role == 'Camp Manager') {

            $id = Auth::id();
            $evacuation_center = EvacuationCenter::where('camp_manager_id', '=', $id)->first();
            if (empty($evacuation_center)) {
                abort(403, "You are not assigned to an evacuation center yet. Contact your adminstrator for further info.");
            }
            $evacuees = Evacuee::where('evacuation_center_id', $evacuation_center->id)->where('date_discharged', null)->get();
            $total_number_of_evacuees = 0;
            if ($evacuees != null) {
                $family_codes =  array();
                foreach ($evacuees as $evacuee) {
                    $relief_recipient = ReliefRecipient::where('id', $evacuee->relief_recipient_id)->first();
                    if (!in_array($relief_recipient->family_code, $family_codes)) {
                        array_push($family_codes, $relief_recipient->family_code);
                        $family = Family::where('family_code', $relief_recipient->family_code)->first();
                        $total_number_of_evacuees = $total_number_of_evacuees + $family->no_of_members;
                    }
                }
            }
            $disaster_responses = DisasterResponse::where('date_ended', '=', null)->get();
            return view('camp-manager.home', [
                'disaster_responses' => $disaster_responses,
                'total_number_of_evacuees' => $total_number_of_evacuees,
                'evacuation_center_name' => $evacuation_center->name,
                'capacity' => $evacuation_center->capacity
            ]);
        } elseif ($role == 'Courier') {
            $id = Auth::id();
            $delivery_requests = DeliveryRequest::where('courier_id', '=', $id)
                ->join('evacuation_centers', 'evacuation_centers.camp_manager_id', '=', 'requests.camp_manager_id')
                ->select('evacuation_centers.name as evacuation_center_name', 'requests.*')
                ->orderByRaw("CASE WHEN requests.status = 'pending' THEN '1'
                            WHEN requests.status = 'preparing' THEN '2'
                            WHEN requests.status = 'in-transit' THEN '3'
                            WHEN requests.status = 'delivered' THEN '4'
                            WHEN requests.status = 'cancelled' THEN '5'
                            WHEN requests.status = 'decline' THEN '6' END ASC, requests.updated_at DESC")
                ->get();

            $is_empty = DeliveryRequest::where('courier_id', '=', $id)->first();
            /*
            SELECT evacuation_centers.name, requests.*
                FROM requests
                JOIN evacuation_centers
                ON evacuation_centers.camp_manager_id = requests.camp_manager_id
                ORDER BY updated_at DESC 
            */
            return view('courier.home', ['delivery_requests' => $delivery_requests, 'is_empty' => $is_empty]);
        }
    }
}