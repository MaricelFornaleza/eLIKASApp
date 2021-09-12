<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Barangay;
use App\Models\User;
use App\Models\Inventory;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {

        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255', 'alpha_spaces'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'region_psgc' => ['required', 'string', 'max:255'],
            'province_psgc' => ['required', 'string', 'max:255'],
            'city_psgc' => ['required', 'string', 'max:255'],
            'region' => ['required', 'string', 'max:255'],
            'province' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'contact_no' => ['required', 'numeric', 'digits:11', 'unique:users', 'regex:/^(09)\d{9}$/'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {

        $user =  User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'officer_type' => 'Administrator',
            'contact_no' => $data['contact_no'],
            'password' => Hash::make($data['password']),
        ]);
        $region =  Str::title($data['region_psgc']);
        $province =  Str::title($data['province_psgc']);
        $city =  Str::title($data['city_psgc']);
        Admin::create([
            'user_id' => $user->id,
            'region_psgc' => $region,
            'province_psgc' =>  $province,
            'city_psgc' =>  $city,
            'address' => $city . ',' . $province . ',' . $region
        ]);
        Inventory::create([
            'user_id' => $user->id,
            'name' => $data['city'] . ' Inventory',
            'total_no_of_food_packs' => 0,
            'total_no_of_water' => 0,
            'total_no_of_hygiene_kit' => 0,
            'total_no_of_medicine' => 0,
            'total_no_of_clothes' => 0,
            'total_no_of_emergency_shelter_assistance' => 0,
        ]);
        $barangay = explode(",", $data['barangays'][0]);
        $data = [];
        foreach ($barangay as $index) {
            $data[] = [
                'name' => $index,
            ];
        }
        Barangay::insert($data);

        return $user;
    }
}