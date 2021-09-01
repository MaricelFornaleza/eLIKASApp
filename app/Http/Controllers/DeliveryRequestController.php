<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\CampManager;
use App\Models\DeliveryRequest;
use App\Models\EvacuationCenter;
use App\CustomClasses\UpdateRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Pusher\Pusher;

class DeliveryRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $delivery_requests = DB::table('requests')
            ->leftJoin('users', 'requests.camp_manager_id', '=', 'users.id')
            ->leftJoin('evacuation_centers', 'evacuation_centers.camp_manager_id', '=', 'requests.camp_manager_id')
            ->select(
                'users.name as camp_manager_name',
                'evacuation_centers.name as evacuation_center_name',
                'evacuation_centers.id as evacuation_center_id',
                'requests.*')
            //->orderByRaw('updated_at DESC')
            ->orderByRaw("CASE WHEN requests.status = 'pending' THEN '1'
                            WHEN requests.status = 'preparing' THEN '2'
                            WHEN requests.status = 'in-transit' THEN '3'
                            WHEN requests.status = 'delivered' THEN '4'
                            WHEN requests.status = 'cancelled' THEN '5'
                            WHEN requests.status = 'decline' THEN '6' END ASC, requests.updated_at DESC")
            ->paginate(20);

        // SELECT users.name as camp_manager_name, evacuation_centers.name as evacuation_center_name, requests.*
        // FROM public.requests
        // LEFT JOIN users
        // ON requests.camp_manager_id = users.id
        // LEFT JOIN evacuation_centers
        // ON evacuation_centers.camp_manager_id = requests.camp_manager_id
        // ORDER BY updated_at ASC

        return view('admin.request_resource.requestList', ['delivery_requests' => $delivery_requests] );
    }

    public function refresh()
    {
        $delivery_requests = DB::table('requests')
            ->leftJoin('users', 'requests.camp_manager_id', '=', 'users.id')
            ->leftJoin('evacuation_centers', 'evacuation_centers.camp_manager_id', '=', 'requests.camp_manager_id')
            ->select(
                'users.name as camp_manager_name',
                'evacuation_centers.name as evacuation_center_name',
                'evacuation_centers.id as evacuation_center_id',
                'requests.*')
           ->orderByRaw("CASE WHEN requests.status = 'pending' THEN '1'
                WHEN requests.status = 'preparing' THEN '2'
                WHEN requests.status = 'in-transit' THEN '3'
                WHEN requests.status = 'delivered' THEN '4'
                WHEN requests.status = 'cancelled' THEN '5'
                WHEN requests.status = 'decline' THEN '6' END ASC, requests.updated_at DESC")
            ->paginate(20);
            
        return view('admin.request_resource.body', ['delivery_requests' => $delivery_requests] );
        // $data = [ 'delivery_requests' => $delivery_requests ];
        // return $data;
    }

    public function approve(Request $request)
    {
        $id = $request->input('id');
        $delivery_requests = DeliveryRequest::where('id', '=', $id)->first();
        $delivery_requests->status = "preparing";
        $delivery_requests->save();

        $update_requests = new UpdateRequests;
        $update_requests->refreshHistory($delivery_requests->camp_manager_id);
        // $update_requests->refreshDeliveries($delivery_requests->courier_id);

        return redirect()->back()->with('message', 'You have approved Request ID ' . $id);
    }

    public function cancel(Request $request)
    {
        $role = Auth::user()->officer_type;
        $id = $request->input('id');

        $delivery_request = DeliveryRequest::where('id', $id)->update([
            'status' => 'cancelled'
        ]);

        $request->session()->flash('message', 'You have cancelled Request ID ' . $id );

        $update_requests = new UpdateRequests;
        if ($role == 'Administrator') {
            $update_requests->refreshHistory();
            //dd($delivery_request->courier_id);
            if(!empty($delivery_request->courier_id))
                $update_requests->refreshDeliveries($delivery_request->courier_id);

            return redirect()->back();
        }
        else if ($role == 'Camp Manager') {
            $update_requests->refreshList();
            $update_requests->refreshDeliveries($delivery_request->courier_id);

            return redirect()->route('request.camp-manager.history');
        }
        else if ($role == 'Courier') {
            $update_requests->refreshList();
            $update_requests->refreshHistory();

            return redirect()->route('home');
        }
            
    }

    public function assign_courier(Request $request)
    {
        $id = $request->input('id');
        DeliveryRequest::where('id', $id)->update([
            'status' => 'preparing',
            'courier_id' => $request->input('courier_id')
        ]);

        $delivery_requests = DeliveryRequest::where('requests.id', '=', $id)
            ->leftJoin('users', 'requests.courier_id', '=', 'users.id')
            ->leftJoin('evacuation_centers', 'evacuation_centers.camp_manager_id', '=', 'requests.camp_manager_id')
            ->select('users.id', 'users.name as courier_name','evacuation_centers.name as evacuation_center_name')
            ->first();

        $update_requests = new UpdateRequests;
        //$update_requests->refreshHistory();
        $update_requests->refreshDeliveries($request->input('courier_id'));

        //dd($delivery_requests->courier_name);
        return redirect()->back()->with('message', 'You have assigned ' 
            . $delivery_requests->courier_name 
            . ' to ' 
            . $delivery_requests->evacuation_center_name);
    }

    public function receive_supplies(Request $request)
    {
        $id = $request->input('id');
        $delivery_request = DeliveryRequest::where('id', '=', $id)->first();
        
        // $user = CampManager::where('user_id', '=', $delivery_request->camp_manager_id)->first();
        $evacuation_center = EvacuationCenter::where('camp_manager_id', '=', $delivery_request->camp_manager_id)->first();
        $prev_stock = $evacuation_center->stock_level()->first();
        $evacuation_center->stock_level()->update([
            'food_packs'                    => ($prev_stock->food_packs + $delivery_request->food_packs),
            'water'                         => ($prev_stock->water + $delivery_request->water),
            'hygiene_kit'                   => ($prev_stock->hygiene_kit + $delivery_request->hygiene_kit),
            'medicine'                      => ($prev_stock->medicine + $delivery_request->medicine),
            'clothes'                       => ($prev_stock->clothes + $delivery_request->clothes),
            'emergency_shelter_assistance'  => ($prev_stock->emergency_shelter_assistance + $delivery_request->emergency_shelter_assistance),
        ]);
        $delivery_request->status = "delivered";
        $delivery_request->save();

        $update_request = new UpdateRequests;
        $update_request->refreshList();
        $update_request->refreshDeliveries($delivery_request->courier_id);
        
        return redirect()->route('request.camp-manager.history')->with('message', 'Request ID ' . $id . ' has been delivered! Check your supply inventory to confirm.');
    }

    public function courier_accept($id)
    {
        //$id = $request->input('id');
        DeliveryRequest::where('id', $id)->update([
            'status' => 'in-transit'
        ]);

        $update_requests = new UpdateRequests;
        $update_requests->refreshList();
        $update_requests->refreshHistory();

        return redirect()->route('home')->with('message', 'You have accepted Request ID ' . $id);

    }
    
    public function courier_decline(Request $request)
    {
        $id = $request->input('id');
        DeliveryRequest::where('id', $id)->update([
            'status' => 'declined'
        ]);

        $update_requests = new UpdateRequests;
        $update_requests->refreshList();
        $update_requests->refreshHistory();
        
        return redirect()->route('home')->with('message', 'You have declined Request ID ' . $id);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $validated = $request->validate([
            'disaster_response_id'          => ['required', 'numeric'],
            'food_packs'                    => ['numeric', 'min:0', 'max:10000'],
            'water'                         => ['numeric', 'min:0', 'max:10000'],
            'clothes'                       => ['numeric', 'min:0', 'max:10000'],
            'hygiene_kit'                   => ['numeric', 'min:0', 'max:10000'],
            'medicine'                      => ['numeric', 'min:0', 'max:10000'],
            'emergency_shelter_assistance'  => ['numeric', 'min:0', 'max:10000'],
            'note'                          => ['nullable'],
        ]);
        
        $evacuation_center = EvacuationCenter::where('camp_manager_id', '=', $user->id)->first();
        //dd($evacuation_center);
        if(empty($evacuation_center)){
            $request->session()->flash('error', 'You are not assigned to an evacuation center.');
            return redirect()->route('request.camp-manager.history');
        }

        $delivery_request = DeliveryRequest::create([
            'disaster_response_id'          => $validated['disaster_response_id'],
            'camp_manager_id'               => $user->id,
            'date'                          => Carbon::now(),
            'food_packs'                    => $validated['food_packs'], 
            'water'                         => $validated['water'], 
            'hygiene_kit'                   => $validated['hygiene_kit'], 
            'medicine'                      => $validated['medicine'], 
            'clothes'                       => $validated['clothes'], 
            'emergency_shelter_assistance'  => $validated['emergency_shelter_assistance'], 
            'note'                          => $validated['note'], 
            'status'                        => "pending"
        ]);
        
        $update_requests = new UpdateRequests;
        $update_requests->refreshList();

        $request->session()->flash('message', 'Successfully sent a request!');

        //TO-DO: put here dynamic updating

        return redirect()->route('request.camp-manager.history');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
    }
}
