<?php

namespace App\Http\Controllers;

use App\Mail\Credentials;
use App\Mail\VerifyEmail;
use App\CustomClasses\UpdateVerification;
use App\Models\Barangay;
use App\Models\BarangayCaptain;
use App\Models\CampManager;
use App\Models\Courier;
use App\Models\Location;
use App\Models\Inventory;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;


class FieldOfficerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $field_officers = User::where('officer_type', '!=', 'Administrator')
            ->leftJoin('camp_managers', 'camp_managers.user_id', '=', 'users.id')
            ->leftJoin('barangay_captains', 'barangay_captains.user_id', '=', 'users.id')
            ->leftJoin('couriers', 'couriers.user_id', '=', 'users.id')
            ->select(
                'users.*',
                'camp_managers.*',
                'barangay_captains.*',
                'couriers.*',
                'users.id as user_id',
                'camp_managers.designation as camp_designation',
                'barangay_captains.barangay as barangay',
            )
            ->get();
        // dd($field_officers);

        return view('admin.field_officers_resource.field_officers')->with('field_officers', $field_officers);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $barangays = Barangay::all();
        return view('admin.field_officers_resource.add')->with('barangays', $barangays);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //A generated temporary password for field officers
        $temp_pass = Str::random(12);

        //this validation checks the officer type first
        //if barangay captain, the barangay field must be required
        //else, it can be nullable
        if ($request['officer_type'] == 'Barangay Captain') {
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255', 'alpha_spaces'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'photo' => ['image', 'mimes:jpg,png,jpeg'],
                'contact_no' => ['required', 'numeric', 'digits:11', 'unique:users', 'regex:/^(09)\d{9}$/'],
                'officer_type' => ['required'],
                'barangay' => ['required', 'unique:barangay_captains'],
                'designation' => ['nullable'],
            ]);
        } else {
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255', 'alpha_spaces'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'photo' => ['image', 'mimes:jpg,png,jpeg'],
                'contact_no' => ['required', 'numeric', 'digits:11', 'unique:users', 'regex:/^(09)\d{9}$/'],
                'officer_type' => ['required'],
                'barangay' => ['nullable'],
                'designation' => ['required'],
            ]);
        }


        // checkes if the forwarded request has a photo
        //if it has, get the original filename and save in the public/public/images folder
        //else, set the filename with the default avatar 
        if ($request->hasFile('photo')) {
            $filename = $request->photo->getClientOriginalName();
            $request->photo->storeAs('images', $filename, 'public');
        } else {
            $filename = "Avatar-default.png";
        }
        //create a user 
        $user =  User::create([
            'name' => $validated['name'],
            'photo' => $filename,
            'email' => $validated['email'],
            'officer_type' => $validated['officer_type'],
            'contact_no' => $validated['contact_no'],
            'password' => Hash::make($temp_pass),
            'remember_token' => Str::random(25),
        ]);

        //checks if the user is a barangay captain
        //if true, barangay captain will be created an barangay will be recorded
        //additionally, inventory of the barangay will be created
        if ($user->officer_type == "Barangay Captain") {
            BarangayCaptain::create([
                'user_id' => $user->id,
                'barangay' => $validated['barangay'],
            ]);
            Inventory::create([
                'user_id' => $user->id,
                'name' => $validated['barangay'] . ' Inventory',
                'total_no_of_food_packs' => 0,
                'total_no_of_water' => 0,
                'total_no_of_hygiene_kit' => 0,
                'total_no_of_medicine' => 0,
                'total_no_of_clothes' => 0,
                'total_no_of_emergency_shelter_assistance' => 0,
            ]);
        } else if ($user->officer_type == "Camp Manager") {
            CampManager::create([
                'user_id' => $user->id,
                'designation' => $validated['designation'],
            ]);
        } else if ($user->officer_type == "Courier") {
            Courier::create([
                'user_id' => $user->id,
                'designation' => $validated['designation'],
            ]);
            //put here location weak entity
            //dd($courier->id);
            Location::create([
                'courier_id' => $user->id
            ]);
        }

        //send an email to the newly registered field officer
        //this will contain the temporary password of the user


        $to_name = $user->name;
        $to_email = $user->email;
        $data = [
            'name' => $user->name,
            'email' => $user->email,
            'remember_token' => $user->remember_token,

        ];


        Mail::to($data['email'])->send(new VerifyEmail($data));

        Session::flash('message', 'Field Officer added successfully!');
        return redirect('field_officers');
    }

    public function verifyUser($remember_token)
    {
        $temp_pass = Str::random(12);
        $user = User::where('remember_token', $remember_token)->first();
        if (isset($user)) {
            if ($user->email_verified_at == null) {
                $user->email_verified_at = Carbon::now();
                $user->save();
                $temp_pass = Str::random(12);
                $user->password = Hash::make($temp_pass);
                $user->save();
                //send an email to the newly registered field officer
                //this will contain the temporary password of the user
                $to_name = $user->name;
                $to_email = $user->email;
                $data = [
                    'name' => $user->name,
                    'body' => $temp_pass,
                ];
                Mail::to($to_email)->send(new Credentials($data));
            }
        } else {
            abort('403', "Sorry your email cannot be identified.");
        }

        $update = new UpdateVerification;
        $update->refreshVerifications();
        
        return view('auth.verified-body');
    }
    public function resendVerification($remember_token)
    {
        $user = User::where('remember_token', $remember_token)->first();
        $to_name = $user->name;
        $to_email = $user->email;
        $data = [
            'name' => $user->name,
            'email' => $user->email,
            'remember_token' => $user->remember_token,

        ];
        Mail::to($data['email'])->send(new VerifyEmail($data));
        Session::flash('message', 'Email Verification was successfully sent!');
        return redirect()->back();
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

        $barangay_captain = BarangayCaptain::where('user_id', $user->id)->first();
        $camp_designation = CampManager::where('user_id', $user->id)->first();
        $courier_designation = Courier::where('user_id', $user->id)->first();
        $barangays = Barangay::all();

        return view('admin.field_officers_resource.edit')->with(compact(["user", 'barangay_captain', 'courier_designation', 'camp_designation', 'barangays']));
        // dd($contacts);
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
        //find the user first 
        $user = User::findOrFail($id);
        $barangay_captain = BarangayCaptain::where('user_id', '=', $user->id)->first();


        //this validation checks the officer type first
        //if barangay captain, the barangay field must be required
        //else, it can be nullable
        if ($request['officer_type'] == 'Barangay Captain') {
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255', 'alpha_spaces'],
                'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
                'photo' => ['image', 'mimes:jpg,png,jpeg'],
                'officer_type' => ['required'],
                'contact_no' => ['required', 'numeric', 'digits:11', 'regex:/^(09)\d{9}$/', Rule::unique('users')->ignore($user->id)],
                'barangay' => ['required', Rule::unique('barangay_captains')->ignore($barangay_captain->id)],
                'designation' => ['nullable'],
                'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            ]);
        } else {
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255', 'alpha_spaces'],
                'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
                'photo' => ['image', 'mimes:jpg,png,jpeg'],
                'officer_type' => ['required'],
                'contact_no' => ['required', 'numeric', 'digits:11', 'regex:/^(09)\d{9}$/', Rule::unique('users')->ignore($user->id)],
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
        // if ($user->officer_type == "Courier") {
        //     $user->courier()->delete();
        //     $user->courier()->location()->delete();
        // } 
        $user->delete();
        Session::flash('message', 'Field Officer deleted successfully!');
        return redirect('/field_officers');
    }
}