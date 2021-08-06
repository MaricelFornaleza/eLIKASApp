<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Faker\Factory as Faker;
use Illuminate\Support\Str;
use App\Models\User;

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
                'name' => 'admin',
                'email' => 'admin@admin.com',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'number' => '09123456789',
                'remember_token' => Str::random(10),

            ]
        );
        $user->attachRole('admin', '1');

        $user = User::create(
            [
                'name' => 'barangay',
                'email' => 'barangay@barangay.com',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'number' => '09111111111',
                'remember_token' => Str::random(10),

            ]
        );
        $user->attachRole('barangay_captain');
        $user = User::create(
            [
                'name' => 'camp',
                'email' => 'camp@camp.com',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'number' => '09222222222',
                'remember_token' => Str::random(10),

            ]
        );
        $user->attachRole('camp_manager');
        $user = User::create(
            [
                'name' => 'courier',
                'email' => 'courier@courier.com',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'number' => '09333333333',
                'remember_token' => Str::random(10),

            ]
        );
        $user->attachRole('courier');
    }
}
