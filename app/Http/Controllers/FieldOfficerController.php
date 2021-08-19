<?php

namespace App\Http\Controllers;

use App\Models\BarangayCaptain;
use App\Models\CampManager;
use App\Models\Contact;
use App\Models\Courier;
use App\Models\Inventory;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\Mail\TestMail;


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
                'couriers.designation as c_designation '
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
        //A generated temporary password for field officers
        $temp_pass = Str::random(8);

        //this validation checks the officer type first
        //if barangay captain, the barangay field must be required
        //else, it can be nullable
        if ($request['officer_type'] == 'Barangay Captain') {
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255', 'alpha_spaces'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'photo' => ['image', 'mimes:jpg,png,jpeg'],
                'officer_type' => ['required'],
                'contact_no[]' => ['numeric', 'digits:11', 'unique:contacts', 'regex:/^(09)\d{9}$/'],
                'barangay' => ['required'],
                'designation' => ['nullable'],
            ]);
        } else {
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255', 'alpha_spaces'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'photo' => ['image', 'mimes:jpg,png,jpeg'],
                'officer_type' => ['required'],
                'contact_no[]' => ['numeric', 'digits:11', 'unique:contacts', 'regex:/^(09)\d{9}$/'],
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
            'password' => Hash::make($temp_pass),
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
                'name' => $validated['barangay'] . ' Inventory'
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
        }

        //create contact
        //the user can have 1 or more contact numbers
        foreach ($request->contact_no as $index => $contact_no) {
            if ($request->contact_no[$index] != null) {
                Contact::create([
                    'user_id' => $user->id,
                    'contact_no' => $request->contact_no[$index],
                ]);
            }
        }

        $details = [
            'title' => "eLIKAS Account Details",
            'body' => $temp_pass,
        ];
        // Mail::to("elikasph@gmail.com")->send($details);
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
        $contacts = Contact::where('user_id', $user->id)->get();
        $barangay_captain = BarangayCaptain::where('user_id', $user->id)->first();
        $camp_designation = CampManager::where('user_id', $user->id)->first();
        $courier_designation = Courier::where('user_id', $user->id)->first();
        return view('admin.field_officers_resource.edit')->with(compact(["user", 'contacts', 'barangay_captain', 'courier_designation', 'camp_designation']));
        // dd($barangay_captain->barangay);
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

        //this validation checks the officer type first
        //if barangay captain, the barangay field must be required
        //else, it can be nullable
        if ($request['officer_type'] == 'Barangay Captain') {
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255', 'alpha_spaces'],
                'email' => ['required', 'string', 'email', 'max:255'],
                'photo' => ['image', 'mimes:jpg,png,jpeg'],
                'officer_type' => ['required'],
                'contact_no[]' => ['numeric', 'digits:11', 'unique:contacts', 'regex:/^(09)\d{9}$/'],
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
                'contact_no[]' => ['numeric', 'digits:11', 'unique:contacts', 'regex:/^(09)\d{9}$/'],
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
        $user->password = $password;
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
        $user->user_contacts()->delete();
        $user->delete();
        Session::flash('message', 'Field Officer deleted successfully!');
        return redirect('/field_officers');
    }
}