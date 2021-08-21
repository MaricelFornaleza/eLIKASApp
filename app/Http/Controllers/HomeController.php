<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $role = Auth::user()->officer_type;
        $photo = Auth::user()->photo;
        if ($role == 'Administrator') {
            return view('admin.home')->with('photo', $photo);
        } elseif ($role == 'Camp Manager') {
            return view('barangay-captain.home')->with('photo', $photo);
        } elseif ($role == 'Barangay Captain') {
            return view('camp-manager.home')->with('photo', $photo);
        } elseif ($role == 'Courier') {
            return view('courier.home')->with('photo', $photo);
        }
    }
}