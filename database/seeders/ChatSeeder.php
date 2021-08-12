<?php

namespace Database\Seeders;

use App\Models\Chat;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class ChatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        /*  insert users   */
        $user = Chat::create(
            [
                'sender' => '1',
                'recipient' => '2',
                'message' => $faker->text,
                'is_read' => '1', // password
            ]
        );
    }
}