<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Contact;
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
        $user = User::where('users.id', '=', $id)
            ->leftJoin('admins', 'admins.user_id', '=', 'users.id')
            ->select(
                'users.*',
                'admins.*',
                'users.id as user_id',
            )
            ->first();
        $role = Auth::user()->officer_type;
        if ($role == "Administrator") {
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
        $role = Auth::user()->officer_type;
        $contacts = Contact::where('user_id', $user->id)->get();
        $admin = Admin::where('user_id', $user->id)->first();
        if ($role == "Administrator") {
            return view('admin.admin_resource.edit')->with(compact('user', 'contacts', 'admin'));
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
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'alpha_spaces'],
            'email' => ['required', 'string', 'email', 'max:255',],
            'photo' => ['image', 'mimes:jpg,png,jpeg'],
            'contact_no[]' => ['numeric', 'digits:11', 'unique:contacts', 'regex:/^(09)\d{9}$/'],
            'branch' => ['required'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);
        $user = User::find($id);
        if ($request->hasFile('photo')) {
            $filename = $request->photo->getClientOriginalName();
            $request->photo->storeAs('images', $filename, 'public');
        } else {
            $filename = $user->photo;
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->photo = $filename;
        if ($request['password'] != null) {
            $user->password = Hash::make($request['password']);
        }
        $user->save();

        //update contact
        //the user can have 1 or more contact numbers
        $contact_id = Contact::where('user_id', $user->id)->get();
        foreach ($request->contact_no as $index => $contact_no) {
            if ($request->contact_no[$index] != null) {
                if (!empty($contact_id[$index])) {
                    Contact::where('id', $contact_id[$index]->id)
                        ->update([
                            'contact_no' => $request->contact_no[$index],
                        ]);
                } else {
                    Contact::create([
                        'user_id' => $user->id,
                        'contact_no' => $request->contact_no[$index],
                    ]);
                }
            }
        }
        Admin::where('user_id', $user->id)->update([
            'branch' => $validated['branch'],
        ]);
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