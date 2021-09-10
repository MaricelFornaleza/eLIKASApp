<?php

namespace App\Http\Controllers;

use App\Exports\FieldOfficerExport;
use App\Exports\SuppliesExport;
use App\Exports\EvacuationCenterExport;
use App\Exports\DeliveryRequestExport;
use App\Exports\ResidentsExport;

use App\Models\Admin;
use App\Models\User;

use Maatwebsite\Excel\Facades\Excel;
use PDF;


class ExportController extends Controller
{

    public function exportFieldOfficer()
    {
        $todayDate = date("Y-m-d");
        return Excel::download(new FieldOfficerExport, 'FieldOfficer_' . $todayDate . '.xls');
    }
    public function exportFieldOfficerPDF()
    {
        $todayDate = date("Y-m-d");
        $field_officers = User::where('officer_type', '!=', 'Administrator')
            ->leftJoin('camp_managers', 'camp_managers.user_id', '=', 'users.id')
            ->leftJoin('barangay_captains', 'barangay_captains.user_id', '=', 'users.id')
            ->leftJoin('couriers', 'couriers.user_id', '=', 'users.id')
            ->select(
                'users.*',
                'camp_managers.*',
                'barangay_captains.*',
                'couriers.*',
                'users.id as user_id',
                'camp_managers.designation as camp_designation',
                'barangay_captains.barangay as barangay',

            )
            ->get();
        $user = Admin::first();

        $pdf = PDF::loadView('admin.pdf.field-officers', compact('field_officers', 'user'));
        return $pdf->stream('FieldOfficer_' . $todayDate . '.pdf');
    }
    public function exportSupplies()
    {
        $todayDate = date("Y-m-d");
        return Excel::download(new SuppliesExport, 'Supplies_ ' . $todayDate . '.xls');
    }
    public function exportEvacuationCenters()
    {
        $todayDate = date("Y-m-d");
        return Excel::download(new EvacuationCenterExport, 'EvacuationCenters_' . $todayDate . '.xls');
    }
    public function exportDeliveryRequests()
    {
        $todayDate = date("Y-m-d");
        return Excel::download(new DeliveryRequestExport, 'Requests_' . $todayDate . '.xls');
    }
    public function exportResidents()
    {
        return Excel::download(new ResidentsExport, 'Residents.xls');
    }
}