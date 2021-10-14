<?php

namespace App\Http\Controllers\api;

use App\Models\Location;
use App\CustomClasses\UpdateMarker;
use App\Http\Controllers\Controller;
use App\Models\InboundSms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RestAPIController extends Controller
{
    public function updateCourierLocation(Request $request)
    {
        $validated = $request->validate([
            'courier_id'    => ['required', 'numeric'],
            'latitude'      => ['required'],
            'longitude'     => ['required'],
        ]);

        Location::where('courier_id', $validated['courier_id'])->update([
            'latitude'   => $validated['latitude'],
            'longitude'  => $validated['longitude'],
        ]);

        $updatemarker = new UpdateMarker;
        $updatemarker->get_couriers();

        return ["status" => "success"];
    }

    public function disasterResponses()
    {
        $disaster_responses = DB::table('disaster_responses')
            ->where('date_ended', null)
            ->select('id', 'disaster_type as type')
            ->get();

        return response()->json($disaster_responses);
    }

    public function phoneNum($id)
    {
        $disaster_responses = DB::table('users')
            ->where('id', $id)
            ->select('contact_no')
            ->first();

        return response()->json($disaster_responses);
    }

    public function affectedResidents()
    {
        $family_members = DB::table('family_members')
            ->leftJoin('affected_residents', 'family_members.family_code', '=', 'affected_residents.family_code')
            ->leftJoin('disaster_responses', 'affected_residents.disaster_response_id', '=', 'disaster_responses.id')
            ->whereNotNull('family_members.family_code')
            ->whereNotNull('affected_residents.id')->where('affected_residents.affected_resident_type', 'Non-evacuee')
            ->whereNull('disaster_responses.date_ended')
            ->select(
                'affected_residents.id',
                'name',
                'family_members.family_code',
                'family_members.sectoral_classification',
                'family_members.is_family_head',
                'affected_residents.affected_resident_type as type'
            )
            ->distinct()
            ->get();
        return response()->json($family_members);
    }
    public function barangayResidents($barangay)
    {
        $non_evacuees = DB::table('family_members')
            ->leftJoin('affected_residents', 'family_members.family_code', '=', 'affected_residents.family_code')
            ->leftJoin('disaster_responses', 'affected_residents.disaster_response_id', '=', 'disaster_responses.id')
            ->whereNotNull('family_members.family_code')
            ->where('is_family_head', 'Yes')
            ->where('family_members.barangay', $barangay)
            ->where('affected_residents.affected_resident_type', 'Non-evacuee')
            ->whereNull('disaster_responses.date_ended')
            ->select(
                'affected_residents.id as id',
                'name',
                'family_members.family_code',
                'family_members.sectoral_classification',
                'family_members.is_family_head',
                'affected_residents.affected_resident_type as type'
            )
            ->get();
        return response()->json($non_evacuees);
    }
    public function evacuees($id)
    {
        $evacuation_center = DB::table('evacuation_centers')->where('camp_manager_id', $id)->first();
        $evacuees = DB::table('family_members')
            ->leftJoin('affected_residents', 'family_members.family_code', '=', 'affected_residents.family_code')
            ->leftJoin('disaster_responses', 'affected_residents.disaster_response_id', '=', 'disaster_responses.id')
            ->leftJoin('evacuees', 'affected_residents.id', '=', 'evacuees.affected_resident_id')
            ->whereNotNull('family_members.family_code')
            ->where('affected_residents.affected_resident_type', 'Evacuee')
            ->where('evacuees.evacuation_center_id', $evacuation_center->id)
            ->whereNull('evacuees.date_discharged')
            ->whereNull('disaster_responses.date_ended')
            ->select('family_members.family_code', 'family_members.sectoral_classification', 'name', 'affected_residents.affected_resident_type')
            ->distinct()
            ->get();
        $family_members = DB::table('family_members')
            ->leftJoin('affected_residents', 'family_members.family_code', '=', 'affected_residents.family_code')
            ->leftJoin('disaster_responses', 'affected_residents.disaster_response_id', '=', 'disaster_responses.id')
            ->whereNotNull('family_members.family_code')
            ->whereNotNull('affected_residents.id')->where('affected_residents.affected_resident_type', 'Non-evacuee')
            ->whereNull('disaster_responses.date_ended')
            ->select('family_members.family_code', 'family_members.sectoral_classification', 'name', 'affected_residents.affected_resident_type')
            ->distinct()
            ->get();
        $merged = $family_members->merge($evacuees);
        return response()->json($merged);
    }
}