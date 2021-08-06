<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        if (Auth::user()->hasRole('admin')) {
            return view('admin.home');
        } elseif (Auth::user()->hasRole('barangay_captain')) {
            return view('barangay-captain.home');
        } elseif (Auth::user()->hasRole('camp_manager')) {
            return view('camp-manager.home');
        } elseif (Auth::user()->hasRole('courier')) {
            return view('courier.home');
        }
    }
}
