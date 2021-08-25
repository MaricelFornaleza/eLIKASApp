<?php

namespace App\Http\Controllers;

use App\Models\EvacuationCenter;
use App\Models\StockLevel;
use App\Models\Courier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Pusher\Pusher;

class MapController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$evacuation_centers = EvacuationCenter::all();
        $evacuation_centers = DB::table('evacuation_centers')
            ->join('stock_levels', 'evacuation_centers.id', '=', 'stock_levels.evacuation_center_id')
            ->select('evacuation_centers.*', 'stock_levels.food_packs', 'stock_levels.water', 'stock_levels.hygiene_kit', 'stock_levels.medicine',
                'stock_levels.clothes', 'stock_levels.emergency_shelter_assistance')
            ->orderByRaw('evacuation_centers.id ASC')
            ->get();

       $couriers = DB::table('couriers')
            ->leftJoin('users', 'couriers.user_id', '=', 'users.id')
            ->leftJoin('locations', 'couriers.user_id', '=', 'locations.courier_id')
            ->select('users.id', 'users.name', 'locations.latitude', 'locations.longitude', 'locations.updated_at')
            ->orderByRaw('users.name ASC')
            ->get();

        return view('admin.map')->with(compact('evacuation_centers'))->with(compact('couriers'));
        //return view('admin.map', $evacuation_centers );
        //echo json_encode($evacuation_centers);
    }

    public function get_evac()
    {
        //$evacuation_centers = EvacuationCenter::all();
        //$stock_levels = StockLevel::all();
        //$combine = [$evacuation_centers, $stock_levels];
        //return response()->json( $combine );
        //return ['evacuation_centers' => $evacuation_centers, 'stock_levels' => $stock_levels];

        // SELECT evacuation_centers.id, evacuation_centers.name, evacuation_centers.address, evacuation_centers.latitude,
        //     evacuation_centers.longitude, evacuation_centers.capacity, evacuation_centers.characteristics,
        //     stock_levels.food_packs, stock_levels.water, stock_levels.hygiene_kit, stock_levels.medicine,
        //     stock_levels.clothes, stock_levels.emergency_shelter_assistance
        //     FROM public.evacuation_centers 
        //     INNER JOIN public.stock_levels
        //     ON evacuation_centers.id = stock_levels.evacuation_center_id
        //     ORDER BY evacuation_centers.id ASC

        $evacuation_centers = DB::table('evacuation_centers')
            ->join('stock_levels', 'evacuation_centers.id', '=', 'stock_levels.evacuation_center_id')
            ->select('evacuation_centers.*', 'stock_levels.food_packs', 'stock_levels.water', 'stock_levels.hygiene_kit', 'stock_levels.medicine',
                'stock_levels.clothes', 'stock_levels.emergency_shelter_assistance')
            ->orderByRaw('evacuation_centers.id ASC')
            ->get();
            
        //return [ 'evacuation_centers' => $evacuation_centers ];

        $options  = array(
            'cluster' => 'ap1',
            'useTLS' => true
        );

        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_id'),
            $options
        );

        $data = ['evacuation_centers' => $evacuation_centers];
        $pusher->trigger('my-channel', 'my-event', $data);

    }

    public function get_couriers()
    {
        //$couriers = Courier::all();
        $couriers = DB::table('couriers')
            ->join('locations', 'couriers.id', '=', 'locations.courier_id')
            ->select('couriers.*', 'locations.latitude', 'locations.longitude', 'locations.updated_at')
            ->orderByRaw('couriers.id ASC')
            ->get();
        
        return [ 'couriers' => $couriers ];
    }

    public function get_locations($id)
    {
        $evacuation_center = EvacuationCenter::find($id);
        //$couriers = Courier::all();
        $couriers =  DB::table('couriers')
            ->leftJoin('users', 'couriers.user_id', '=', 'users.id')
            ->leftJoin('locations', 'couriers.user_id', '=', 'locations.courier_id')
            ->select('users.id', 'users.name', 'locations.latitude', 'locations.longitude', 'locations.updated_at')
            ->orderByRaw('users.name ASC')
            ->get();
        // SELECT couriers.user_id, users.name, locations.latitude, locations.longitude, locations.updated_at
        // FROM couriers
        // LEFT JOIN users
        // ON couriers.user_id = users.id
        // LEFT JOIN locations
        // ON couriers.user_id = locations.courier_id
        // ORDER BY users.name ASC

        $data = ['couriers' => $couriers, 'evacuation_center' => $evacuation_center];
        //dd($data);
        //print_r(json_encode($data));
        return $data;
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
        //
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
        //
    }
}
