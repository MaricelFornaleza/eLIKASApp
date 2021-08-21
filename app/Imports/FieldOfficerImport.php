<?php

namespace App\Imports;

use App\Models\BarangayCaptain;
use App\Models\CampManager;
use App\Models\Contact;
use App\Models\Courier;
use App\Models\Inventory;
use App\Models\Location;
use App\Models\User;

use Illuminate\Support\Collection;
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
        $temp_pass = Str::random(8);

        foreach ($collection as $row) {
            if ($row->filter()->isNotEmpty()) {

                $user =  User::create([
                    'name' => $row['name'],
                    'email' => $row['email'],
                    'officer_type' => $row['officer_type'],
                    'password' => $temp_pass,
                    // 'password' => Hash::make($temp_pass),
                ]);

                if ($user->officer_type == "Barangay Captain") {
                    BarangayCaptain::create([
                        'user_id' => $user->id,
                        'barangay' => $row['barangay'],
                    ]);
                    Inventory::create([
                        'user_id' => $user->id,
                        'name' => $row['barangay'] . ' Inventory'
                    ]);
                } else if ($user->officer_type == "Camp Manager") {
                    CampManager::create([
                        'user_id' => $user->id,
                        'designation' => $row['designation'],
                    ]);
                } else if ($user->officer_type == "Courier") {
                    $courier = Courier::create([
                        'user_id' => $user->id,
                        'designation' => $row['designation'],
                    ]);
                    //put here location weak entity
                    //dd($courier->id);
                    Location::create([
                        'courier_id' => $courier->id
                    ]);
                }

                Contact::create([
                    'user_id' => $user->id,
                    'contact_no1' => $row['contact_no1'],
                    'contact_no2' => $row['contact_no2'],
                ]);
            }
        }
    }
}