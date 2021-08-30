<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use Maatwebsite\Excel\Concerns\WithHeadings;

class FieldOfficerExport implements FromCollection, ShouldAutoSize, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $field_officers = User::where('officer_type', '!=', 'Administrator')
            ->leftJoin('camp_managers', 'camp_managers.user_id', '=', 'users.id')
            ->leftJoin('barangay_captains', 'barangay_captains.user_id', '=', 'users.id')
            ->leftJoin('couriers', 'couriers.user_id', '=', 'users.id')

            ->select(
                'users.name',
                'users.email',
                'users.contact_no',
                'users.officer_type',
                'camp_managers.designation as cm-designation',
                'couriers.designation',
                'barangay_captains.barangay',

            )
            ->get();
        return $field_officers;
    }
    public function headings(): array
    {
        return [
            'Name',
            'Email Address',
            'Contact No.',
            'Officer Type',
            'Camp Managers Designation',
            'Couriers Designation',
            'Barangay',
        ];
    }
}