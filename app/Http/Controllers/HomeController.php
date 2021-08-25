<?php

namespace App\Http\Controllers;

use App\Models\DisasterResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $role = Auth::user()->officer_type;

        if ($role == 'Administrator') {
            $disaster_responses = DisasterResponse::where('date_ended', '=', null)->get();
            return view('admin.home')->with('disaster_responses', $disaster_responses);
            // dd($disaster_responses);
        } elseif ($role == 'Barangay Captain') {
            $disaster_responses = DisasterResponse::where('date_ended', '=', null)->get();
            return view('barangay-captain.home');
        } elseif ($role == 'Camp Manager') {
            $disaster_responses = DisasterResponse::where('date_ended', '=', null)->get();
            return view('camp-manager.home')->with('disaster_responses', $disaster_responses);
        } elseif ($role == 'Courier') {
            return view('courier.home');
        }
    }
}