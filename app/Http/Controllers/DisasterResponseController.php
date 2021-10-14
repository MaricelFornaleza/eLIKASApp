<?php

namespace App\Http\Controllers;


use App\Models\AffectedArea;
use App\Models\Barangay;
use App\Models\DisasterResponse;
use App\Models\FamilyMember;
use App\Models\AffectedResident;
use App\CustomClasses\UpdateMarker;
use App\Models\AffectedResidentStat;
use App\Models\Evacuee;
use App\Models\Family;
use App\Models\ReliefGood;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use PDF;


class DisasterResponseController extends Controller
{
    public function start()
    {
        $barangays = Barangay::join('family_members', 'family_members.barangay', 'barangays.name')
            ->whereNotNull('family_members.family_code')
            ->select('barangays.name')
            ->groupBy('barangays.name')
            ->get();
        return view('admin.disaster-response-resource.start')->with(compact('barangays'));
    }
    public function archive()
    {
        $disaster_responses = DisasterResponse::whereNotNull('date_ended')->get();
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
            $join->on('family_members.family_code', 'families.family_code')
                ->whereNotNull('family_members.family_code')
                ->join('affected_areas', 'family_members.barangay', 'affected_areas.barangay')
                ->where('affected_areas.disaster_response_id', $disaster_response->id);
        })
            ->leftJoin('affected_residents', function ($join) {
                $join->on('affected_residents.family_code', 'families.family_code')
                    ->join('disaster_responses', 'disaster_responses.id', 'affected_residents.disaster_response_id')
                    ->whereNull('disaster_responses.date_ended');
            })
            ->leftJoin('evacuees', 'evacuees.affected_resident_id', 'affected_residents.id')
            ->select('families.family_code', 'affected_residents.affected_resident_type', 'evacuees.evacuation_center_id', 'evacuees.date_admitted')
            ->groupBy('families.family_code', 'affected_residents.affected_resident_type', 'evacuees.evacuation_center_id', 'evacuees.date_admitted')
            ->get();

        $data = [];
        $families = [];
        $no_of_evacuees = 0;
        $no_of_non_evacuees = 0;
        foreach ($affectedFamilies as $index) {
            if (!in_array($index->family_code, $families)) {
                $families[] = $index->family_code;
                if ($index->affected_resident_type == "Evacuee") {
                    $data[] = [
                        'disaster_response_id' => $disaster_response->id,
                        'family_code' => $index->family_code,
                        'affected_resident_type' =>  $index->affected_resident_type,
                    ];
                    $affected_resident = new AffectedResident();
                    $affected_resident->disaster_response_id = $disaster_response->id;
                    $affected_resident->family_code = $index->family_code;
                    $affected_resident->affected_resident_type = $index->affected_resident_type;
                    $affected_resident->save();
                    $evacuee = new Evacuee();
                    $evacuee->affected_resident_id = $affected_resident->id;
                    $evacuee->date_admitted = $index->date_admitted;
                    $evacuee->evacuation_center_id = $index->evacuation_center_id;
                    $evacuee->save();
                    $evacuees = Family::where('family_code', $index->family_code)->select('no_of_members')->first();
                    $no_of_evacuees += $evacuees->no_of_members;
                } else {
                    $affected_resident = new AffectedResident();
                    $affected_resident->disaster_response_id = $disaster_response->id;
                    $affected_resident->family_code = $index->family_code;
                    $affected_resident->affected_resident_type = 'Non-evacuee';
                    $affected_resident->save();
                    $non_evacuees = Family::where('family_code', $index->family_code)->select('no_of_members')->first();
                    $no_of_non_evacuees += $non_evacuees->no_of_members;
                }
            }
        }
        $this->refreshAffectedResidentsStats($disaster_response->id, $no_of_evacuees, $no_of_non_evacuees);
        $update_requests = new UpdateMarker;
        $update_requests->refreshMap();
        Session::flash('message', 'Disaster Response started.');
        return redirect('home');
        // dd(AffectedResident::all());
    }
    public function refreshAffectedResidentsStats($disaster_response_id, $no_of_evacuees, $no_of_non_evacuees)
    {
        AffectedResidentStat::updateOrCreate(
            [
                'disaster_response_id' => $disaster_response_id,
                'date' => now()->format('F j, Y')
            ],
            [
                'no_of_evacuees' => $no_of_evacuees,
                'no_of_non_evacuees' => $no_of_non_evacuees
            ]
        );
    }
    public function show($id)
    {
        $disaster_response = DisasterResponse::where('id', $id)->first();

        // About Relief Goods
        $dispensed_relief_goods = ReliefGood::where('disaster_response_id', $id)->get();
        $relief_goods = [
            'count' => $dispensed_relief_goods->count(),
            'clothes' => $dispensed_relief_goods->sum('clothes'),
            'emergency_shelter_assistance' => $dispensed_relief_goods->sum('emergency_shelter_assistance'),
            'medicine' => $dispensed_relief_goods->sum('medicine'),
            'hygiene_kit' => $dispensed_relief_goods->sum('hygiene_kit'),
            'water' => $dispensed_relief_goods->sum('water'),
            'food_packs' => $dispensed_relief_goods->sum('food_packs'),
        ];

        // About Residents
        $affected_residents = FamilyMember::join('affected_residents', function ($join) use ($id) {
            $join->on('affected_residents.family_code', 'family_members.family_code')
                ->where('disaster_response_id', $id);
        })
            ->select(
                'family_members.*',
                'affected_residents.affected_resident_type',
            )->get();
        $sectors = [
            'children' => $affected_residents->where('sectoral_classification', 'Children')->count(),
            'pregnant' => $affected_residents->where('sectoral_classification', 'Pregnant')->count(),
            'lactating' => $affected_residents->where('sectoral_classification', 'Lactating')->count(),
            'PWD' => $affected_residents->where('sectoral_classification', 'Person with Disability')->count(),
            'pregnant' => $affected_residents->where('sectoral_classification', 'Pregnant')->count(),
            'senior' => $affected_residents->where('sectoral_classification', 'Senior Citizen')->count(),
            'solo' => $affected_residents->where('sectoral_classification', 'Solo Parent')->count(),
        ];

        // About Affected Barangays
        $barangays = AffectedArea::where('disaster_response_id', $id)->select('barangay')->get();
        $barangayData = [];
        foreach ($barangays as $barangay) {
            $barangayData[] = [
                'barangay' => $barangay->barangay,
                'total_residents' => $affected_residents->where('barangay', $barangay->barangay)->count(),
                'evacuees' => $affected_residents->where('barangay', $barangay->barangay)->where('affected_resident_type', 'Evacuee')->count(),
                'non_evacuees' => $affected_residents->where('barangay', $barangay->barangay)->where('affected_resident_type', 'Non-evacuee')->count(),

            ];
        }
        // Compiled Data
        $data = [
            'sectors' => $sectors,
            'affected_residents' => $affected_residents->count(),
            'families' => AffectedResident::where('disaster_response_id', $id)->count(),
            'evacuees' => $affected_residents->where('affected_resident_type', 'Evacuee')->count(),
            'non-evacuees' => $affected_residents->where('affected_resident_type', 'Non-evacuee')->count(),
            'female' => $affected_residents->where('gender', 'Female')->count(),
            'male' => $affected_residents->where('gender', 'Male')->count(),
            'relief_goods' => $relief_goods,
            'barangayData' => $barangayData,

        ];

        $count = AffectedResidentStat::where('disaster_response_id', $disaster_response->id)->count();
        $evac = [];
        $non_evac = [];
        $dates = [];
        if ($count == 1) {
            $affected_resident_stats = AffectedResidentStat::where('disaster_response_id', $disaster_response->id)->orderBy('date', 'ASC')->first();
            $dates[] = $affected_resident_stats->date;
            $evac[] = $affected_resident_stats->no_of_evacuees;
            $non_evac[] = $affected_resident_stats->no_of_non_evacuees;
        } else {
            $affected_resident_stats = AffectedResidentStat::where('disaster_response_id', $disaster_response->id)->get();
            // dd($affected_resident_stats->get('date'));
            foreach ($affected_resident_stats as $index) {
                $dates[] = $index->date;
                $evac[] = $index->no_of_evacuees;
                $non_evac[] = $index->no_of_non_evacuees;
            }
        }

        // These are the data for main chart
        $chartData = json_encode($evac, JSON_NUMERIC_CHECK);
        $chartData2 = json_encode($non_evac, JSON_NUMERIC_CHECK);
        $dates = json_encode($dates);


        return view('admin.disaster-response-resource.show')
            ->with(compact('disaster_response', 'barangays', 'data', 'chartData', 'chartData2', 'dates'));
    }
    public function stop($id)
    {
        // $disaster_reponse = DisasterResponse::find($id);
        // $disaster_reponse->date_ended = Carbon::now();
        // $disaster_reponse->save();
        $affected_resident = AffectedResident::where('disaster_response_id', $id)
            ->where('affected_resident_type', 'Evacuee')->count();
        dd($affected_resident);



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