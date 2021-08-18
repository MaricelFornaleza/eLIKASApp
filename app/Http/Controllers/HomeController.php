<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $role = Auth::user()->officer_type;
        if ($role == 'Administrator') {
            return view('admin.home');
        } elseif ($role == 'Camp Manager') {
            return view('barangay-captain.home');
        } elseif ($role == 'Barangay Captain') {
            return view('camp-manager.home');
        } elseif ($role == 'Courier') {
            return view('courier.home');
        }
    }
}