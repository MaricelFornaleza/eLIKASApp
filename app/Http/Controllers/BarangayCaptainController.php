<?php

namespace App\Http\Controllers;

use App\Models\Supply;
use Illuminate\Http\Request;

class BarangayCaptainController extends Controller
{
    public function addSupply()
    {
        return view('barangay-captain.supply.add');
    }
    public function dispenseView()
    {
        return view('barangay-captain.supply.dispense');
    }
    public function detailsView($id)
    {
        $supply = Supply::find($id);
        return view('barangay-captain.supply.details')->with('supply', $supply);
    }
    public function listView()
    {
        return view('barangay-captain.non-evacuees.list');
    }
}