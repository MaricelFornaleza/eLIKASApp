<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CourierController extends Controller
{
    public function details()
    {
        return view('courier.delivery_details');
    }
}