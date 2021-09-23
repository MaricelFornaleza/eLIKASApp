<?php

namespace App\Http\Controllers;

use App\Models\EvacuationCenter;
use App\Models\StockLevel;
use App\CustomClasses\UpdateMarker;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\FamilyMember;
use App\Models\Evacuee;
use App\Models\ReliefRecipient;
use App\Models\Family;

class EvacuationCenterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allEvacuationCenters = array();
        $evacuation_centers = DB::table('evacuation_centers')
            ->leftJoin('users', 'evacuation_centers.camp_manager_id', '=', 'users.id')
            ->select('evacuation_centers.*', 'users.name as camp_manager_name')
            ->orderByRaw('evacuation_centers.id ASC')
            ->get();

        foreach ($evacuation_centers as $evacuation_center) {
            $evacuees = Evacuee::where('evacuation_center_id', $evacuation_center->id)->whereNull('date_discharged')->get();
            $total_number_of_evacuees = 0;
            $family_codes =  array();
            $female = 0;
            $male = 0;
            $children = 0;
            $lactating = 0;
            $pwd = 0;
            $pregnant = 0;
            $senior_citizen  = 0;
            $solo_parent = 0;
            if ($evacuees != null) {
                foreach ($evacuees as $evacuee) {
                    $relief_recipient = ReliefRecipient::where('id', $evacuee->relief_recipient_id)->first();
                    if (!in_array($relief_recipient->family_code, $family_codes)) {
                        array_push($family_codes, $relief_recipient->family_code);
                        $family = Family::where('family_code', $relief_recipient->family_code)->first();
                        $total_number_of_evacuees = $total_number_of_evacuees + $family->no_of_members;

                        $family_members = FamilyMember::where('family_code', $family->family_code)->get();

                        $female = $female + $family_members->where('gender', 'Female')->count();
                        $male = $male + $family_members->where('gender', 'Male')->count();
                        $children = $children + $family_members->where('sectoral_classification', 'Children')->count();
                        $lactating = $lactating + $family_members->where('sectoral_classification', 'Lactating')->count();
                        $pwd = $pwd + $family_members->where('sectoral_classification', 'Person with Disability')->count();
                        $pregnant = $pregnant + $family_members->where('sectoral_classification', 'Pregnant')->count();
                        $senior_citizen  = $senior_citizen + $family_members->where('sectoral_classification', 'Senior Citizen')->count();
                        $solo_parent = $solo_parent + $family_members->where('sectoral_classification', 'Solo Parent')->count();
                    }
                }
            }
            $eCenter = array(
                'id' => $evacuation_center->id,
                'name' =>  $evacuation_center->name,
                'address' =>  $evacuation_center->address,
                'characteristics' =>  $evacuation_center->characteristics,
                'camp_manager_name' => $evacuation_center->camp_manager_name,
                'capacity' => $evacuation_center->capacity,
                'total_number_of_evacuees' => $total_number_of_evacuees,
                'capacity' => $evacuation_center->capacity,
                'female' => $female,
                'male' => $male,
                'children' => $children,
                'lactating' => $lactating,
                'pwd' => $pwd,
                'pregnant' => $pregnant,
                'senior_citizen' => $senior_citizen,
                'solo_parent' => $solo_parent
            );
            array_push($allEvacuationCenters, $eCenter);
        }
        // foreach($allEvacuationCenters as $allEvacuationCenter)
        return view('admin.evacuation-center.evacList', ['evacuation_centers' => $allEvacuationCenters]);
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

        /*
        SELECT users.id, users.name
            FROM users
            JOIN camp_managers
            ON camp_managers.user_id = users.id
            WHERE 
            (SELECT evacuation_centers.camp_manager_id 
            FROM evacuation_centers
            WHERE camp_manager_id IS NOT NULL) != camp_managers.user_id
        */

        /*
        SELECT users.id, users.name
            FROM users
            JOIN camp_managers
            ON camp_managers.user_id = users.id
            LEFT JOIN evacuation_centers
            ON evacuation_centers.camp_manager_id  = users.id
            WHERE evacuation_centers.camp_manager_id ISNULL
        */
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
            'name'             => 'required|min:1|max:128',
            'address'          => 'required|min:1|max:256',
            'latitude'         => 'required',
            'longitude'        => 'required',
            'capacity'         => 'required|numeric|min:1',
            'characteristics'  => 'nullable'
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

        $request->session()->flash('message', 'Successfully created ' . $evacuation_center->name . ' evacuation center!');

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

        /*
        SELECT users.id, users.name
            FROM users
            JOIN camp_managers
            ON camp_managers.user_id = users.id
            LEFT JOIN evacuation_centers
            ON evacuation_centers.camp_manager_id  = users.id
            WHERE evacuation_centers.camp_manager_id ISNULL
            OR evacuation_centers.camp_manager_id = 3
        */
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
            'name'             => 'required|min:1|max:128',
            'address'          => 'required|min:1|max:256',
            'latitude'         => 'required',   //|unique:evacuation_centers,latitude
            'longitude'        => 'required',
            'capacity'         => 'required|numeric|min:1',
            'characteristics'  => 'nullable'
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
        $request->session()->flash('message', 'Successfully updated ' . $evacuation_center->name . ' evacuation center!');

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
        $request->session()->flash('message', 'Successfully deleted ' . $evacuation_center->name . ' evacuation center!');

        $updatemarker = new UpdateMarker;
        $updatemarker->get_evac();

        return redirect()->route('evacuation-center.index');
    }
}