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

class CampManagerController extends Controller
{
    public function evacuees()
    {
        return view('camp-manager.evacuees.evacuees');
    }
    public function admitView()
    {
        $family_members = DB::table('family_members')->whereNotNull('family_code')->where('is_family_head', 'Yes')->select('id', 'name')->get();
        return view('camp-manager.evacuees.admit', ['family_members' => $family_members]);
    }
    public function selectFam(Request $request)
    {
       // dd($request->checkedResidents);
       $family_members=array();
       foreach ($request->checkedResidents as $checkedResident) {
        $family_member = FamilyMember::find($checkedResident);
            if($family_member){
                array_push($family_members, $family_member);
            }
        }
        //dd($family_members);
        // $disaster_responses = DisasterResponse::all();
        // return view('camp-manager.evacuees.group-fam', ['disaster_responses' => $disaster_responses, 'family_members' => $family_members]);
    }
    // public function admit(Request $request)
    // {
    //    // dd($request->selectedResidents, $request->selectedRepresentative);
    // //    $family_members=array();
    // //    foreach ($request->checkedResidents as $checkedResident) {
    // //     $family_member = FamilyMember::find($checkedResident);
    // //         if($family_member){
    // //             array_push($family_members, $family_member);
    // //         }
    // //     }
    // //     //dd($family_members);
    // //      $disaster_responses = DisasterResponse::all();
    // //      return view('camp-manager.evacuees.group-fam', ['disaster_responses' => $disaster_responses, 'family_members' => $family_members]);
    //     $family_code = 'eLIKAS-' . Str::random(6);
    //     if($request->selectedResidents){
    //         foreach ($request->selectedResidents as $selectedResident) {
    //         $family_member = FamilyMember::find($selectedResident);
    //         $family_member->family_code   = $family_code;
    //         $family_member->save();
    //         }
    //     }

    //     $family_member_rep = FamilyMember::find($request->selectedRepresentative);
    //     $family_member_rep->is_representative = 'Yes';
    //     $family_member_rep->save();

    //     $relief_recipient = new ReliefRecipient();
    //     $relief_recipient->family_code     = $family_code;
    //     $relief_recipient->no_of_members     = count($request->selectedResidents);
    //     $relief_recipient->address     = 'N/A';
    //     $relief_recipient->recipient_type     = 'Evacuee';
    //     $relief_recipient->save();

    //     $user = Auth::user();
    //     $evacuation_center = DB::table('evacuation_centers')->where('camp_manager_id', $user->id)->first();
    //   //  $evacuation_center = CampManager::find($camp_manager->user_id)->evacuation_center;
        
    //   // dd($evacuation_center);

    //     $evacuee = new Evacuee();
    //     $evacuee->relief_recipient_id = $relief_recipient->id;
    //     $evacuee->evacuation_center_id = $evacuation_center->id;
    //     $evacuee->save();
        
    //     $request->session()->flash('message', 'Admit Resident successfully!');
    //     return view('camp-manager.evacuees.evacuees');
    // }
    public function dischargeView()
    {
        return view('camp-manager.evacuees.discharge');
    }
    public function supplyView()
    {
        $id = Auth::id();
        $evacuation_center = EvacuationCenter::where('camp_manager_id', '=', $id)->first();
        $stock_level = $evacuation_center->stock_level()->first();
        return view('camp-manager.supply.supplies')->with('stock_level', $stock_level);
    }
    public function dispenseView()
    {
        return view('camp-manager.supply.dispense');
    }
    public function requestSupplyView()
    {
        $disaster_responses = DisasterResponse::all();
        return view('camp-manager.supply.request')->with('disaster_responses', $disaster_responses);
    }
    public function historyView(Request $request)
    {
        $delivery_requests = DeliveryRequest::orderByRaw("CASE WHEN requests.status = 'pending' THEN '1'
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