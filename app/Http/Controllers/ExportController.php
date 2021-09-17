<?php

namespace App\Http\Controllers;

use App\Exports\FieldOfficerExport;
use App\Exports\SuppliesExport;
use App\Exports\EvacuationCenterExport;
use App\Exports\DeliveryRequestExport;
use App\Exports\ResidentsExport;

use App\Models\Admin;
use App\Models\EvacuationCenter;
use App\Models\Inventory;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use Barryvdh\Snappy\Facades\SnappyPdf;


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
        $admin = Admin::first();

        $pdf = PDF::loadView('admin.pdf.field-officers', compact('field_officers', 'admin'));
        return $pdf->stream('FieldOfficer_' . $todayDate . '.pdf');
    }
    public function exportSupplies()
    {
        $todayDate = date("Y-m-d");
        return Excel::download(new SuppliesExport, 'Supplies_ ' . $todayDate . '.xls');
    }
    public function exportSuppliesPDF()
    {
        $user = Auth::user();
        $admin = Admin::first();
        $todayDate = date("Y-m-d");
        $user_inventory = User::find($user->id)->user_inventory;
        $supplies = Inventory::find($user_inventory->id)->inventory_supplies;
        $pdf = PDF::loadView('admin.pdf.supplies', compact('supplies', 'admin'));
        return $pdf->stream('Supplies_' . $todayDate . '.pdf');
    }
    public function exportEvacuationCenters()
    {
        $todayDate = date("Y-m-d");
        return Excel::download(new EvacuationCenterExport, 'EvacuationCenters_' . $todayDate . '.xls');
    }
    public function exportEvacuationCentersPDF()
    {

        $admin = Admin::first();
        $todayDate = date("Y-m-d");
        $evacuation_centers =  EvacuationCenter::leftJoin('users', 'evacuation_centers.camp_manager_id', '=', 'users.id')
            ->select(
                'users.name as camp_manager_name',
                'evacuation_centers.name',
                'evacuation_centers.address',
                'evacuation_centers.latitude',
                'evacuation_centers.longitude',
                'evacuation_centers.capacity',
                'evacuation_centers.characteristics'
            )
            ->orderByRaw('evacuation_centers.id ASC')
            ->get();

        $pdf = PDF::loadView('admin.pdf.evacuation-centers', compact('evacuation_centers', 'admin'))->setPAper('a4', 'landscape');
        return $pdf->stream('Evacuation_Centers_' . $todayDate . '.pdf');
    }
    public function exportDeliveryRequests()
    {
        $todayDate = date("Y-m-d");
        return Excel::download(new DeliveryRequestExport, 'Requests_' . $todayDate . '.xls');
    }
    public function exportDeliveryRequestsPDF()
    {

        $admin = Admin::first();
        $todayDate = date("Y-m-d");
        $delivery_requests = DB::table('requests')
            ->leftJoin('users', 'requests.camp_manager_id', '=', 'users.id')
            ->leftJoin('evacuation_centers', 'evacuation_centers.camp_manager_id', '=', 'requests.camp_manager_id')
            ->select(
                'requests.id',
                'users.name as camp_manager_name',
                'evacuation_centers.name',
                'requests.food_packs',
                'requests.water',
                'requests.hygiene_kit',
                'requests.clothes',
                'requests.medicine',
                'requests.emergency_shelter_assistance',
                'requests.note',
                'requests.status',
                'requests.updated_at'
            )
            ->orderByRaw('updated_at ASC')
            ->get();
        $pdf = PDF::loadView('admin.pdf.requests', compact('delivery_requests', 'admin'))->setPAper('a4', 'landscape');
        return $pdf->stream('Requests_' . $todayDate . '.pdf');
    }
    public function exportResidents()
    {
        return Excel::download(new ResidentsExport, 'Residents.xls');
    }
    public function exportResidentsPDF()
    {
        $admin = Admin::first();
        $todayDate = date("Y-m-d");
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
        $pdf = PDF::loadView('admin.pdf.residents', compact('residents', 'admin'))->setPAper('a4', 'landscape');
        return $pdf->stream('Residents_' . $todayDate . '.pdf');
    }

    public function download()
    {
        $pdf = SnappyPDF::loadView('chart');
        // $pdf->setOption('enable-javascript', true);
        // $pdf->setOption('javascript-delay', 5000);
        // $pdf->setOption('enable-smart-shrinking', true);
        // $pdf->setOption('no-stop-slow-scripts', true);
        return $pdf->stream('chart.pdf');
    }
}