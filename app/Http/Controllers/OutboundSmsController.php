<?php

namespace App\Http\Controllers;

use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class OutboundSmsController extends Controller
{
    public function requestReply($data)
    {
        # code...
    }
    public function evacueesReply($data)
    {
        # code...
    }
    public function supplyReply($data)
    {
        # code...
    }
    public function nonEvacueesReply($data)
    {
        # code...
    }
    public function successSms($address, $message)
    {
        $http = new Client();
        $user = User::where('contact_no', $address)->first();
        $access_token = $user->globe_labs_access_token;
        $response = $http->post("https://devapi.globelabs.com.ph/smsmessaging/v1/outbound/0098/requests?access_token=" . $access_token, [
            "form_params" => [
                "address" => $address,
                "senderAddress" => env('SHORT_CODE_SUFFIX'),
                "clientCorrelator" => env('SHORT_CODE'),
                "message" => $message,

            ]
        ]);
        return response("success");
    }
}