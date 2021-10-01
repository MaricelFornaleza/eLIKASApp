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
                return $this->discharge($data);
                break;
            case 'dispense':
                return $this->dispense($data);
                break;
            case 'request':
                return $this->request($data);
                break;
            case 'viewEvacuees':
                return $this->viewEvacuees($data);
                break;
            case 'viewSupply':
                return $this->viewSupply($data);
                break;
            case 'viewNonEvacuees':
                return $this->viewNonEvacuees($data);
                break;
            case 'addSupply':
                return $this->addSupply($data);
                break;
            default:

                break;
        };
    }
    public function admit($data)
    {
        return response("admit success");
    }
    public function discharge($data)
    {
        return;
    }
    public function dispense($data)
    {
        return;
    }
    public function request($data)
    {
        return;
    }
    public function viewEvacuees($data)
    {
        return;
    }
    public function viewSupply($data)
    {
        return;
    }
    public function viewNonEvacuees($data)
    {
        return;
    }
    public function addSupply($data)
    {
        return;
    }
}