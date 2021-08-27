<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\EvacuationCenter;
use App\Models\StockLevel;
use App\CustomClasses\UpdateMarker;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Pusher\Pusher;

class EvacuationCenterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$evacuation_centers = EvacuationCenter::paginate(5);
        //$camp_managers = User::find($evacuation_centers->input('camp_manager_id'));
        $evacuation_centers = DB::table('evacuation_centers')
            ->leftJoin('users', 'evacuation_centers.camp_manager_id', '=', 'users.id')
            ->select('evacuation_centers.*', 'users.name as camp_manager_name')
            ->orderByRaw('evacuation_centers.id ASC')
            ->paginate(20);

        return view('admin.evacuation-center.evacList', ['evacuation_centers' => $evacuation_centers]);


        // SELECT evacuation_centers.id, users.name as camp_manager_name, evacuation_centers.name,
        //     evacuation_centers.address, evacuation_centers.latitude, evacuation_centers.longitude,
        //     evacuation_centers.capacity, evacuation_centers.characteristics
        //     FROM evacuation_centers 
        //     LEFT JOIN users
        //     ON evacuation_centers.camp_manager_id = users.id
        //     ORDER BY evacuation_centers.id ASC

        // SELECT evacuation_centers.id, evacuation_centers.name, evacuation_centers.address, evacuation_centers.latitude,
        //     evacuation_centers.longitude, evacuation_centers.capacity, evacuation_centers.characteristics,
        //     stock_levels.food_packs, stock_levels.water, stock_levels.hygiene_kit, stock_levels.medicine,
        //     stock_levels.clothes, stock_levels.emergency_shelter_assistance
        //     FROM public.evacuation_centers 
        //     INNER JOIN public.stock_levels
        //     ON evacuation_centers.id = stock_levels.evacuation_center_id
        //     ORDER BY evacuation_centers.id ASC
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $camp_managers = User::where('officer_type', 'Camp Manager')
        //     ->join('camp_managers', 'camp_managers.user_id', '=', 'users.id')
        //     ->select('users.*')
        //     ->get();
        $camp_managers = DB::table('users')
            ->join('camp_managers', 'camp_managers.user_id', '=', 'users.id')
            ->leftJoin('evacuation_centers', 'evacuation_centers.camp_manager_id', '=', 'users.id')
            ->whereNull('evacuation_centers.camp_manager_id')
            ->select('users.id', 'users.name')
            ->orderByRaw('users.name ASC')
            ->get();

        //dd($camp_managers);
        return view('admin.evacuation-center.create', ['camp_managers' => $camp_managers]);
        //return $camp_managers;

        // SELECT users.id, users.name
        // FROM users
        // JOIN camp_managers
        // ON camp_managers.user_id = users.id
        // WHERE 
        // (SELECT evacuation_centers.camp_manager_id 
        // FROM evacuation_centers
        // WHERE camp_manager_id IS NOT NULL) != camp_managers.user_id

        // SELECT users.id, users.name
        // FROM users
        // JOIN camp_managers
        // ON camp_managers.user_id = users.id
        // LEFT JOIN evacuation_centers
        // ON evacuation_centers.camp_manager_id  = users.id
        // WHERE evacuation_centers.camp_manager_id ISNULL
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'camp_manager_id'  => 'nullable',
            'name'             => 'required|unique:evacuation_centers,name|min:1|max:128',
            'address'          => 'required|min:1|max:256',
            'latitude'         => 'required',
            'longitude'        => 'required',
            'capacity'         => 'required|numeric',
            'characteristics'  => 'required'
        ]);
        //$user = Auth::user();
        $evacuation_center = new EvacuationCenter();
        $evacuation_center->name = $request->input('name');
        $evacuation_center->address = $request->input('address');
        $evacuation_center->camp_manager_id = $request->input('camp_manager_id');
        $evacuation_center->capacity = $request->input('capacity');
        $evacuation_center->characteristics = $request->input('characteristics');
        $evacuation_center->latitude = $request->input('latitude');
        $evacuation_center->longitude = $request->input('longitude');
        //$evac->user_id = $user->id;
        $evacuation_center->save();

        $stock_level =  StockLevel::create([
            'evacuation_center_id' => $evacuation_center->id,
        ]);

        $request->session()->flash('message', 'Successfully created evacuation center');

        $updatemarker = new UpdateMarker;
        $updatemarker->get_evac();

        return redirect()->route('evacuation-center.index');        //or can be redirected to create

        //$bc = User::find($user->id)->user_inventory->name;
        //dd($evac->camp_manager_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EvacuationCenter  $evacuationCenter
     * @return \Illuminate\Http\Response
     */
    public function show(EvacuationCenter $evacuationCenter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EvacuationCenter  $evacuationCenter
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $id = $request->input('id');
        $evacuation_center = EvacuationCenter::find($id);
        //$evacuation_centers= EvacuationCenter::where('id', '=', $request->input('id'))->first();
        // $camp_managers = User::where('officer_type', 'Camp Manager')
        //     ->join('camp_managers', 'camp_managers.user_id', '=', 'users.id')
        //     ->select('users.*')
        //     ->get();
        $camp_managers = DB::table('users')
            ->join('camp_managers', 'camp_managers.user_id', '=', 'users.id')
            ->leftJoin('evacuation_centers', 'evacuation_centers.camp_manager_id', '=', 'users.id')
            ->whereNull('evacuation_centers.camp_manager_id')
            ->orWhere('evacuation_centers.camp_manager_id', $evacuation_center->camp_manager_id)
            ->select('users.id', 'users.name')
            ->orderByRaw('users.name ASC')
            ->get();
        //return $evacuation_center->camp_manager_id;
        return view('admin.evacuation-center.edit', ['evacuation_center' => $evacuation_center, 'camp_managers' => $camp_managers]);

        // SELECT users.id, users.name
        // FROM users
        // JOIN camp_managers
        // ON camp_managers.user_id = users.id
        // LEFT JOIN evacuation_centers
        // ON evacuation_centers.camp_manager_id  = users.id
        // WHERE evacuation_centers.camp_manager_id ISNULL
        // OR evacuation_centers.camp_manager_id = 3
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EvacuationCenter  $evacuationCenter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'id'               => 'required|numeric',
            'camp_manager_id'  => 'nullable',
            'name'             => 'required|unique:evacuation_centers,name|min:1|max:128',
            'address'          => 'required|min:1|max:256',
            'latitude'         => 'required',
            'longitude'        => 'required',
            'capacity'         => 'required|numeric',
            'characteristics'  => 'required'
        ]);
        $evacuation_center = EvacuationCenter::where('id', '=', $request->input('id'))->first();
        $evacuation_center->name = $request->input('name');
        $evacuation_center->address = $request->input('address');
        $evacuation_center->camp_manager_id = $request->input('camp_manager_id');
        $evacuation_center->capacity = $request->input('capacity');
        $evacuation_center->characteristics = $request->input('characteristics');
        $evacuation_center->latitude = $request->input('latitude');
        $evacuation_center->longitude = $request->input('longitude');
        $evacuation_center->save();
        $request->session()->flash('message', 'Successfully updated ' . $evacuation_center->name . ' evacuation center');

        $updatemarker = new UpdateMarker;
        $updatemarker->get_evac();

        return redirect()->route('evacuation-center.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EvacuationCenter  $evacuationCenter
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $evacuation_center = EvacuationCenter::find($request->input('id'));
        $evacuation_center->stock_level()->delete();
        $evacuation_center->delete();
        $request->session()->flash('message', 'Successfully deleted ' . $evacuation_center->name . ' evacuation center');

        $updatemarker = new UpdateMarker;
        $updatemarker->get_evac();

        return redirect()->route('evacuation-center.index');
    }
}