<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\InboundSms;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;

class SmsController extends Controller
{
    public function receiveSMS(Request $request)
    {
        if ($request != "") {
            $inboundSMSMessage = $request['inboundSMSMessageList']['inboundSMSMessage'];

            $inboundsms = InboundSms::create([
                'time_sent' => $inboundSMSMessage[0]['dateTime'],
                'destination_address' => substr($inboundSMSMessage[0]['destinationAddress'], -8),
                'message' => $inboundSMSMessage[0]['message'],
                'sender_address' => substr($inboundSMSMessage[0]['senderAddress'], -10),

            ]);

            Log::info($inboundsms);
            return response()->json($inboundsms->message);
        }
    }
    public function subscribe()
    {
        if (isset($_GET['access_token']) && $_GET['access_token'] != "") {
            $user = User::where('contact_no', $_GET['subscriber_number'])->first();
            $user->globe_labs_access_token = $_GET['access_token'];
            $user->save();
        } else {

            Log::info("No access token");
        }
    }
    public function unsubscribe(Request $request)
    {
        $subscriber_number = $request['unsubscribed']['subscriber_number'];
        $user = User::where('contact_no', $subscriber_number)->first();
        $user->globe_labs_access_token = null;
        $user->save();
    }
}