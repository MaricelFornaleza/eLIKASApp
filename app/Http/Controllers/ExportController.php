<?php

namespace App\Http\Controllers;

use App\Exports\FieldOfficerExport;
use App\Exports\SuppliesExport;
use App\Exports\EvacuationCenterExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function exportFieldOfficer()
    {
        return Excel::download(new FieldOfficerExport, 'FieldOfficer.xls');
    }
    public function exportSupplies()
    {
        return Excel::download(new SuppliesExport, 'Supplies.xls');
    }
    public function exportEvacuationCenters()
    {
        $todayDate = date("Y-m-d");
        return Excel::download(new EvacuationCenterExport, 'EvacuationCenters-' . $todayDate . '.xls');
    }
}