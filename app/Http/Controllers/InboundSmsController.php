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
        $data = [
            "sender" => $sms->sender_address,
            "message" => $message
        ];
        switch ($message[0]) {
            case 'admit':
                return $this->admit($data);
                break;
            case 'discharge':
                # code...
                break;
            case 'dispense':
                # code...
                break;
            case 'request':
                # code...
                break;
            case 'viewEvacuees':
                return response()->json($message);
                break;
            case 'viewSupply':
                # code...
                break;
            case 'viewNonEvacuees':
                return response()->json($message);
                break;
            case 'addSupply':
                # code...
                break;
            default:
                # code...
                break;
        };
    }
    public function admit($data)
    {
        return response("admit success");
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