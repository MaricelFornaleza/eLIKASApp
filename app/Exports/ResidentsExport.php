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
             ->leftJoin('relief_recipients', 'family_members.family_code', '=', 'relief_recipients.family_code')
             ->select(
                'family_members.family_code',
                'name',
                'gender',
                'birthdate',
                'sectoral_classification',
                'is_representative',
                'address',
                'recipient_type'
             )
             ->get();
        return $residents;
    }

    public function headings(): array
    {
        return [
            'Family Code',
            'Name',
            'Gender',
            'Birthdate',
            'Sectoral Classification',
            'Family Representative',
            'Address',
            'Status'
        ];
    }
}
