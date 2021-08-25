<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BarangayCaptainController extends Controller
{
    public function barangayStats()
    {
        return view('barangay-captain.barangay');
    }
}