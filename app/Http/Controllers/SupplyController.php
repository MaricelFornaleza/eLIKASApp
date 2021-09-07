<?php

namespace App\Http\Controllers;

use App\Models\Supply;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Session;

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
        return view('admin.supply-resource.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'supply_type' => ['required', 'string', 'max:255', 'alpha_spaces'],
            'quantity' => ['required', 'numeric', 'min:1'],
            'source' => ['required', 'string', 'max:255', 'alpha_spaces'],
        ]);

        //
        $user = Auth::user();

        $user_inventory_id = User::find($user->id)->user_inventory->id;
        $user_inventory_prev_stock = $user->user_inventory()->first();
        if($validated['supply_type'] == 'Food Packs'){
            $user->user_inventory()->update([
                'total_no_of_food_packs'                    => ($user_inventory_prev_stock->total_no_of_food_packs + $validated['quantity']),
            ]);
        }else if($validated['supply_type'] == 'Water'){
            $user->user_inventory()->update([
                'total_no_of_water'                         => ($user_inventory_prev_stock->total_no_of_water + $validated['quantity']),
            ]);
        }else if($validated['supply_type'] == 'Hygiene Kit'){
            $user->user_inventory()->update([
                'total_no_of_hygiene_kit'                   => ($user_inventory_prev_stock->total_no_of_hygiene_kit + $validated['quantity']),
            ]);
        }else if($validated['supply_type'] == 'Medicine'){
            $user->user_inventory()->update([
                'total_no_of_medicine'                      => ($user_inventory_prev_stock->total_no_of_medicine + $validated['quantity']),
            ]);
        }else if($validated['supply_type'] == 'Clothes'){
            $user->user_inventory()->update([
                'total_no_of_clothes'                       => ($user_inventory_prev_stock->total_no_of_clothes + $validated['quantity']),
            ]);
        }else if($validated['supply_type'] == 'ESA'){
            $user->user_inventory()->update([
                'total_no_of_emergency_shelter_assistance'  => ($user_inventory_prev_stock->total_no_of_emergency_shelter_assistance + $validated['quantity']),
            ]);
        }

        $supply = new Supply();
        $supply->inventory_id     = $user_inventory_id;
        $supply->supply_type   = $validated['supply_type'];
        $supply->quantity = $validated['quantity'];
        $supply->source = $validated['source'];
        $supply->save();
        $request->session()->flash('message', 'Supply created successfully!');
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
        return view('admin.supply-resource.edit', ['supply' => $supply]);
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

        $user = Auth::user();
        $user_inventory_prev_stock = $user->user_inventory()->first();
            if($supply->supply_type == 'Food Packs'){
                if($supply->quantity < $request->input('quantity')){
                    $difference = $request->input('quantity') - $supply->quantity;
                    $user->user_inventory()->update([
                        'total_no_of_food_packs'                    => ($user_inventory_prev_stock->total_no_of_food_packs + $difference),
                    ]);
                }else if($supply->quantity > $request->input('quantity')){
                    $difference =  $supply->quantity - $request->input('quantity');
                    $user->user_inventory()->update([
                        'total_no_of_food_packs'                    => ($user_inventory_prev_stock->total_no_of_food_packs - $difference),
                    ]);
                }
            }else if($supply->supply_type == 'Water'){
                if($supply->quantity < $request->input('quantity')){
                    $difference = $request->input('quantity') - $supply->quantity;
                    $user->user_inventory()->update([
                        'total_no_of_water'                    => ($user_inventory_prev_stock->total_no_of_water + $difference),
                    ]);
                }else if($supply->quantity > $request->input('quantity')){
                    $difference =  $supply->quantity - $request->input('quantity');
                    $user->user_inventory()->update([
                        'total_no_of_water'                    => ($user_inventory_prev_stock->total_no_of_water - $difference),
                    ]);
                }
            }else if($supply->supply_type == 'Hygiene Kit'){
                if($supply->quantity < $request->input('quantity')){
                    $difference = $request->input('quantity') - $supply->quantity;
                    $user->user_inventory()->update([
                        'total_no_of_hygiene_kit'                    => ($user_inventory_prev_stock->total_no_of_hygiene_kit + $difference),
                    ]);
                }else if($supply->quantity > $request->input('quantity')){
                    $difference =  $supply->quantity - $request->input('quantity');
                    $user->user_inventory()->update([
                        'total_no_of_hygiene_kit'                    => ($user_inventory_prev_stock->total_no_of_hygiene_kit - $difference),
                    ]);
                }
            }else if($supply->supply_type == 'Medicine'){
                if($supply->quantity < $request->input('quantity')){
                    $difference = $request->input('quantity') - $supply->quantity;
                    $user->user_inventory()->update([
                        'total_no_of_medicine'                    => ($user_inventory_prev_stock->total_no_of_medicine + $difference),
                    ]);
                }else if($supply->quantity > $request->input('quantity')){
                    $difference =  $supply->quantity - $request->input('quantity');
                    $user->user_inventory()->update([
                        'total_no_of_medicine'                    => ($user_inventory_prev_stock->total_no_of_medicine - $difference),
                    ]);
                }
            }else if($supply->supply_type == 'Clothes'){
                if($supply->quantity < $request->input('quantity')){
                    $difference = $request->input('quantity') - $supply->quantity;
                    $user->user_inventory()->update([
                        'total_no_of_clothes'                    => ($user_inventory_prev_stock->total_no_of_clothes + $difference),
                    ]);
                }else if($supply->quantity > $request->input('quantity')){
                    $difference =  $supply->quantity - $request->input('quantity');
                    $user->user_inventory()->update([
                        'total_no_of_clothes'                    => ($user_inventory_prev_stock->total_no_of_clothes - $difference),
                    ]);
                }
            }else if($supply->supply_type == 'ESA'){
                if($supply->quantity < $request->input('quantity')){
                    $difference = $request->input('quantity') - $supply->quantity;
                    $user->user_inventory()->update([
                        'total_no_of_emergency_shelter_assistance'                    => ($user_inventory_prev_stock->total_no_of_emergency_shelter_assistance + $difference),
                    ]);
                }else if($supply->quantity > $request->input('quantity')){
                    $difference =  $supply->quantity - $request->input('quantity');
                    $user->user_inventory()->update([
                        'total_no_of_emergency_shelter_assistance'                    => ($user_inventory_prev_stock->total_no_of_emergency_shelter_assistance - $difference),
                    ]);
                }
            }
            $supply->supply_type   = $request->input('supply_type');
            $supply->quantity = $request->input('quantity');
            $supply->source = $request->input('source');
            $supply->save();

        $request->session()->flash('message', 'Supply updated successfully!');
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
        if ($supply) {
            $user = Auth::user();
            $user_inventory_prev_stock = $user->user_inventory()->first();
            if($supply->supply_type == 'Food Packs'){
                $user->user_inventory()->update([
                    'total_no_of_food_packs'                    => ($user_inventory_prev_stock->total_no_of_food_packs - $supply->quantity),
                ]);
            }else if($supply->supply_type == 'Water'){
                $user->user_inventory()->update([
                    'total_no_of_water'                         => ($user_inventory_prev_stock->total_no_of_water - $supply->quantity),
                ]);
            }else if($supply->supply_type == 'Hygiene Kit'){
                $user->user_inventory()->update([
                    'total_no_of_hygiene_kit'                   => ($user_inventory_prev_stock->total_no_of_hygiene_kit - $supply->quantity),
                ]);
            }else if($supply->supply_type == 'Medicine'){
                $user->user_inventory()->update([
                    'total_no_of_medicine'                      => ($user_inventory_prev_stock->total_no_of_medicine - $supply->quantity),
                ]);
            }else if($supply->supply_type == 'Clothes'){
                $user->user_inventory()->update([
                    'total_no_of_clothes'                       => ($user_inventory_prev_stock->total_no_of_clothes - $supply->quantity),
                ]);
            }else if($supply->supply_type == 'ESA'){
                $user->user_inventory()->update([
                    'total_no_of_emergency_shelter_assistance'  => ($user_inventory_prev_stock->total_no_of_emergency_shelter_assistance - $supply->quantity),
                ]);
            }
            $supply->delete();
        }
        Session::flash('message', 'Supply deleted successfully!');
        return redirect()->route('inventory.index');
    }
}