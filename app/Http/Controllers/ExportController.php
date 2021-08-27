<?php

namespace App\Http\Controllers;

use App\Exports\FieldOfficerExport;
use App\Exports\SuppliesExport;
use App\Exports\EvacuationCenterExport;
use App\Exports\DeliveryRequestExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PDF;


class ExportController extends Controller
{
    public function exportFieldOfficer()
    {
        $todayDate = date("Y-m-d");
        return Excel::download(new FieldOfficerExport, 'FieldOfficer_' . $todayDate . '.xls');
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
}