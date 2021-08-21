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
            ->leftJoin('contacts', 'contacts.user_id', '=', 'users.id')
            ->select(
                'users.name',
                'users.email',
                'contacts.contact_no1',
                'contacts.contact_no2',
                'users.officer_type',
                'camp_managers.designation',
                'barangay_captains.barangay',
                'couriers.designation',
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
            'Contact No. (Optional)',
            'Officer Type',
            'Designation',
            'Barangay',
        ];
    }
}