<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Barangay;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function adminConfig(Request $request)
    {
        $data = $request->validate([
            'region' => ['required', 'string', 'max:255'],
            'province' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'barangays' => ['required']
        ]);
        $user = Auth::id();
        Admin::create([
            'user_id' => $user,
            'region' =>  $data['region'],
            'province' =>  $data['province'],
            'city' =>  $data['city'],
        ]);
        Inventory::create([
            'user_id' => $user,
            'name' => $data['city'] . ' Inventory',
            'total_no_of_food_packs' => 0,
            'total_no_of_water' => 0,
            'total_no_of_hygiene_kit' => 0,
            'total_no_of_medicine' => 0,
            'total_no_of_clothes' => 0,
            'total_no_of_emergency_shelter_assistance' => 0,
        ]);
        $barangay = explode(",", $data['barangays'][0]);
        $data = [];
        foreach ($barangay as $index) {
            $data[] = [
                'name' => $index,
            ];
        }
        Barangay::insert($data);
        Session::flash('message', 'Success!');
        return redirect()->back();
    }
}