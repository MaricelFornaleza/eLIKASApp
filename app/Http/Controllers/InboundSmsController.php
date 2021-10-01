<?php

namespace App\Http\Controllers;

use App\Models\InboundSms;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class InboundSmsController extends Controller
{
    public function decodesms($id)
    {
        $sms = InboundSms::where('id', $id)->first();
        $message = explode(',', $sms->message);
        switch ($message[0]) {
            case 'admit':
                return response()->json($message);
                break;

            default:
                # code...
                break;
        };
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