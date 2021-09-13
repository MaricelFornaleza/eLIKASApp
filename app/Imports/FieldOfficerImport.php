<?php

namespace App\Imports;

use App\Mail\VerifyEmail;
use App\Models\BarangayCaptain;
use App\Models\CampManager;

use App\Models\Courier;
use App\Models\Inventory;
use App\Models\Location;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;


class FieldOfficerImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        $validator = Validator::make($collection->toArray(), [
            '*.name' => ['required', 'string', 'max:255', 'alpha_spaces'],
            '*.email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            '*.contact_no' => ['required', 'numeric', 'digits:11', 'unique:users', 'regex:/^(09)\d{9}$/'],
            '*.officer_type' => 'required',
        ])->validate();



        foreach ($collection as $row) {
            if ($row->filter()->isNotEmpty()) {
                $temp_pass = Str::random(12);
                $user =  User::create([
                    'name' => $row['name'],
                    'email' => $row['email'],
                    'officer_type' => $row['officer_type'],
                    'contact_no' => $row['contact_no'],
                    'password' => Hash::make($temp_pass),
                    'remember_token' => Str::random(25),
                ]);

                if ($user->officer_type == "Barangay Captain") {
                    BarangayCaptain::create([
                        'user_id' => $user->id,
                        'barangay' => $row['barangay'],
                    ]);
                    Inventory::create([
                        'user_id' => $user->id,
                        'name' => $row['barangay'] . ' Inventory',
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
                        'designation' => $row['designation'],
                    ]);
                } else if ($user->officer_type == "Courier") {
                    Courier::create([
                        'user_id' => $user->id,
                        'designation' => $row['designation'],
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

                Mail::to($to_email)->send(new VerifyEmail($data));
            }
        }
    }
}