<?php

namespace App\Http\Controllers;

use App\Exports\FieldOfficerExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function exportFieldOfficer()
    {
        return Excel::download(new FieldOfficerExport, 'FieldOfficer.xls');
    }
}