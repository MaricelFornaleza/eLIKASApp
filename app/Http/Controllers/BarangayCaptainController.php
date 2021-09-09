<?php

namespace App\Http\Controllers;

use App\Models\Supply;
use Illuminate\Http\Request;

use App\Models\DisasterResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Carbon\Carbon;
use App\Models\ReliefGood;
use App\Models\Inventory;
class BarangayCaptainController extends Controller
{
    public function addSupply()
    {
        return view('barangay-captain.supply.add');
    }
    public function dispenseView()
    {
        
        $disaster_responses = DisasterResponse::where('date_ended', null)->get();

        $user = Auth::user();
        $barangay_captain =DB::table('barangay_captains')->where('user_id', $user->id)->first();
        $bc_inventory =DB::table('inventories')->where('user_id', $user->id)->first();
        $family_members = DB::table('family_members')
            ->leftJoin('relief_recipients', 'family_members.family_code', '=', 'relief_recipients.family_code')
            ->leftJoin('disaster_responses', 'relief_recipients.disaster_response_id', '=', 'disaster_responses.id')
            ->whereNotNull('family_members.family_code')
            ->where('family_members.barangay', $barangay_captain->barangay)
            ->where('is_family_head', 'Yes')
            ->where('relief_recipients.recipient_type', 'Non-evacuee')
            ->whereNull('disaster_responses.date_ended')
            ->select('relief_recipients.family_code as rr_fc', 'name')
            ->get();

        return view('barangay-captain.supply.dispense', 
        ['disaster_responses' => $disaster_responses,
        'non_evacuees' => $family_members,
        'bc_inventory' => $bc_inventory]);
    }
    public function dispense(Request $request)
    {
        $validated = $request->validate([
            'disaster_response_id'          => ['required', 'numeric'],
            'relief_recipient_family_code'  => ['required', 'string'],
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

        $bc_inventory = Inventory::where('user_id', '=', $user->id)->first();
        $bc_inventory->update([
            'total_no_of_food_packs'                    => ($bc_inventory->total_no_of_food_packs - $relief_good->food_packs),
            'total_no_of_water'                         => ($bc_inventory->total_no_of_water - $relief_good->water),
            'total_no_of_hygiene_kit'                   => ($bc_inventory->total_no_of_hygiene_kit - $relief_good->hygiene_kit),
            'total_no_of_medicine'                      => ($bc_inventory->total_no_of_medicine - $relief_good->medicine),
            'total_no_of_clothes'                       => ($bc_inventory->total_no_of_clothes - $relief_good->clothes),
            'total_no_of_emergency_shelter_assistance'  => ($bc_inventory->total_no_of_emergency_shelter_assistance - $relief_good->emergency_shelter_assistance),
        ]);
        $request->session()->flash('message', 'Dispense Supply successfully!');
        return redirect()->route('home');
        
    }
    public function detailsView($id)
    {
        $supply = Supply::find($id);
        return view('barangay-captain.supply.details')->with('supply', $supply);
    }
    public function listView()
    {
        $user = Auth::user();
        $barangay_captain = DB::table('barangay_captains')->where('user_id', $user->id)->first();
        $non_evacuees = DB::table('family_members')
                ->leftJoin('relief_recipients', 'family_members.family_code', '=', 'relief_recipients.family_code')
                ->leftJoin('disaster_responses', 'relief_recipients.disaster_response_id', '=', 'disaster_responses.id')
                ->whereNotNull('family_members.family_code')
                ->where('family_members.barangay', $barangay_captain->barangay)
                ->where('relief_recipients.recipient_type', 'Non-evacuee')
                ->whereNull('disaster_responses.date_ended')
                ->select('name')
                ->get();
        return view('barangay-captain.non-evacuees.list', ['non_evacuees' => $non_evacuees]);
    }
}