<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Faker\Factory as Faker;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Contact;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $usersIds = array();
        $numberOfUsers = 10;
        $faker = Faker::create();

        /*  insert users   */
        $user = User::create(
            [
                'name' => $faker->name,
                'photo' => 'null',
                'email' => 'admin@admin.com',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'branch' => $faker->address,
                'remember_token' => Str::random(10),

            ]
        );
        $user->attachRole('admin');


        $user = User::create(
            [
                'name' => $faker->name,
                'photo' => 'null',
                'email' => 'barangay@barangay.com',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'barangay' => $faker->address,
                'remember_token' => Str::random(10),

            ]
        );
        $user->attachRole('barangay_captain');
        $user = User::create(
            [
                'name' => $faker->name,
                'photo' => 'null',
                'email' => 'camp@camp.com',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'designation' => $faker->address,
                'remember_token' => Str::random(10),

            ]
        );
        $user->attachRole('camp_manager');
        $user = User::create(
            [
                'name' => $faker->name,
                'photo' => 'null',
                'email' => 'courier@courier.com',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'designation' => $faker->address,
                'remember_token' => Str::random(10),

            ]
        );
        $user->attachRole('courier');

        $contact = Contact::insert(
            [
                [
                    'user_id' => '1',
                    'contact_no' => '09123456789',
                ],
                [
                    'user_id' => '2',
                    'contact_no' => '09111111111',
                ],
                [
                    'user_id' => '2',
                    'contact_no' => '09444444444',
                ],
                [
                    'user_id' => '3',
                    'contact_no' => '09222222222',
                ],
                [
                    'user_id' => '4',
                    'contact_no' => '09333333333',
                ],
            ]

        );
    }
}
