<?php

namespace App\Http\Controllers;

use App\Models\EvacuationCenter;
use App\Models\InboundSms;
use App\Models\ReliefRecipient;
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
        $sender = $sms->sender_address;
        switch ($message[0]) {
            case 'admit':
                return $this->admit($sender, $message);
                break;
            case 'discharge':
                return $this->discharge($sender, $message);
                break;
            case 'dispense':
                return $this->dispense($sender, $message);
                break;
            case 'request':
                return $this->request($sender, $message);
                break;
            case 'viewEvacuees':
                return $this->viewEvacuees($sender, $message);
                break;
            case 'viewSupply':
                return $this->viewSupply($sender, $message);
                break;
            case 'viewNonEvacuees':
                return $this->viewNonEvacuees($sender, $message);
                break;
            case 'addSupply':
                return $this->addSupply($sender, $message);
                break;
            default:

                break;
        };
    }
    public function admit($sender, $message)
    {
        $evac_center = EvacuationCenter::where('camp_manager_id', $message[1])->first();
        $names = ReliefRecipient::whereIn('family_code', $message)->get();
        return response()->json($names);
    }
    public function discharge($sender, $message)
    {
        return;
    }
    public function dispense($sender, $message)
    {
        return;
    }
    public function request($sender, $message)
    {
        return;
    }
    public function viewEvacuees($sender, $message)
    {
        return;
    }
    public function viewSupply($sender, $message)
    {
        return;
    }
    public function viewNonEvacuees($sender, $message)
    {
        return;
    }
    public function addSupply($sender, $message)
    {
        return;
    }
}