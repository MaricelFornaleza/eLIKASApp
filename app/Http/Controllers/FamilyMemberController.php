<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FamilyMember;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;



class FamilyMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $residents = DB::table('family_members')
        //     ->leftJoin('relief_recipients', 'family_members.family_code', '=', 'relief_recipients.family_code')
        //     ->get();
        //     dd($residents);
        // $family_member = DB::table('family_members')->select('id', 'name','sectoral_classification')->get();
        // dd($family_member);
        $family_members = FamilyMember::all();
        return view('admin.relief-recipients.familyMembersList', ['family_members' => $family_members]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
        $validated = $request->validate([
            'name'              => ['required', 'string', 'max:255', 'alpha_spaces'],
            'gender'            => ['required', 'string', 'max:255', 'regex:/^[A-Za-z]+$/'],
            'birthdate'         => ['required', 'date_format:Y-m-d'],
            'sectoral_classification' => ['required', 'string', 'max:255', 'alpha_spaces'],
        ]);

        $family_member = new FamilyMember();
        $family_member->name     = $validated['name'];
        $family_member->gender   = $validated['gender'];
        $family_member->birthdate = $validated['birthdate'];
        $family_member->sectoral_classification = $validated['sectoral_classification'];
        $family_member->gender = $request->input('gender');
        $family_member->is_representative = 'No';
        $family_member->save();
        $request->session()->flash('message', 'Resident added successfully!');
        return redirect()->route('residents.index');
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
        $family_member = FamilyMember::find($id);
        return view('admin.relief-recipients.edit', ['family_member' => $family_member ]);
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
        $validated = $request->validate([
            'name'              => ['required', 'string', 'max:255', 'alpha_spaces'],
            'gender'            => ['required', 'string', 'max:255', 'regex:/^[A-Za-z]+$/'],
            'birthdate'         => ['required', 'date_format:Y-m-d'],
            'sectoral_classification' => ['required', 'string', 'max:255', 'alpha_spaces'],
        ]);

        $family_member = FamilyMember::find($id);
        $family_member->name     = $validated['name'];
        $family_member->gender   = $validated['gender'];
        $family_member->birthdate = $validated['birthdate'];
        $family_member->sectoral_classification = $validated['sectoral_classification'];
        $family_member->gender = $request->input('gender');
        $family_member->is_representative = 'No';
        $family_member->save();
        $request->session()->flash('message', 'Resident updated successfully!');
        return redirect()->route('residents.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $family_member = FamilyMember::find($id);
        if($family_member){
            $family_member->delete();
        }
        Session::flash('message', 'Resident deleted successfully!');
        return redirect()->route('residents.index');
    }
    public $hi = "hi";
    ///////////////////////////////////////// Group Family Members
    public function group()
    {
      //  $hi ="hello";
        // $userData = FamilyMember::get();
        // return json_encode(array('data'=>$userData));
        // $residents = DB::table('family_members')
        //     ->leftJoin('relief_recipients', 'family_members.family_code', '=', 'relief_recipients.family_code')
        //     ->get();
           // dd($checkedResidents);
        
        $family_members = DB::table('family_members')->select('id', 'name','sectoral_classification')->get();

        //$family_members = FamilyMember::all();
        return view('admin.relief-recipients.groupFamilyMembers', ['family_members' => $family_members, 'hi' => $this->hi]);
    }

    public function select(Request $request)
    {
        $this->hi =$request->message;

    }
}
 