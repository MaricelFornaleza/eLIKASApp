<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $role = Auth::user()->officer_type;
        if ($role == 'admin') {
            return view('admin.home');
        } elseif ($role == 'camp_manager') {
            return view('barangay-captain.home');
        } elseif ($role == 'barangay_captain') {
            return view('camp-manager.home');
        } elseif ($role == 'courier') {
            return view('courier.home');
        }
    }
}