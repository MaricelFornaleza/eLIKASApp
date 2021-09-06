<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Maatwebsite\Excel\Concerns\FromCollection;

class ResidentsExport implements FromCollection, ShouldAutoSize, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $residents = DB::table('family_members')
            ->leftJoin('families', 'family_members.family_code', '=', 'families.family_code')
            ->select(
                'family_members.family_code',
                'name',
                'gender',
                'birthdate',
                'sectoral_classification',
                'is_family_head',
                'street',
                'barangay'
            )
            ->get();
        return $residents;
    }

    public function headings(): array
    {
        return [
            'Family_Code',
            'Name',
            'Gender',
            'Birthdate',
            'Sectoral_Classification',
            'Is_Family_Head',
            'Street',
            'Barangay'
        ];
    }
}