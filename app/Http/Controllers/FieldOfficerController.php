<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

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
        return view('admin.field_officers')->with('field_officers', $field_officers);
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
        request()->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'contact_no' => ['required', 'numeric', 'max:11'],


        ]);
        if ($request->hasFile('photo')) {
            $filename = $request->photo->getClientOriginalName();
            $request->photo->storeAs('images', $filename, 'public');
        }
        $user =  User::create([
            'name' => $request['name'],
            'photo' => $filename,
            'email' => $request['email'],
            'barangay' => $request['barangay'],
            'designation' => $request['designation'],

            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password

        ]);
        $user->attachRole($request['officer_type']);
        $contact = Contact::create([
            'user_id' => $user->id,
            'contact_no' => $request['contact_no']
        ]);

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

        if ($request->hasFile('photo')) {
            $filename = $request->photo->getClientOriginalName();
            $request->photo->storeAs('images', $filename, 'public');
        }

        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->user_contacts()->contact_no = $request->contact_no;
        $user->barangay = $request->barangay;
        $user->designation = $request->designation;
        $user->photo = $filename;
        $user->password = $request->password;
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
