<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Inventory;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Excel;

class FieldOfficerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $field_officers = User::whereRoleIs(['camp_manager', 'barangay_captain', 'courier'])
            ->join('role_user', 'role_user.user_id', '=', 'users.id')
            ->join('roles', function ($join) {
                $join->on('role_user.role_id', '=', 'roles.id');
            })
            ->select('users.*', 'roles.display_name as type')
            ->get();
        return view('admin.field_officers_resource.field_officers')->with('field_officers', $field_officers);
        // return dd($field_officers);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.field_officers_resource.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
<<<<<<< HEAD

=======
       
>>>>>>> c173c2c (Migrations and Supply Inventory)
        if ($request->hasFile('photo')) {
            $filename = $request->photo->getClientOriginalName();
            $request->photo->storeAs('images', $filename, 'public');
        } else {
            $filename = "Avatar-default.png";
        }
        $user =  User::create([
            'name' => $request['name'],
            'photo' => $filename,
            'email' => $request['email'],
            'barangay' => $request['barangay'],
            'designation' => $request['designation'],
            'password' => Hash::make('password'),
        ]);
        $user->attachRole($request['officer_type']);
        $contact = Contact::create([
            'user_id' => $user->id,
            'contact_no' => $request['contact_no']
        ]);

        if($user->hasRole('barangay_captain')){
            $inventory = Inventory::create([
                'user_id' => $user->id,
                'name' => $user->barangay.' Inventory'
            ]);
        }
        // $bc = User::find($user->id)->user_inventory->name;
        // dd($bc);

        Session::flash('message', 'Field Officer added successfully!');
        return redirect('field_officers');
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
        $user = User::find($id);
        return view('admin.field_officers_resource.edit')->with("user", $user);
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
        $user = User::find($id);
        if ($request->hasFile('photo')) {
            $filename = $request->photo->getClientOriginalName();
            $request->photo->storeAs('images', $filename, 'public');
        } else {
            $filename = $user->photo;
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->user_contacts()->contact_no = $request->contact_no;
        $user->barangay = $request->barangay;
        $user->designation = $request->designation;
        $user->photo = $filename;
        $user->password = Hash::make($request->password);
        $user->save();
        Session::flash('message', 'Field Officer updated successfully!');
        return redirect('field_officers');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->user_contacts()->delete();
        $user->delete();
        Session::flash('message', 'Field Officer deleted successfully!');
        return redirect('/field_officers');
    }
}