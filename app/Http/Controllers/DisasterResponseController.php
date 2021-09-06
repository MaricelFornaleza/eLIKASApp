<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\AffectedArea;
use App\Models\Barangay;
use App\Models\DisasterResponse;
use App\Models\FamilyMember;
use App\Models\ReliefRecipient;
use App\CustomClasses\UpdateMarker;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use PDF;

class DisasterResponseController extends Controller
{
    public function start()
    {
        $barangays = Barangay::all();
        return view('admin.disaster-response-resource.start')->with('barangays', $barangays);
    }
    public function archive()
    {
        $disaster_responses = DisasterResponse::where('date_ended', '!=', null)->get();
        return view('admin.disaster-response-resource.archive')->with('disaster_responses', $disaster_responses);
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

        // $affectedResidents = FamilyMember::join('affected_areas', function ($join) use ($disaster_response) {
        //     $join->on('family_members.barangay', '=', 'affected_areas.barangay')
        //         ->where('affected_areas.disaster_response_id', '=', $disaster_response->id);
        // })->select('family_members.family_code')->distinct()->get();

        $affectedResidents = FamilyMember::join('affected_areas', 'family_members.barangay', '=', 'affected_areas.barangay')
            ->where('affected_areas.disaster_response_id', '=', $disaster_response->id)
            ->select('family_members.family_code')->groupBy('family_members.family_code')->get();

        $data = [];
        foreach ($affectedResidents as $index) {
            $data[] = [
                'disaster_response_id' => $disaster_response->id,
                'family_code' => $index->family_code,
                'recipient_type' => 'Non-evacuee',
            ];
        }
        ReliefRecipient::insert($data);
        $update_requests = new UpdateMarker;
        $update_requests->refreshMap();
        Session::flash('message', 'Disaster Response started.');
        return redirect('home');
    }
    public function show($id)
    {
        $disaster_reponse = DisasterResponse::where('id', '=', $id)->first();
        $barangays = AffectedArea::where('disaster_response_id', '=', $id)->select('barangay')->get();
        // dd($barangays);
        return view('admin.disaster-response-resource.show', ['disaster_response' => $disaster_reponse, 'barangays' => $barangays]);
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