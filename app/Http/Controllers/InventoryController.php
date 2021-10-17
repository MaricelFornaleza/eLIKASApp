<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\Supply;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $user_inventory = User::find($user->id)->user_inventory;
        $inventory_supplies = Inventory::find($user_inventory->id)->inventory_supplies;
        //dd($inventory_supplies);
        if ($user->officer_type == "Administrator") {
            $admin_inventory = Inventory::where('user_id', '=', $user->id)->first();
            dd($admin_inventory);

            return view('admin.inventory-resource.supplyList', ['inventory_supplies' => $inventory_supplies, 'admin_inventory' => $admin_inventory]);
        } else if ($user->officer_type == "Barangay Captain") {
            $bc_inventory = Inventory::where('user_id', '=', $user->id)->first();
            $is_empty = Supply::where('inventory_id', $bc_inventory->id)->first();
            return view('barangay-captain.inventory-resource.supplyList', ['inventory_supplies' => $inventory_supplies, 'is_empty' => $is_empty]);
        }
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
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function show(Inventory $inventory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function edit(Inventory $inventory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Inventory $inventory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Inventory $inventory)
    {
        //
    }
}