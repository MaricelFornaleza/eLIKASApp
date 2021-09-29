<?php

namespace App\Http\Controllers;

use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class InboundSmsController extends Controller
{
    public function decodesms()
    {
        $http = new Client();
        $user = User::where('contact_no', '9772779609')->first();
        $access_token = $user->globe_labs_access_token;
        $response = $http->post("https://devapi.globelabs.com.ph/smsmessaging/v1/outbound/0098/requests?access_token=" . $access_token, [
            "senderAddress" => env('SHORT_CODE_SUFFIX'),
            "clientCorrelator" => env('SHORT_CODE'),
            "message" => "Text received",
            "address" => "9772779609"

        ]);
        Log::info($response->getBody());
    }
    public function admit($data)
    {
        # code...
    }
    public function discharge($data)
    {
        # code...
    }
    public function dispense($data)
    {
        # code...
    }
    public function request($data)
    {
        # code...
    }
    public function viewEvacuees($data)
    {
        # code...
    }
    public function viewSupply($data)
    {
        # code...
    }
    public function viewNonEvacuees($data)
    {
        # code...
    }
    public function addSupply($data)
    {
        # code...
    }
}