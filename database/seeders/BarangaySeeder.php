<?php

namespace Database\Seeders;

use App\Models\Barangay;
use Illuminate\Database\Seeder;

class BarangaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $contact = Barangay::insert(
            [
                ['name' => 'Abella',],
                ['name' => 'Bagumbayan Norte',],
                ['name' => 'Bagumbayan Sur',],
                ['name' => 'Balatas',],
                ['name' => 'Calauag',],
                ['name' => 'Cararayan',],
                ['name' => 'Carolina',],
                ['name' => 'Concepcion Grande',],
                ['name' => 'Concepcion Pequeña',],
                ['name' => 'Dayangdang',],
                ['name' => 'Del Rosario',],
                ['name' => 'Dinaga',],
                ['name' => 'Igualdad',],
                ['name' => 'Lerma',],
                ['name' => 'Liboton',],
                ['name' => 'Mabolo',],
                ['name' => 'Pacol',],
                ['name' => 'Panicuason',],
                ['name' => 'Peñafrancia',],
                ['name' => 'Sabang',],
                ['name' => 'San Felipe',],
                ['name' => 'San Francisco',],
                ['name' => 'San Isidro',],
                ['name' => 'Sta. Cruz',],
                ['name' => 'Tabuco',],
                ['name' => 'Tinago',],
                ['name' => 'Triangulo',],

            ]

        );
    }
}