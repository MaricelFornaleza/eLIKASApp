<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;


use Illuminate\Support\Str;
use App\Models\User;
use Carbon\Carbon;
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
                'email_verified_at' => Carbon::now(),
                'officer_type' => 'Administrator',
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
            ]
        );
    }
}