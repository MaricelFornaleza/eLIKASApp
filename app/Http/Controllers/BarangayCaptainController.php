<?php

namespace App\Http\Controllers;

use App\Models\Supply;
use Illuminate\Http\Request;

use App\Models\DisasterResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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

        return view('barangay-captain.supply.dispense', ['disaster_responses' => $disaster_responses, 'non_evacuees' => $family_members]);
    }
    public function detailsView($id)
    {
        $supply = Supply::find($id);
        return view('barangay-captain.supply.details')->with('supply', $supply);
    }
    public function listView()
    {
        return view('barangay-captain.non-evacuees.list');
    }
}