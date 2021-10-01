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
        return response("success");
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