<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CampManagerController extends Controller
{
    public function evacuationCenter()
    {
        return view('camp-manager.evacuation-center');
    }
    public function evacuees()
    {
        return view('camp-manager.evacuees.evacuees');
    }
    public function admitView()
    {
        return view('camp-manager.evacuees.admit');
    }
    public function groupFam()
    {
        return view('camp-manager.evacuees.group-fam');
    }
    public function dischargeView()
    {
        return view('camp-manager.evacuees.discharge');
    }
    public function supplyView()
    {
        return view('camp-manager.supply.supplies');
    }
    public function dispenseView()
    {
        return view('camp-manager.supply.dispense');
    }
}