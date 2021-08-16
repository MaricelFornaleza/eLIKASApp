<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;

class ImportExcelController extends Controller
{
    
    function import(Request $request)
    {
     $this->validate($request, [
      'select_file'  => 'required|mimes:xls,xlsx'
     ]);

     $filename = $request->file('select_file');

     Excel::import(new UsersImport, $filename);

     return redirect()->route('inventory.index')->with('message', 'Successfully uploaded supply!');

    }
}
