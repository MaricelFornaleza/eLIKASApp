<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\InboundSms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RestAPIController extends Controller
{
    public function affectedResidents()
    {
        $family_members = DB::table('family_members')
            ->leftJoin('relief_recipients', 'family_members.family_code', '=', 'relief_recipients.family_code')
            ->leftJoin('disaster_responses', 'relief_recipients.disaster_response_id', '=', 'disaster_responses.id')
            ->whereNotNull('family_members.family_code')
            ->whereNotNull('relief_recipients.id')->where('relief_recipients.recipient_type', 'Non-evacuee')
            ->whereNull('disaster_responses.date_ended')
            ->select('family_members.family_code', 'family_members.sectoral_classification', 'name')
            ->distinct()
            ->get();
        return response()->json($family_members);
    }
    public function barangayResidents($barangay)
    {
        $non_evacuees = DB::table('family_members')
            ->leftJoin('relief_recipients', 'family_members.family_code', '=', 'relief_recipients.family_code')
            ->leftJoin('disaster_responses', 'relief_recipients.disaster_response_id', '=', 'disaster_responses.id')
            ->whereNotNull('family_members.family_code')
            ->where('is_family_head', 'Yes')
            ->where('family_members.barangay', $barangay)
            ->where('relief_recipients.recipient_type', 'Non-evacuee')
            ->whereNull('disaster_responses.date_ended')
            ->select('family_members.is_family_head',  'name', 'family_members.family_code')
            ->get();
        return response()->json($non_evacuees);
    }
}