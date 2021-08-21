<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ReliefRecipient;

class ReliefRecipientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $relief_recipients = ReliefRecipient::paginate(5);
        return view('admin.relief-recipients.residentsList', ['relief_recipients' => $relief_recipients]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        //
        return view('admin.relief-recipients.create');
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
            'name'              => 'required|min:1',
            'address'           => 'required|min:1',
            'birthdate'         => 'required|date_format:Y-m-d',
            'sectoral_classification' => 'required',
            'gender'            => 'required',
            'family_representative'   => 'required'
        ]);
        $relief_recipient = new ReliefRecipient();
        $relief_recipient->name     = $request->input('name');
        $relief_recipient->address   = $request->input('address');
        $relief_recipient->birthdate = $request->input('birthdate');
        $relief_recipient->sectoral_classification = $request->input('sectoral_classification');
        $relief_recipient->gender = $request->input('gender');
        $relief_recipient->family_representative = $request->input('family_representative');
        $relief_recipient->save();
        $request->session()->flash('message', 'Successfully created relief_recipient');
        return redirect()->route('relief-recipient.index');
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
        $relief_recipient = ReliefRecipient::find($id);
        return view('admin.relief-recipients.edit', ['relief_recipient' => $relief_recipient ]);
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
        $validatedData = $request->validate([
            'name'              => 'required|min:1',
            'address'           => 'required|min:1',
            'birthdate'         => 'required|date_format:Y-m-d',
            'sectoral_classification' => 'required',
            'gender'            => 'required',
            'family_representative'   => 'required'
        ]);
        $relief_recipient = ReliefRecipient::find($id);
        $relief_recipient->name     = $request->input('name');
        $relief_recipient->address   = $request->input('address');
        $relief_recipient->birthdate = $request->input('birthdate');
        $relief_recipient->sectoral_classification = $request->input('sectoral_classification');
        $relief_recipient->gender = $request->input('gender');
        $relief_recipient->family_representative = $request->input('family_representative');
        $relief_recipient->save();
        $request->session()->flash('message', 'Successfully created relief_recipient');
        return redirect()->route('relief-recipient.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $relief_recipient = ReliefRecipient::find($id);
        if($relief_recipient){
            $relief_recipient->delete();
        }
        return redirect()->route('relief-recipient.index');
    }
}
