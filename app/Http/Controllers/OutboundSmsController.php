<?php

namespace App\Http\Controllers;

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
    public function successSms($sender, $message)
    {
        return response("success");
    }
}