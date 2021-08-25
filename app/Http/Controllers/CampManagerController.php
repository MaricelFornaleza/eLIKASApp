<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CampManagerController extends Controller
{
    public function evacuationCenter()
    {
        return view('camp-manager.evacuation-center');
    }
}