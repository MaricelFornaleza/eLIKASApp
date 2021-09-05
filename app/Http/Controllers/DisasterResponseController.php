<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\AffectedArea;
use App\Models\Barangay;
use App\Models\DisasterResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use PDF;

class DisasterResponseController extends Controller
{
    public function start()
    {
        $user_id = Auth::id();
        $admin_city = Admin::where('user_id', '=', $user_id)->select('city_psgc')->first();
        return view('admin.disaster-response-resource.start')->with('admin_city', $admin_city);
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
            'barangay' => ['required'],
        ]);

        $disaster_reponse = DisasterResponse::create([
            'date_started' => Carbon::now(),
            'disaster_type' => $validated['disaster_type'],
            'description' => $validated['description'],
            'photo' => $validated['disaster_type'] . ".png"
        ]);
        $barangay = explode(",", $request['barangay'][0]);

        $data = [];
        foreach ($barangay as $index => $barangay_name) {
            $data[] = [
                'disaster_response_id' => $disaster_reponse->id,
                'barangay' => $barangay[$index],
            ];
        }
        AffectedArea::insert($data);

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
        Session::flash('message', 'Disaster Response ended');
        return redirect('home');
    }
    public function exportPDF($id)
    {
        $pdf = PDF::loadView('admin.pdf.disaster-response');
        return $pdf->download('Disaster Response report.pdf');
    }
}