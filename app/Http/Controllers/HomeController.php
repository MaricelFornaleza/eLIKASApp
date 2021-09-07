<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\DeliveryRequest;
use App\Models\DisasterResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $role = Auth::user()->officer_type;

        if ($role == 'Administrator') {
            if (Admin::count() == 0) {
                return view('admin.admin_resource.config-body');
            } else {
                $disaster_responses = DisasterResponse::where('date_ended', '=', null)->get();
                return view('admin.home')->with('disaster_responses', $disaster_responses);
            }

            // dd($disaster_responses);
        } elseif ($role == 'Barangay Captain') {
            $disaster_responses = DisasterResponse::where('date_ended', '=', null)->get();
            return view('barangay-captain.home')->with('disaster_responses', $disaster_responses);
        } elseif ($role == 'Camp Manager') {
            $disaster_responses = DisasterResponse::where('date_ended', '=', null)->get();
            return view('camp-manager.home')->with('disaster_responses', $disaster_responses);
        } elseif ($role == 'Courier') {
            $id = Auth::id();
            $delivery_requests = DeliveryRequest::where('courier_id', '=', $id)
                ->join('evacuation_centers', 'evacuation_centers.camp_manager_id', '=', 'requests.camp_manager_id')
                ->select('evacuation_centers.name as evacuation_center_name', 'requests.*')
                ->orderByRaw("CASE WHEN requests.status = 'pending' THEN '1'
                            WHEN requests.status = 'preparing' THEN '2'
                            WHEN requests.status = 'in-transit' THEN '3'
                            WHEN requests.status = 'delivered' THEN '4'
                            WHEN requests.status = 'cancelled' THEN '5'
                            WHEN requests.status = 'decline' THEN '6' END ASC, requests.updated_at DESC")
                ->get();

            $is_empty = DeliveryRequest::where('courier_id', '=', $id)->first();
            /*
            SELECT evacuation_centers.name, requests.*
                FROM requests
                JOIN evacuation_centers
                ON evacuation_centers.camp_manager_id = requests.camp_manager_id
                ORDER BY updated_at DESC 
            */
            return view('courier.home', ['delivery_requests' => $delivery_requests, 'is_empty' => $is_empty]);
        }
    }
}