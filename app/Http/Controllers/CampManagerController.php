<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\EvacuationCenter;
use App\Models\DisasterResponse;
use App\Models\DeliveryRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Models\FamilyMember;
use App\Models\Evacuee;
use App\Models\CampManager;
use App\Models\ReliefRecipient;
use Illuminate\Support\Str;

use App\Http\Controllers\Carbon\Carbon;

use App\Models\ReliefGood;
use App\Models\Family;

class CampManagerController extends Controller
{
    public function evacuees()
    {
        $id = Auth::id();
        $evacuation_center = EvacuationCenter::where('camp_manager_id', '=', $id)->first();
        if (empty($evacuation_center)) {
            abort(403, "You are not assigned to an evacuation center yet. Contact your adminstrator for further info.");
        }
        $evacuees = Evacuee::where('evacuation_center_id', $evacuation_center->id)->whereNull('date_discharged')->get();
        $total_number_of_evacuees = 0;
        if ($evacuees != null) {
            $family_codes =  Array();
            $female =0 ;
            $male = 0;
            $children = 0;
            $lactating = 0;
            $pwd = 0;
            $pregnant = 0;
            $senior_citizen  = 0;
            $solo_parent = 0;
                
            foreach ($evacuees as $evacuee) {
                $relief_recipient = ReliefRecipient::where('id', $evacuee->relief_recipient_id)->first();
                if(!in_array($relief_recipient->family_code, $family_codes)){
                    array_push($family_codes, $relief_recipient->family_code);
                    $family = Family::where('family_code', $relief_recipient->family_code)->first();
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
        
        return view('camp-manager.evacuees.evacuees',
        ['total_number_of_evacuees' => $total_number_of_evacuees,
        'evacuation_center_name' => $evacuation_center->name,
        'capacity' => $evacuation_center->capacity,
        'female' => $female,
        'male' => $male,
        'children' => $children,
        'lactating' => $lactating,
        'pwd' => $pwd,
        'pregnant' => $pregnant,
        'senior_citizen' => $senior_citizen,
        'solo_parent' => $solo_parent,]);
    }
    public function admitView()
    {
        $id = Auth::id();
        $evacuation_center = EvacuationCenter::where('camp_manager_id', '=', $id)->first();
        if (empty($evacuation_center)) {
            abort(403, "You are not assigned to an evacuation center yet. Contact your adminstrator for further info.");
        }
        //  $disaster_responses = DisasterResponse::all();
        $family_members = DB::table('family_members')
            ->leftJoin('relief_recipients', 'family_members.family_code', '=', 'relief_recipients.family_code')
            ->leftJoin('disaster_responses', 'relief_recipients.disaster_response_id', '=', 'disaster_responses.id')
            ->whereNotNull('family_members.family_code')
            ->whereNotNull('relief_recipients.id')->where('relief_recipients.recipient_type', 'Non-evacuee')
            ->whereNull('disaster_responses.date_ended')
            ->select('family_members.family_code', 'name')
            ->get();
        return view('camp-manager.evacuees.admit', ['family_members' => $family_members]);
    }

    public function admit(Request $request)
    {
        $user = Auth::user();
        $evacuation_center = DB::table('evacuation_centers')->where('camp_manager_id', $user->id)->first();

        $validated = $request->validate([
            'checkedResidents'              => ['required'],
        ]);
        $family_codes =  Array();
        foreach ($request->checkedResidents as $checkedResident) {
            if(!in_array($checkedResident, $family_codes)){
                $find_checkedResident = DB::table('relief_recipients')->where('family_code', $checkedResident)->get();
                array_push($family_codes, $checkedResident);
                if ($find_checkedResident != null) {
                    foreach ($find_checkedResident as $found_relief_recipient) {
                        $relief_recipient = ReliefRecipient::find($found_relief_recipient->id);
                        $relief_recipient->recipient_type = 'Evacuee';
                        $relief_recipient->save();
                        
                        $checkIf_DR_IsEnded = DB::table('disaster_responses')->where('id', $relief_recipient->disaster_response_id)->first();
                        
                        if($checkIf_DR_IsEnded->date_ended == null){
                            $evacuee = new Evacuee();
                            $evacuee->relief_recipient_id = $relief_recipient->id;
                            $evacuee->date_admitted = now();
                            $evacuee->evacuation_center_id = $evacuation_center->id;
                            $evacuee->save(); 
                        }
                        
                    }
                }
            }
        }


        $request->session()->flash('message', 'Admit Resident successfully!');
        return redirect()->route('cm_evacuees');
    }

    public function dischargeView()
    {
        $id = Auth::id();
        $evacuation_center = EvacuationCenter::where('camp_manager_id', '=', $id)->first();
        if (empty($evacuation_center)) {
            abort(403, "You are not assigned to an evacuation center yet. Contact your adminstrator for further info.");
        }
        $user = Auth::user();
        $evacuation_center = DB::table('evacuation_centers')->where('camp_manager_id', $user->id)->first();
        $family_members = DB::table('family_members')
            ->leftJoin('relief_recipients', 'family_members.family_code', '=', 'relief_recipients.family_code')
            ->leftJoin('disaster_responses', 'relief_recipients.disaster_response_id', '=', 'disaster_responses.id')
            ->leftJoin('evacuees', 'relief_recipients.id', '=', 'evacuees.relief_recipient_id')
            ->whereNotNull('family_members.family_code')
            ->where('relief_recipients.recipient_type', 'Evacuee')
            ->where('evacuees.evacuation_center_id', $evacuation_center->id)
            ->whereNull('evacuees.date_discharged')
            ->whereNull('disaster_responses.date_ended')
            ->select('family_members.family_code', 'name')
            ->get();
        return view('camp-manager.evacuees.discharge', ['family_members' => $family_members]);
    }
    public function discharge(Request $request)
    {
        $validated = $request->validate([
            'checkedEvacuees'              => ['required'],
        ]);
        $family_codes =  Array();
        foreach ($request->checkedEvacuees as $checkedEvacuee) {
            if(!in_array($checkedEvacuee, $family_codes)){
            array_push($family_codes, $checkedEvacuee);
            $findRelief_recipient = DB::table('relief_recipients')->where('family_code', $checkedEvacuee)->get();
                if ($findRelief_recipient != null) {
                    foreach ($findRelief_recipient as $found_relief_recipient) {
                        $relief_recipient = ReliefRecipient::find($found_relief_recipient->id);
                        $relief_recipient->recipient_type = 'Non-evacuee';
                        $relief_recipient->save();

                        $findEvacuee = DB::table('evacuees')->where('relief_recipient_id', $relief_recipient->id)->where('date_discharged', null)->first();
                        if($findEvacuee != null){
                            $evacuee = Evacuee::find($findEvacuee->id);
                            $evacuee->date_discharged = now();
                            $evacuee->save();
                        }
                        
                    }
                }
            }
        }
        $request->session()->flash('message', 'Discharge Evacuee successfully!');
        return redirect()->route('cm_evacuees');
    }
    public function supplyView()
    {
        $id = Auth::id();
        $evacuation_center = EvacuationCenter::where('camp_manager_id', '=', $id)->first();
        if (empty($evacuation_center)) {
            abort(403, "You are not assigned to an evacuation center yet. Contact your adminstrator for further info.");
        }

        $evacuees = Evacuee::where('evacuation_center_id', $evacuation_center->id)->get();
        $total_number_of_evacuees = 0;
        if ($evacuees != null) {

            foreach ($evacuees as $evacuee) {
                $relief_recipient = ReliefRecipient::where('id', $evacuee->relief_recipient_id)->first();
                $family = Family::where('family_code', $relief_recipient->family_code)->first();
                $total_number_of_evacuees = $total_number_of_evacuees + $family->no_of_members;
            }
        }

        //dd($total_number_of_evacuees);

        $stock_level = $evacuation_center->stock_level()->first();
        return view('camp-manager.supply.supplies', ['total_number_of_evacuees' => $total_number_of_evacuees, 'capacity' => $evacuation_center->capacity, 'stock_level' => $stock_level]);
    }
    public function dispenseView()
    {
        $user = Auth::user();
        $evacuation_center = DB::table('evacuation_centers')->where('camp_manager_id', $user->id)->first();
        $family_members = DB::table('family_members')
            ->leftJoin('relief_recipients', 'family_members.family_code', '=', 'relief_recipients.family_code')
            ->leftJoin('disaster_responses', 'relief_recipients.disaster_response_id', '=', 'disaster_responses.id')
            ->leftJoin('evacuees', 'relief_recipients.id', '=', 'evacuees.relief_recipient_id')
            ->whereNotNull('family_members.family_code')->where('is_family_head', 'Yes')
            ->where('relief_recipients.recipient_type', 'Evacuee')
            ->where('evacuees.evacuation_center_id', $evacuation_center->id)
            ->whereNull('evacuees.date_discharged')
            ->whereNull('disaster_responses.date_ended')
            ->select('relief_recipients.family_code as rr_fc', 'name')
            ->get();
        $disaster_responses = DisasterResponse::where('date_ended', null)->get();
        $sl_evacuation_center = EvacuationCenter::where('camp_manager_id', '=', $user->id)->first();
        $stock_level = $sl_evacuation_center->stock_level()->first();

        return view('camp-manager.supply.dispense', ['disaster_responses' => $disaster_responses, 'evacuees' => $family_members, 'stock_level' => $stock_level]);
    }
    public function dispense(Request $request)
    {
        $validated = $request->validate([
            'disaster_response_id'          => ['required', 'numeric'],
            'relief_recipient_family_code'           => ['required', 'string'],
            'food_packs'                    => ['numeric', 'min:0', 'max:10000'],
            'water'                         => ['numeric', 'min:0', 'max:10000'],
            'clothes'                       => ['numeric', 'min:0', 'max:10000'],
            'hygiene_kit'                   => ['numeric', 'min:0', 'max:10000'],
            'medicine'                      => ['numeric', 'min:0', 'max:10000'],
            'emergency_shelter_assistance'  => ['numeric', 'min:0', 'max:10000'],
        ]);
        $this_rr = DB::table('relief_recipients')
        ->where('family_code',$validated['relief_recipient_family_code'])
        ->where('disaster_response_id',$validated['disaster_response_id'])->first();
    //  dd($this_rr->id);
        $user = Auth::user();

        $relief_good = new ReliefGood();
        $relief_good->field_officer_id              = $user->id;
        $relief_good->disaster_response_id          = $validated['disaster_response_id'];
        $relief_good->relief_recipient_id           = $this_rr->id;
        $relief_good->date                          = now();
        $relief_good->food_packs                    = $validated['food_packs'];
        $relief_good->water                         = $validated['water'];
        $relief_good->hygiene_kit                   = $validated['hygiene_kit'];
        $relief_good->medicine                      = $validated['medicine'];
        $relief_good->clothes                       = $validated['clothes'];
        $relief_good->emergency_shelter_assistance  = $validated['emergency_shelter_assistance'];
        $relief_good->save();

        $evacuation_center = EvacuationCenter::where('camp_manager_id', '=', $user->id)->first();
        $prev_stock = $evacuation_center->stock_level()->first();
        $evacuation_center->stock_level()->update([
            'food_packs'                    => ($prev_stock->food_packs - $relief_good->food_packs),
            'water'                         => ($prev_stock->water - $relief_good->water),
            'hygiene_kit'                   => ($prev_stock->hygiene_kit - $relief_good->hygiene_kit),
            'medicine'                      => ($prev_stock->medicine - $relief_good->medicine),
            'clothes'                       => ($prev_stock->clothes - $relief_good->clothes),
            'emergency_shelter_assistance'  => ($prev_stock->emergency_shelter_assistance - $relief_good->emergency_shelter_assistance),
        ]);
        $request->session()->flash('message', 'Dispense Supply successfully!');
        return redirect()->route('cm_supply_view');
    }
    public function requestSupplyView()
    {
        $disaster_responses = DisasterResponse::where('date_ended', null)->get();
        return view('camp-manager.supply.request')->with('disaster_responses', $disaster_responses);
    }
    public function historyView(Request $request)
    {
        $id = Auth::id();
        $delivery_requests = DeliveryRequest::where('camp_manager_id', '=', $id)
            ->orderByRaw("CASE WHEN requests.status = 'pending' THEN '1'
                WHEN requests.status = 'preparing' THEN '2'
                WHEN requests.status = 'in-transit' THEN '3'
                WHEN requests.status = 'delivered' THEN '4'
                WHEN requests.status = 'cancelled' THEN '5'
                WHEN requests.status = 'decline' THEN '6' END ASC, requests.updated_at DESC")
            ->get();
        return view('camp-manager.request.history')->with('delivery_requests', $delivery_requests);
    }
    public function detailsView($id)
    {
        $delivery_request = DeliveryRequest::find($id);
        return view('camp-manager.request.details')->with('delivery_request', $delivery_request);
    }
}