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

class HomeController extends Controller
{
    public function index()
    {
        $role = Auth::user()->officer_type;

        if ($role == 'Administrator') {
            if (Admin::count() == 0) {
                return view('admin.admin_resource.config-body');
            } else {
                $disaster_responses = DisasterResponse::where('date_ended', '=', null)->get();
                return view('admin.home')->with('disaster_responses', $disaster_responses);
            }

            // dd($disaster_responses);
        } elseif ($role == 'Barangay Captain') {
         
            $disaster_responses = DisasterResponse::where('date_ended', '=', null)->get();
            return view('barangay-captain.home')->with('disaster_responses', $disaster_responses);
        
        } elseif ($role == 'Camp Manager') {

            $id = Auth::id();
            $evacuation_center = EvacuationCenter::where('camp_manager_id', '=', $id)->first();
            if (empty($evacuation_center)) {
                abort(403, "You are not assigned to an evacuation center yet. Contact your adminstrator for further info.");
            }
            $evacuees = Evacuee::where('evacuation_center_id', $evacuation_center->id)->where('date_discharged', null)->get();
            $total_number_of_evacuees = 0;
            if ($evacuees != null) {
                $family_codes =  Array();
                foreach ($evacuees as $evacuee) {
                    $relief_recipient = ReliefRecipient::where('id', $evacuee->relief_recipient_id)->first();
                    if(!in_array($relief_recipient->family_code, $family_codes)){
                        array_push($family_codes, $relief_recipient->family_code);
                        $family = Family::where('family_code', $relief_recipient->family_code)->first();
                        $total_number_of_evacuees = $total_number_of_evacuees + $family->no_of_members;
                    }
                    
                }
            }
            $disaster_responses = DisasterResponse::where('date_ended', '=', null)->get();
            return view('camp-manager.home', ['disaster_responses' => $disaster_responses,
            'total_number_of_evacuees' => $total_number_of_evacuees,
            'evacuation_center_name' => $evacuation_center->name,
            'capacity' => $evacuation_center->capacity]);
        
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