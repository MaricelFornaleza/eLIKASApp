<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;


use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        /*  insert users   */
        $user = User::create(
            [
                'name' => "Admin eLIKAS",
                'email' => 'elikasph@gmail.com',
                'officer_type' => 'Administrator',
                'contact_no' => '09772779609',
                'password' => Hash::make('password'),
            ]
        );
    }
}