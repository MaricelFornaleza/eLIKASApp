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
            'name' => $data['city'] . ' Inventory'
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