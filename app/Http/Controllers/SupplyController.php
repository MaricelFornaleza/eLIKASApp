<?php

namespace App\Http\Controllers;

use App\Models\Supply;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupplyController extends Controller 
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $supplies = Supply::paginate(5);
        // return view('barangay-captain.supply-resource.supplyList', ['supplies' => $supplies]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('barangay-captain.supply-resource.create');
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
        $user = Auth::user();

        $user_inventory_id = User::find($user->id)->user_inventory->id;

        $supply = new Supply();
        $supply->inventory_id     = $user_inventory_id;
        $supply->supply_type   = $request->input('supply_type');
        $supply->quantity = $request->input('quantity');
        $supply->source = $request->input('source');
        $supply->save();
        $request->session()->flash('message', 'Successfully created supply');
         return redirect()->route('inventory.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Supply  $supply
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Supply  $supply
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $supply = Supply::find($id);
        return view('barangay-captain.supply-resource.edit', ['supply' => $supply ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Supply  $supply
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $supply = Supply::find($id);
        $supply->supply_type   = $request->input('supply_type');
        $supply->quantity = $request->input('quantity');
        $supply->source = $request->input('source');
        $supply->save();
        $request->session()->flash('message', 'Successfully created supply');
         return redirect()->route('inventory.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Supply  $supply
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $supply = Supply::find($id);
        if($supply){
            $supply->delete();
        }
        return redirect()->route('inventory.index');
    }
}
