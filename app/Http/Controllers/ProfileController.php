<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = Auth::id();
        $user = User::join('role_user', 'role_user.user_id', '=', 'users.id')
            ->join('roles', function ($join) {
                $join->on('role_user.role_id', '=', 'roles.id');
            })
            ->select('users.*', 'roles.display_name as type')
            ->where('users.id', '=', $id)
            ->first();

        if (Auth::user()->hasRole('admin')) {
            return view('admin.admin_resource.profile')->with("user", $user);
        } else {
            return view('common.profile.profile')->with("user", $user);
        }
        // dd($user);
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
        if (Auth::user()->hasRole('admin')) {
            return view('admin.admin_resource.edit')->with("user", $user);
        } else {
            return view('common.profile.edit')->with("user", $user);
        }
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
        $user->branch = $request->branch;
        $user->barangay = $request->barangay;
        $user->designation = $request->designation;
        $user->photo = $filename;
        $user->password = Hash::make($request['password']);
        $user->save();
        Session::flash('message', 'Profile updated successfully!');
        return redirect('profile');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}