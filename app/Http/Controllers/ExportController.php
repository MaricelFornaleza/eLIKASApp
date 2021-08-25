<?php

namespace App\Http\Controllers;

use App\Exports\FieldOfficerExport;
use App\Exports\SuppliesExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PDF;


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
}