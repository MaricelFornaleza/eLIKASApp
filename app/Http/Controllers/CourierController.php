<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\DeliveryRequest;
use Illuminate\Http\Request;

class CourierController extends Controller
{
    public function details($id)
    {
        $delivery_request = DeliveryRequest::where('requests.id', '=', $id)
            ->join('evacuation_centers', 'evacuation_centers.camp_manager_id', '=', 'requests.camp_manager_id')
            ->join('users', 'users.id', '=', 'requests.camp_manager_id')
            ->select(
                'evacuation_centers.name as evacuation_center_name',
                'evacuation_centers.address',
                'users.name as camp_manager_name',
                'requests.*'
            )
            ->first();
        return view('courier.delivery_details')->with('delivery_request', $delivery_request);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'courier_id'   => ['required', 'numeric'],
            'latitude'  => ['required'],
            'longitude' => ['required'],
        ]);

        Location::where('courier_id', $validated['courier_id'])->update([
            'latitude'   => $validated['latitude'],
            'longitude'  => $validated['longitude'],
        ]);

        return ["status" => "success"];
    }
}