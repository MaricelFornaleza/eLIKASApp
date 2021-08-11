<?php

namespace App\Http\Controllers;

use App\Models\EvacuationCenter;
use Illuminate\Http\Request;

class EvacuationCenterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $evacuation_centers = EvacuationCenter::paginate(5);
        return view('admin.evacuation-center.evacList', ['evacuation_centers' => $evacuation_centers]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.evacuation-center.create');
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
    public function edit(EvacuationCenter $evacuationCenter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EvacuationCenter  $evacuationCenter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EvacuationCenter $evacuationCenter)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EvacuationCenter  $evacuationCenter
     * @return \Illuminate\Http\Response
     */
    public function destroy(EvacuationCenter $evacuationCenter)
    {
        //
    }
}
