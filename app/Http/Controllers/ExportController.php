<?php

namespace App\Http\Controllers;

use App\Exports\FieldOfficerExport;
use App\Exports\SuppliesExport;
use App\Exports\EvacuationCenterExport;
use App\Exports\DeliveryRequestExport;
use App\Exports\ResidentsExport;
use App\Models\Admin;
use App\Models\EvacuationCenter;
use App\Models\Evacuee;
use App\Models\Family;
use App\Models\FamilyMember;
use App\Models\Inventory;
use App\Models\AffectedResident;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PDF;



class ExportController extends Controller
{

    public function exportFieldOfficer()
    {
        $todayDate = date("Y-m-d");
        return Excel::download(new FieldOfficerExport, 'FieldOfficer_' . $todayDate . '.xls');
    }
    public function exportFieldOfficerPDF()
    {
        $todayDate = date("Y-m-d");
        $field_officers = User::where('officer_type', '!=', 'Administrator')
            ->leftJoin('camp_managers', 'camp_managers.user_id', '=', 'users.id')
            ->leftJoin('barangay_captains', 'barangay_captains.user_id', '=', 'users.id')
            ->leftJoin('couriers', 'couriers.user_id', '=', 'users.id')
            ->select(
                'users.*',
                'camp_managers.*',
                'barangay_captains.*',
                'couriers.*',
                'users.id as user_id',
                'camp_managers.designation as camp_designation',
                'barangay_captains.barangay as barangay',

            )
            ->get();
        $admin = Admin::first();

        $pdf = PDF::loadView('admin.pdf.field-officers', compact('field_officers', 'admin'));
        return $pdf->stream('FieldOfficer_' . $todayDate . '.pdf');
    }
    public function exportSupplies()
    {
        $todayDate = date("Y-m-d");
        return Excel::download(new SuppliesExport, 'Supplies_ ' . $todayDate . '.xls');
    }
    public function exportSuppliesPDF()
    {
        $user = Auth::user();
        $admin = Admin::first();
        $todayDate = date("Y-m-d");
        $user_inventory = User::find($user->id)->user_inventory;
        $supplies = Inventory::find($user_inventory->id)->inventory_supplies;
        $pdf = PDF::loadView('admin.pdf.supplies', compact('supplies', 'admin'));
        return $pdf->stream('Supplies_' . $todayDate . '.pdf');
    }
    public function exportEvacuationCenters()
    {
        $todayDate = date("Y-m-d");
        return Excel::download(new EvacuationCenterExport, 'EvacuationCenters_' . $todayDate . '.xls');
    }
    public function exportEvacuationCentersPDF()
    {

        $admin = Admin::first();
        $todayDate = date("Y-m-d");
        $allEvacuationCenters = array();
        $evacuation_centers = DB::table('evacuation_centers')
            ->leftJoin('users', 'evacuation_centers.camp_manager_id', '=', 'users.id')
            ->select('evacuation_centers.*', 'users.name as camp_manager_name')
            ->orderByRaw('evacuation_centers.id ASC')
            ->get();

        foreach ($evacuation_centers as $evacuation_center) {
            $evacuees = Evacuee::where('evacuation_center_id', $evacuation_center->id)->whereNull('date_discharged')->get();
            $total_number_of_evacuees = 0;
            $family_codes =  array();
            $female = 0;
            $male = 0;
            $children = 0;
            $lactating = 0;
            $pwd = 0;
            $pregnant = 0;
            $senior_citizen  = 0;
            $solo_parent = 0;
            if ($evacuees != null) {
                foreach ($evacuees as $evacuee) {
                    $affected_resident = AffectedResident::where('id', $evacuee->affected_resident_id)->first();
                    if (!in_array($affected_resident->family_code, $family_codes)) {
                        array_push($family_codes, $affected_resident->family_code);
                        $family = Family::where('family_code', $affected_resident->family_code)->first();
                        $total_number_of_evacuees = $total_number_of_evacuees + $family->no_of_members;

                        $family_members = FamilyMember::where('family_code', $family->family_code)->get();

                        $female = $female + $family_members->where('gender', 'Female')->count();
                        $male = $male + $family_members->where('gender', 'Male')->count();
                        $children = $children + $family_members->where('sectoral_classification', 'Children')->count();
                        $lactating = $lactating + $family_members->where('sectoral_classification', 'Lactating')->count();
                        $pwd = $pwd + $family_members->where('sectoral_classification', 'Person with Disability')->count();
                        $pregnant = $pregnant + $family_members->where('sectoral_classification', 'Pregnant')->count();
                        $senior_citizen  = $senior_citizen + $family_members->where('sectoral_classification', 'Senior Citizen')->count();
                        $solo_parent = $solo_parent + $family_members->where('sectoral_classification', 'Solo Parent')->count();
                    }
                }
            }
            $eCenter = array(
                'id' => $evacuation_center->id,
                'name' =>  $evacuation_center->name,
                'address' =>  $evacuation_center->address,
                'characteristics' =>  $evacuation_center->characteristics,
                'camp_manager_name' => $evacuation_center->camp_manager_name,
                'capacity' => $evacuation_center->capacity,
                'total_number_of_evacuees' => $total_number_of_evacuees,
                'capacity' => $evacuation_center->capacity,
                'female' => $female,
                'male' => $male,
                'children' => $children,
                'lactating' => $lactating,
                'pwd' => $pwd,
                'pregnant' => $pregnant,
                'senior_citizen' => $senior_citizen,
                'solo_parent' => $solo_parent
            );
            array_push($allEvacuationCenters, $eCenter);
        }

        $pdf = PDF::loadView('admin.pdf.evacuation-centers', compact('allEvacuationCenters', 'admin'))->setPAper('a4', 'landscape');
        return $pdf->stream('Evacuation_Centers_' . $todayDate . '.pdf');
    }
    public function exportDeliveryRequests()
    {
        $todayDate = date("Y-m-d");
        return Excel::download(new DeliveryRequestExport, 'Requests_' . $todayDate . '.xls');
    }
    public function exportDeliveryRequestsPDF()
    {

        $admin = Admin::first();
        $todayDate = date("Y-m-d");
        $delivery_requests = DB::table('requests')
            ->leftJoin('users', 'requests.camp_manager_id', '=', 'users.id')
            ->leftJoin('evacuation_centers', 'evacuation_centers.camp_manager_id', '=', 'requests.camp_manager_id')
            ->select(
                'requests.id',
                'users.name as camp_manager_name',
                'evacuation_centers.name',
                'requests.food_packs',
                'requests.water',
                'requests.hygiene_kit',
                'requests.clothes',
                'requests.medicine',
                'requests.emergency_shelter_assistance',
                'requests.note',
                'requests.status',
                'requests.updated_at'
            )
            ->orderByRaw('updated_at ASC')
            ->get();
        $pdf = PDF::loadView('admin.pdf.requests', compact('delivery_requests', 'admin'))->setPAper('a4', 'landscape');
        return $pdf->stream('Requests_' . $todayDate . '.pdf');
    }
    public function exportResidents()
    {
        return Excel::download(new ResidentsExport, 'Residents.xls');
    }
    public function exportResidentsPDF()
    {
        $admin = Admin::first();
        $todayDate = date("Y-m-d");
        $residents = DB::table('family_members')
            ->leftJoin('families', 'family_members.family_code', '=', 'families.family_code')
            ->select(
                'family_members.family_code',
                'name',
                'gender',
                'birthdate',
                'sectoral_classification',
                'is_family_head',
                'street',
                'barangay'
            )
            ->get();
        $pdf = PDF::loadView('admin.pdf.residents', compact('residents', 'admin'))->setPAper('a4', 'landscape');
        return $pdf->stream('Residents_' . $todayDate . '.pdf');
    }
}