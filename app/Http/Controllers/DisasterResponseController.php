<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\AffectedArea;
use App\Models\Barangay;
use App\Models\DisasterResponse;
use App\Models\FamilyMember;
use App\Models\ReliefRecipient;
use App\CustomClasses\UpdateMarker;
use App\Models\Family;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use PDF;

class DisasterResponseController extends Controller
{
    public function start()
    {
        $barangays = Barangay::join('family_members', 'family_members.barangay', '=', 'barangays.name')
            ->where('family_members.family_code', '!=', null)
            ->select('barangays.name')
            ->groupBy('barangays.name')
            ->get();
        return view('admin.disaster-response-resource.start')->with(compact('disaster_responses'));
    }
    public function archive()
    {
        $disaster_responses = DisasterResponse::where('date_ended', '!=', null)->get();
        return view('admin.disaster-response-resource.archive')
            ->with(compact('disaster_responses'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'disaster_type' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
            'barangay' => ['required_without_all'],
        ]);

        $disaster_response = DisasterResponse::create([
            'date_started' => Carbon::now(),
            'disaster_type' => $validated['disaster_type'],
            'description' => $validated['description'],
            'photo' => $validated['disaster_type'] . ".png"
        ]);
        $barangay = $request['barangay'];

        $data = [];
        foreach ($barangay as $index) {
            $data[] = [
                'disaster_response_id' => $disaster_response->id,
                'barangay' => $index,
            ];
        }
        AffectedArea::insert($data);
        $affectedFamilies = Family::join('family_members', function ($join) use ($disaster_response) {
            $join->on('family_members.family_code', '=', 'families.family_code')
                ->where('family_members.family_code', '!=', null)
                ->join('affected_areas', 'family_members.barangay', '=', 'affected_areas.barangay')
                ->where('affected_areas.disaster_response_id', '=', $disaster_response->id);
        })
            ->leftJoin('relief_recipients', function ($join) {
                $join->on('relief_recipients.family_code', '=', 'families.family_code')
                    ->join('disaster_responses', 'disaster_responses.id', '=', 'relief_recipients.disaster_response_id')
                    ->where('disaster_responses.date_ended', '=', null);
            })
            ->select('families.family_code', 'relief_recipients.recipient_type')
            ->groupBy('families.family_code', 'relief_recipients.recipient_type')
            ->get();


        $data = [];
        foreach ($affectedFamilies as $index) {
            if ($index->recipient_type == "Evacuee") {
                $data[] = [
                    'disaster_response_id' => $disaster_response->id,
                    'family_code' => $index->family_code,
                    'recipient_type' =>  $index->recipient_type,
                ];
            } else {
                $data[] = [
                    'disaster_response_id' => $disaster_response->id,
                    'family_code' => $index->family_code,
                    'recipient_type' => 'Non-evacuee',
                ];
            }
        }
        ReliefRecipient::insert($data);
        $update_requests = new UpdateMarker;
        $update_requests->refreshMap();
        Session::flash('message', 'Disaster Response started.');
        return redirect('home');
        // dd(ReliefRecipient::all());
    }
    public function show($id)
    {
        $disaster_response = DisasterResponse::where('id', '=', $id)->first();
        $barangays = AffectedArea::where('disaster_response_id', '=', $id)->select('barangay')->get();
        $affected_residents = FamilyMember::join('relief_recipients', function ($join) use ($id) {
            $join->on('relief_recipients.family_code', '=', 'family_members.family_code')
                ->where('disaster_response_id', '=', $id);
        })->select('family_members.*', 'relief_recipients.recipient_type')->get();
        $families = ReliefRecipient::where('disaster_response_id', '=', $id)->get();
        $evacuees = $affected_residents->where('recipient_type', '=', 'Evacuee')->count();
        $non_evacuees = $affected_residents->where('recipient_type', '=', 'Non-evacuee')->count();
        $children = $affected_residents->where('sectoral_classification', '=', 'Children')->count();
        $lactating = $affected_residents->where('sectoral_classification', '=', 'Lactating')->count();
        $PWD = $affected_residents->where('sectoral_classification', '=', 'Person with Disability')->count();
        $pregnant = $affected_residents->where('sectoral_classification', '=', 'Pregnant')->count();
        $senior = $affected_residents->where('sectoral_classification', '=', 'Senior Citizen')->count();
        $solo = $affected_residents->where('sectoral_classification', '=', 'Solo Parent')->count();
        $female = $affected_residents->where('gender', '=', 'Female')->count();
        $male = $affected_residents->where('gender', '=', 'Male')->count();
        $data = [
            'children' => $children,
            'pregnant' => $pregnant,
            'lactating' => $lactating,
            'PWD' => $PWD,
            'pregnant' => $pregnant,
            'senior' => $senior,
            'solo' => $solo,
            'affected_residents' => $affected_residents->count(),
            'families' => $families->count(),
            'evacuees' => $evacuees,
            'non-evacuees' => $non_evacuees,
            'female' => $female,
            'male' => $male,

        ];

        // dd($data);
        return view('admin.disaster-response-resource.show')
            ->with(compact('disaster_response', 'barangays', 'data'));
    }
    public function stop($id)
    {
        $disaster_reponse = DisasterResponse::find($id);
        $disaster_reponse->date_ended = Carbon::now();
        $disaster_reponse->save();

        $update_requests = new UpdateMarker;
        $update_requests->refreshMap();
        Session::flash('message', 'Disaster Response ended');
        return redirect('home');
    }
    public function exportPDF($id)
    {
        $pdf = PDF::loadView('admin.pdf.disaster-response');
        return $pdf->download('Disaster Response report.pdf');
    }
}