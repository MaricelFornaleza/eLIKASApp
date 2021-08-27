<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\BarangayCaptain;
use App\Models\CampManager;
use App\Models\Courier;
use App\Models\Inventory;
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
            ->leftJoin('camp_managers', 'camp_managers.user_id', '=', 'users.id')
            ->leftJoin('barangay_captains', 'barangay_captains.user_id', '=', 'users.id')
            ->leftJoin('couriers', 'couriers.user_id', '=', 'users.id')
            ->select(
                'users.*',
                'admins.*',
                'users.id as user_id',
                'camp_managers.designation as cm_designation',
                'barangay_captains.barangay',
                'couriers.designation'
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
        $admin = Admin::where('user_id', $user->id)->first();
        $barangay_captain = BarangayCaptain::where('user_id', $user->id)->first();
        $camp_designation = CampManager::where('user_id', $user->id)->first();
        $courier_designation = Courier::where('user_id', $user->id)->first();
        if ($role == "Administrator") {
            return view('admin.admin_resource.edit')->with(compact('user', 'admin'));
        } else {
            return view('common.profile.edit')->with(compact(["user", 'barangay_captain', 'courier_designation', 'camp_designation']));
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
            'contact_no' => ['required', 'numeric', 'digits:11',  'regex:/^(09)\d{9}$/'],
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
        $user->contact_no = $request->contact_no;
        if ($request['password'] != null) {
            $user->password = Hash::make($request['password']);
        }
        $user->save();
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

    public function updateFO(Request $request, $id)
    {
        //find the user first 
        $user = User::findOrFail($id);

        //this validation checks the officer type first
        //if barangay captain, the barangay field must be required
        //else, it can be nullable
        if ($request['officer_type'] == 'Barangay Captain') {
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255', 'alpha_spaces'],
                'email' => ['required', 'string', 'email', 'max:255'],
                'photo' => ['image', 'mimes:jpg,png,jpeg'],
                'officer_type' => ['required'],
                'contact_no' => ['required', 'numeric', 'digits:11', 'regex:/^(09)\d{9}$/'],
                'barangay' => ['required'],
                'designation' => ['nullable'],
                'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            ]);
        } else {
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255', 'alpha_spaces'],
                'email' => ['required', 'string', 'email', 'max:255'],
                'photo' => ['image', 'mimes:jpg,png,jpeg'],
                'officer_type' => ['required'],
                'contact_no' => ['required', 'numeric', 'digits:11', 'regex:/^(09)\d{9}$/'],
                'barangay' => ['nullable'],
                'designation' => ['required'],
                'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            ]);
        }
        if ($request->hasFile('photo')) {
            $filename = $request->photo->getClientOriginalName();
            $request->photo->storeAs('images', $filename, 'public');
        } else {
            $filename = $user->photo;
        }
        if ($request['password'] == null) {
            $password = $user->password;
        } else {
            $password = Hash::make($request['password']);
        }
        //update user
        $user->name = $request->name;
        $user->email = $request->email;
        $user->photo = $filename;
        $user->contact_no = $request->contact_no;
        $user->password = $password;
        $user->save();


        if ($user->officer_type == "Barangay Captain") {
            BarangayCaptain::where('user_id', $user->id)->update([
                'barangay' => $validated['barangay'],
            ]);
            Inventory::where('user_id', $user->id)->update([
                'name' => $validated['barangay'] . ' Inventory'
            ]);
        } else if ($user->officer_type == "Camp Manager") {
            CampManager::where('user_id', $user->id)->update([
                'designation' => $validated['designation'],
            ]);
        } else if ($user->officer_type == "Courier") {
            Courier::where('user_id', $user->id)->update([
                'designation' => $validated['designation'],
            ]);
        }

        Session::flash('message', 'Profile updated successfully!');
        return redirect('profile');
    }
}