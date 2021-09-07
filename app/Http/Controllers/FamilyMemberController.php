<?php

namespace App\Http\Controllers;

use App\Models\Barangay;
use App\Models\Family;
use Illuminate\Http\Request;
use App\Models\FamilyMember;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Str;
use App\Models\ReliefRecipient;



class FamilyMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $residents = DB::table('family_members')
            ->leftJoin('families', 'family_members.family_code', '=', 'families.family_code')
            // ->leftJoin('relief_recipients', function ($join) {
            //     $join->on('family_members.family_code', '=', 'relief_recipients.family_code')
            //         ->leftJoin('evacuees', 'evacuees.relief_recipient_id', '=', 'relief_recipients.id')
            //         ->where('evacuees.date_discharged', '!=', null);
            // })
            ->leftJoin('relief_recipients', 'relief_recipients.family_code', '=', 'families.family_code')
            ->select(
                'family_members.id as fm_id',
                'family_members.family_code',
                'name',
                'gender',
                'birthdate',
                'sectoral_classification',
                'is_family_head',
                'street',
                'barangay',
                'relief_recipients.recipient_type'
            )
            ->get();
        // dd($residents);
        // $family_member = DB::table('family_members')->select('id', 'name','sectoral_classification')->get();
        // dd($family_member);
        // $family_members = FamilyMember::all();
        return view('admin.relief-recipients-resource.familyMembersList', ['family_members' => $residents]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $barangays = Barangay::all();

        return view('admin.relief-recipients-resource.create')->with('barangays', $barangays);
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
            'street'           => ['required', 'string', 'max:255', 'alpha_spaces'],
            'barangay'           => ['required', 'string', 'max:255'],
            'family_code'       => ['nullable', 'string', 'max:255', 'exists:families,family_code'],
            'is_family_head'    => ['required', 'string', 'max:255'],
            'sectoral_classification' => ['required', 'string', 'max:255', 'alpha_spaces'],
        ]);

        $family_member = new FamilyMember();
        $family_member->name     = $validated['name'];
        $family_member->gender   = $validated['gender'];
        $family_member->birthdate = $validated['birthdate'];
        $family_member->street = $validated['street'];
        $family_member->barangay = $validated['barangay'];
        $family_member->family_code = $validated['family_code'];
        $family_member->is_family_head = $validated['is_family_head'];
        $family_member->sectoral_classification = $validated['sectoral_classification'];
        $family_member->save();

        if ($request['family_code'] != null) {
            $findFamily =  DB::table('families')->where('family_code', $family_member->family_code)->first();
            // if($findFamily == null){
            //     $family = new Family();
            //     $family->family_code = $family_member->family_code;
            //     $family->no_of_members = 1;
            //     $family->save();

            //     $relief_recipient = new ReliefRecipient();
            //     $relief_recipient->family_code = $family_member->family_code;
            //     $relief_recipient->recipient_type = 'Non-Evacuee';
            //     $relief_recipient->save();}else 

            if ($findFamily != null) {
                $family = Family::find($findFamily->id);
                $family->no_of_members = $family->no_of_members + 1;
                $family->save();
            }
        }
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
        return view('admin.relief-recipients-resource.edit', ['family_member' => $family_member]);
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
            'address'           => ['required', 'string', 'max:255', 'alpha_spaces'],
            'family_code'       => ['nullable', 'string', 'max:255', 'exists:families,family_code'],
            'is_family_head'    => ['required', 'string', 'max:255'],
            'sectoral_classification' => ['required', 'string', 'max:255', 'alpha_spaces'],
        ]);

        $family_member = FamilyMember::find($id);
        $family_member->name     = $validated['name'];
        $family_member->gender   = $validated['gender'];
        $family_member->birthdate = $validated['birthdate'];
        $family_member->address = $validated['address'];
        $prev_family_member_family_code = $family_member->family_code;
        $family_member->family_code = $validated['family_code'];
        $family_member->is_family_head = $validated['is_family_head'];
        $family_member->sectoral_classification = $validated['sectoral_classification'];

        $family_member->save();

        if ($request['family_code'] != null) {
            $findFamily =  DB::table('families')->where('family_code', $family_member->family_code)->first();
            // if($findFamily == null){
            //     $family = new Family();
            //     $family->family_code = $family_member->family_code;
            //     $family->no_of_members = 1;
            //     $family->save();

            //     $relief_recipient = new ReliefRecipient();
            //     $relief_recipient->family_code = $family_member->family_code;
            //     $relief_recipient->recipient_type = 'Non-Evacuee';
            //     $relief_recipient->save();}else 

            if ($findFamily != null) {
                $family = Family::find($findFamily->id);
                if ($prev_family_member_family_code != null) {
                    if ($family->family_code != $prev_family_member_family_code) {
                        $family->no_of_members = $family->no_of_members + 1;
                        $family->save();

                        $findAnotherFamily =  DB::table('families')->where('family_code', $prev_family_member_family_code)->first();
                        $anotherFamily = Family::find($findAnotherFamily->id);
                        if ($findAnotherFamily->no_of_members <= 1) {
                            $anotherFamily->delete();
                        } else {
                            $anotherFamily->no_of_members = $anotherFamily->no_of_members - 1;
                            $anotherFamily->save();
                        }
                    }
                } else {
                    $family->no_of_members = $family->no_of_members + 1;
                    $family->save();
                }
            }
        } else if ($request['family_code'] == null) {
            if ($prev_family_member_family_code != null) {
                $findFamily =  DB::table('families')->where('family_code', $prev_family_member_family_code)->first();
                if ($findFamily->no_of_members <= 1) {
                    $family = Family::find($findFamily->id);
                    $family->delete();
                    // $relief_recipient = DB::table('relief_recipients')->where('family_code', $prev_family_member_family_code);
                    // $relief_recipient->delete();
                } else {
                    $family = Family::find($findFamily->id);
                    $family->no_of_members = $family->no_of_members - 1;
                    $family->save();
                }
            }
        }

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
        if ($family_member) {
            $findFamily =  DB::table('families')->where('family_code', $family_member->family_code)->first();
            //   $count_members = DB::table('families')->where('family_code', $family_member->family_code)->count();
            if ($findFamily == null) {
                $family_member->delete();
            } else if ($findFamily->no_of_members <= 1) {
                $family_member->delete();
                $family = Family::find($findFamily->id);
                $family->delete();
                // $relief_recipient = DB::table('relief_recipients')->where('family_code', $family_member->family_code);
                // $relief_recipient->delete();
            } else if ($findFamily->no_of_members > 1) {
                $family_member->delete();
                $family = Family::find($findFamily->id);
                $family->no_of_members = $family->no_of_members - 1;
                $family->save();
            }
            Session::flash('message', 'Resident deleted successfully!');
            return redirect()->route('residents.index');
        }
    }

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

        $family_members = DB::table('family_members')->where('family_code', null)->select('id', 'name', 'sectoral_classification', 'is_family_head', 'street', 'barangay')->get();

        //$family_members = FamilyMember::all();
        return view('admin.relief-recipients-resource.groupFamilyMembers', ['family_members' => $family_members]);
    }

    public function groupResidents(Request $request)
    {

        $validated = $request->validate([
            'selectedResidents'              => ['required']
        ]);
        $ids = $request->selectedResidents;

        $family_head = FamilyMember::select('id', 'is_family_head')
            ->whereIn('id', $ids)
            ->where('is_family_head', '=', 'Yes')
            ->get();
        $count = $family_head->count();


        if ($count == 1) {
            //dd($request->selectedResidents);
            $family_code = 'eLIKAS-' . Str::random(6);

            $family = new Family();
            $family->family_code = $family_code;
            $family->no_of_members = count($request->selectedResidents);
            $family->save();

            foreach ($request->selectedResidents as $selectedResident) {
                $family_member = FamilyMember::find($selectedResident);
                $family_member->family_code   = $family_code;
                $family_member->save();
            }


            // $family_member_rep = FamilyMember::find($request->selectedRepresentative);
            // $family_member_rep->is_representative = 'Yes';

            // $family_member_rep->save();

            // $relief_recipient = new ReliefRecipient();
            // $relief_recipient->family_code     = $family_code;
            // $relief_recipient->no_of_members     = count($request->checkedResidents);
            // $relief_recipient->address     = $validated['address'];
            // $relief_recipient->recipient_type     = 'Non-Evacuee';
            // $relief_recipient->save();
            $request->session()->flash('message', 'Group Resident successfully!');
            return redirect()->back();
        } else if ($count == 0) {
            Session::flash('error', 'Select one family head');
            return redirect()->back();
        } else if ($count > 1) {
            Session::flash('error', 'Only one family head is allowed');
            return redirect()->back();
        }
    }
}