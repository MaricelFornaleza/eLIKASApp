@extends('layouts.webBase')
@section('css')
<link href="{{ asset('css/disaster-response.css') }}" rel="stylesheet">

@endsection

@section('content')
<div class="container" id="content">
    <div class="row justify-content-center">
        <div class="col-md-11 ">
            <div class="card ">
                <img class="card-img-top " src="{{url('/assets/dr-cover/'.$disaster_response -> photo)}}"
                    alt="{{$disaster_response->disaster_type}}"
                    style="height: 150px; object-fit: cover;  object-position: 0% 70%;">
                <div class="card-img-overlay">
                    <div class="row">
                        <div class="col-6">
                            <h4 class="card-title mb-5 ">{{$disaster_response->disaster_type}}</h4>
                            <h6 class="card-text mb-0">{{$disaster_response->description}}</h6>
                            <small class="card-text ">
                                {{ date('F j, Y', strtotime($disaster_response->date_started)) }}
                                @empty($disaster_response->date_ended)
                                @else
                                - {{ date('F j, Y', strtotime($disaster_response->date_started)) }}
                                @endempty
                            </small>
                        </div>

                        <div class="ml-auto mr-2">

                            <button class="btn btn-danger " onclick="generatePDF()">
                                Export to PDF
                            </button>

                        </div>

                    </div>


                </div>
            </div>
        </div>

        <div class="col-md-11">
            @if(Session::has('message'))
            <div class="alert alert-success">{{ Session::get('message') }}
            </div>
            @endif
        </div>

        <div class="col-md-11">
            <div class="row">

                <div class="col-md-12">

                    <!-- @include('admin.disaster-response-resource.details.section1') -->

                    <!-- Section 1 -->
                    <div class="row">
                        <div class="col-6 col-lg-3">
                            <div class="card">
                                <div class="card-body p-0">
                                    <div class="c-callout c-callout-first my-0 py-2">
                                        <small class="text-muted ">Affected Barangay</small>
                                        <div class="text-value-lg ">
                                            <h1 class="p-0 m-0"><strong>{{$barangays->count()}}</strong> </h1>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3">
                            <div class="card">
                                <div class="card-body p-0">
                                    <div class="c-callout c-callout-second my-0 py-2">
                                        <small class="text-muted ">Affected Individuals</small>
                                        <div class="text-value-lg ">
                                            <h1 class="p-0 m-0"><strong>{{$data['affected_residents']}}</strong> </h1>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3">
                            <div class="card">
                                <div class="card-body p-0">
                                    <div class="c-callout c-callout-third my-0 py-2">
                                        <small class="text-muted ">Affected Families</small>
                                        <div class="text-value-lg ">
                                            <h1 class="p-0 m-0"><strong>{{$data['families']}}</strong> </h1>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3">
                            <div class="card">
                                <div class="card-body p-0">
                                    <div class="c-callout c-callout-fourth my-0 py-2">
                                        <small class="text-muted ">Dispensed Relief Goods</small>
                                        <div class="text-value-lg ">
                                            <h1 class="p-0 m-0"><strong>{{$data['relief_goods']['count']}}</strong>
                                            </h1>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- end Section 1 -->

                    <!-- Affected Residents Chart -->
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-5">
                                    <h4 class="card-title mb-0">Affected Residents</h4>
                                    <div class="small text-muted">
                                        {{ date('F Y', strtotime($disaster_response->date_started)) }}
                                    </div>
                                </div>
                                <!-- /.col-->

                            </div>
                            <!-- /.row-->
                            <div class="c-chart-wrapper" style="height:300px; max-width: 930px; margin-top:40px;">
                                <canvas class="chart" id="canvas-2" height="300"></canvas>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row text-center justify-content-center">
                                <div class="col-sm-12 col-md-4 mb-sm-2 mb-0">
                                    <div class="text-muted">Evacuees</div><strong>{{$data['evacuees']}}
                                        ({{round((($data['evacuees'] / $data['affected_residents']) *100), 2)}}%)</strong>

                                    <div class="progress progress-xs mt-2">

                                        <div class="progress-bar bg-accent" role="progressbar"
                                            style="width: {{($data['evacuees'] / $data['affected_residents']) *100}}%"
                                            aria-valuenow="{{$data['evacuees']}}"
                                            aria-valuemin="{{$data['affected_residents']}}" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4 mb-sm-2 mb-0">
                                    <div class="text-muted">Non-evacuees</div><strong>{{$data['non-evacuees']}}
                                        ({{round((($data['non-evacuees'] / $data['affected_residents']) *100),2)}}%)</strong>
                                    <div class="progress progress-xs mt-2">
                                        <div class="progress-bar bg-primary" role="progressbar"
                                            style="width: {{($data['non-evacuees'] / $data['affected_residents']) *100}}%"
                                            aria-valuenow="{{$data['non-evacuees']}}" aria-valuemin="0"
                                            aria-valuemax="{{$data['affected_residents']}}"></div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end Affected Residents Chart -->
                    <!-- section 3 -->
                    <div class="row" id="row">
                        <!-- Dispense Relief Goods -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">Relief Goods</div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="c-callout c-callout-second"><small
                                                            class="text-muted">Dispensed Relief
                                                            Goods</small>
                                                        <div class="text-value-lg">{{$data['relief_goods']['count']}}
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- /.col-->

                                            </div>
                                            <!-- /.row-->
                                            <hr class="mt-0">
                                            <div class="progress-group mb-4">
                                                <div class="progress-group-prepend"><span
                                                        class="progress-group-text">Clothes</span></div>
                                                <div class="progress-group-bars">
                                                    <div class="clearfix">
                                                        <div class="float-right">
                                                            <strong>{{$data['relief_goods']['clothes']}}</strong> <small
                                                                class="text-muted">({{round((($data['relief_goods']['clothes'] / $data['affected_residents']) *100),2)}}%)</small>
                                                        </div>
                                                    </div>
                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar bg-accent" role="progressbar"
                                                            style="width: {{($data['relief_goods']['clothes'] / $data['affected_residents']) *100}}%"
                                                            aria-valuenow="{{$data['relief_goods']['clothes']}}"
                                                            aria-valuemin="0"
                                                            aria-valuemax="{{$data['affected_residents']}}"></div>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="progress-group mb-4">
                                                <div class="progress-group-prepend"><span
                                                        class="progress-group-text">ESA</span>
                                                </div>
                                                <div class="progress-group-bars">
                                                    <div class="clearfix">
                                                        <div class="float-right">
                                                            <strong>{{$data['relief_goods']['emergency_shelter_assistance']}}</strong>
                                                            <small
                                                                class="text-muted">({{round((($data['relief_goods']['emergency_shelter_assistance'] / $data['affected_residents']) *100),2)}}%)</small>
                                                        </div>
                                                    </div>
                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar bg-accent" role="progressbar"
                                                            style="width: {{($data['relief_goods']['emergency_shelter_assistance'] / $data['affected_residents']) *100}}%"
                                                            aria-valuenow="{{$data['relief_goods']['emergency_shelter_assistance']}}"
                                                            aria-valuemin="0"
                                                            aria-valuemax="{{$data['affected_residents']}}"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="progress-group mb-4">
                                                <div class="progress-group-prepend"><span
                                                        class="progress-group-text">Food Packs</span>
                                                </div>
                                                <div class="progress-group-bars">
                                                    <div class="clearfix">
                                                        <div class="float-right">
                                                            <strong>{{$data['relief_goods']['food_packs']}}</strong>
                                                            <small
                                                                class="text-muted">({{round((($data['relief_goods']['food_packs'] / $data['affected_residents']) *100),2)}}%)</small>
                                                        </div>
                                                    </div>
                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar bg-accent" role="progressbar"
                                                            style="width:{{($data['relief_goods']['food_packs'] / $data['affected_residents']) * 100}}%"
                                                            aria-valuenow="{{$data['relief_goods']['food_packs']}}"
                                                            aria-valuemin="0"
                                                            aria-valuemax="{{$data['affected_residents']}}"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="progress-group mb-4">
                                                <div class="progress-group-prepend"><span
                                                        class="progress-group-text">Hygiene Kit</span></div>
                                                <div class="progress-group-bars">
                                                    <div class="clearfix">
                                                        <div class="float-right">
                                                            <strong>{{$data['relief_goods']['hygiene_kit']}}</strong>
                                                            <small
                                                                class="text-muted">({{round((($data['relief_goods']['hygiene_kit'] / $data['affected_residents']) *100),2)}}%)</small>
                                                        </div>
                                                    </div>
                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar bg-accent" role="progressbar"
                                                            style="width: {{($data['relief_goods']['hygiene_kit'] / $data['affected_residents']) *100}}%"
                                                            aria-valuenow="{{$data['relief_goods']['hygiene_kit']}}"
                                                            aria-valuemin="0"
                                                            aria-valuemax="{{$data['affected_residents']}}"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="progress-group mb-4">
                                                <div class="progress-group-prepend"><span
                                                        class="progress-group-text">Medicine</span></div>
                                                <div class="progress-group-bars">
                                                    <div class="clearfix">
                                                        <div class="float-right">
                                                            <strong>{{$data['relief_goods']['medicine']}}</strong>
                                                            <small
                                                                class="text-muted">({{round((($data['relief_goods']['medicine'] / $data['affected_residents']) *100),2)}}%)</small>
                                                        </div>
                                                    </div>
                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar bg-accent" role="progressbar"
                                                            style="width: {{($data['relief_goods']['medicine'] / $data['affected_residents']) *100}}%"
                                                            aria-valuenow="{{$data['relief_goods']['medicine']}}"
                                                            aria-valuemin="0"
                                                            aria-valuemax="{{$data['affected_residents']}}"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="progress-group mb-4">
                                                <div class="progress-group-prepend"><span
                                                        class="progress-group-text">Water</span>
                                                </div>
                                                <div class="progress-group-bars">
                                                    <div class="clearfix">
                                                        <div class="float-right">
                                                            <strong>{{$data['relief_goods']['water']}}</strong> <small
                                                                class="text-muted">({{round((($data['relief_goods']['water'] / $data['affected_residents']) *100),2)}}%)</small>
                                                        </div>
                                                    </div>
                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar bg-accent" role="progressbar"
                                                            style="width: {{($data['relief_goods']['water'] / $data['affected_residents']) *100}}%"
                                                            aria-valuenow="{{$data['relief_goods']['water']}}"
                                                            aria-valuemin="0"
                                                            aria-valuemax="{{$data['affected_residents']}}"></div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- Sectoral Classification -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">Sectoral Breakdown</div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="c-callout c-callout-second"><small
                                                            class="text-muted">Female</small>
                                                        <div class="text-value-lg">{{$data['female']}}</div>
                                                    </div>
                                                </div>
                                                <!-- /.col-->
                                                <div class="col-6">
                                                    <div class="c-callout c-callout-fourth"><small
                                                            class="text-muted">Male</small>
                                                        <div class="text-value-lg">{{$data['male']}}</div>
                                                    </div>
                                                </div>
                                                <!-- /.col-->
                                            </div>
                                            <!-- /.row-->
                                            <hr class="mt-0">
                                            <div class="progress-group mb-4">
                                                <div class="progress-group-prepend"><span
                                                        class="progress-group-text">Children</span></div>
                                                <div class="progress-group-bars">
                                                    <div class="clearfix">
                                                        <div class="float-right">
                                                            <strong>{{$data['sectors']['children']}}</strong> <small
                                                                class="text-muted">({{round((($data['sectors']['children'] / $data['affected_residents']) *100), 2)}}%)</small>
                                                        </div>
                                                    </div>
                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar bg-primary" role="progressbar"
                                                            style="width: {{($data['sectors']['children']/$data['affected_residents']) * 100}}%"
                                                            aria-valuenow="{{$data['sectors']['children']}}"
                                                            aria-valuemin="0"
                                                            aria-valuemax="{{$data['affected_residents']}}"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="progress-group mb-4">
                                                <div class="progress-group-prepend"><span
                                                        class="progress-group-text">Lactating</span>
                                                </div>
                                                <div class="progress-group-bars">
                                                    <div class="clearfix">
                                                        <div class="float-right">
                                                            <strong>{{$data['sectors']['lactating']}}</strong> <small
                                                                class="text-muted">({{round((($data['sectors']['lactating'] / $data['affected_residents']) *100), 2)}}%)</small>
                                                        </div>
                                                    </div>
                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar bg-primary" role="progressbar"
                                                            style="width: {{($data['sectors']['lactating']/$data['affected_residents']) * 100}}%"
                                                            aria-valuenow="{{$data['sectors']['lactating']}}"
                                                            aria-valuemin="0"
                                                            aria-valuemax="{{$data['affected_residents']}}"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="progress-group mb-4">
                                                <div class="progress-group-prepend"><span
                                                        class="progress-group-text">PWD</span></div>
                                                <div class="progress-group-bars">
                                                    <div class="clearfix">
                                                        <div class="float-right">
                                                            <strong>{{$data['sectors']['PWD']}}</strong> <small
                                                                class="text-muted">({{round((($data['sectors']['PWD'] / $data['affected_residents']) *100),2)}}%)</small>
                                                        </div>
                                                    </div>
                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar bg-primary" role="progressbar"
                                                            style="width: {{($data['sectors']['PWD']/$data['affected_residents']) * 100}}%"
                                                            aria-valuenow="{{$data['sectors']['PWD']}}"
                                                            aria-valuemin="0"
                                                            aria-valuemax="{{$data['affected_residents']}}"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="progress-group mb-4">
                                                <div class="progress-group-prepend"><span
                                                        class="progress-group-text">Pregnant</span></div>
                                                <div class="progress-group-bars">
                                                    <div class="clearfix">
                                                        <div class="float-right">
                                                            <strong>{{$data['sectors']['pregnant']}}</strong> <small
                                                                class="text-muted">({{round((($data['sectors']['pregnant'] / $data['affected_residents']) *100), 2)}}%)</small>
                                                        </div>
                                                    </div>
                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar bg-primary" role="progressbar"
                                                            style="width: {{($data['sectors']['pregnant']/$data['affected_residents']) * 100}}%"
                                                            aria-valuenow="{{$data['sectors']['pregnant']}}"
                                                            aria-valuemin="0"
                                                            aria-valuemax="{{$data['affected_residents']}}"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="progress-group mb-4">
                                                <div class="progress-group-prepend"><span
                                                        class="progress-group-text">Senior Citizen</span>
                                                </div>
                                                <div class="progress-group-bars">
                                                    <div class="clearfix">
                                                        <div class="float-right">
                                                            <strong>{{$data['sectors']['senior']}}</strong> <small
                                                                class="text-muted">({{round((($data['sectors']['senior'] / $data['affected_residents']) *100),2)}}%)</small>
                                                        </div>
                                                    </div>
                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar bg-primary" role="progressbar"
                                                            style="width: {{($data['sectors']['senior']/$data['affected_residents']) * 100}}%"
                                                            aria-valuenow="{{$data['sectors']['senior']}}"
                                                            aria-valuemin="0"
                                                            aria-valuemax="{{$data['affected_residents']}}"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="progress-group mb-4">
                                                <div class="progress-group-prepend"><span
                                                        class="progress-group-text">Solo Parent</span>
                                                </div>
                                                <div class="progress-group-bars">
                                                    <div class="clearfix">
                                                        <div class="float-right">
                                                            <strong>{{$data['sectors']['solo']}}</strong> <small
                                                                class="text-muted">({{round((($data['sectors']['solo'] / $data['affected_residents']) *100),2)}}%)</small>
                                                        </div>
                                                    </div>
                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar bg-primary" role="progressbar"
                                                            style="width: {{($data['sectors']['solo']/$data['affected_residents']) * 100}}%"
                                                            aria-valuenow="{{$data['sectors']['solo']}}"
                                                            aria-valuemin="0"
                                                            aria-valuemax="{{$data['affected_residents']}}"></div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- end section 3 -->
                </div>

                <!-- affected Areas -->
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">Affected Areas</div>
                        <div class="card-body">
                            <table class="table table-responsive-sm table-hover table-outline mb-0">
                                <thead class="thead-light">
                                    <tr>

                                        <th>Barangay</th>
                                        <th>Total Residents</th>
                                        <th>Evacuees</th>
                                        <th>Non-evacuees</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data['barangayData'] as $barangay)
                                    <tr>
                                        <td>
                                            <div>{{$barangay['barangay']}}</div>
                                            <div class="small text-muted">Naga City
                                            </div>
                                        </td>
                                        <td>{{$barangay['total_residents']}}</td>
                                        <td>
                                            <div class="clearfix">
                                                <div class="float-left"><strong>{{$barangay['evacuees']}}</strong></div>
                                                <div class="float-right"><small
                                                        class="text-muted">({{round((($barangay['evacuees'] / $barangay['total_residents']) *100), 2)}}%)</small>
                                                </div>
                                            </div>
                                            <div class="progress progress-xs">
                                                <div class="progress-bar bg-accent" role="progressbar"
                                                    style="width: {{round((($barangay['evacuees'] / $barangay['total_residents']) *100), 2)}}%"
                                                    aria-valuenow="{{$barangay['evacuees']}}" aria-valuemin="0"
                                                    aria-valuemax="{{$barangay['total_residents']}}"></div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="clearfix">
                                                <div class="float-left"><strong>{{$barangay['non_evacuees']}}</strong>
                                                </div>
                                                <div class="float-right"><small
                                                        class="text-muted">({{round((($barangay['non_evacuees'] / $barangay['total_residents']) *100), 2)}}%)</small>
                                                </div>
                                            </div>
                                            <div class="progress progress-xs">
                                                <div class="progress-bar bg-primary" role="progressbar"
                                                    style="width: {{round((($barangay['non_evacuees'] / $barangay['total_residents']) *100), 2)}}%"
                                                    aria-valuenow="{{$barangay['non_evacuees']}}" aria-valuemin="0"
                                                    aria-valuemax="{{$barangay['total_residents']}}"></div>
                                            </div>
                                        </td>

                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- end affected areas -->

            </div>

        </div>


    </div>
</div>
@endsection
@section('javascript')
<script src="{{ asset('js/Chart.min.js') }}"></script>
<script src="{{ asset('js/coreui-chartjs.bundle.js') }}"></script>
<script src="{{ asset('js/reports-js/donut.js') }}"></script>
<script src="{{ asset('js/reports-js/line.js') }}"></script>
<script src="{{ asset('js/reports-js/barChart.js') }}" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"
    integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>



<script>
var chartData = <?php echo $chartData; ?>;
var chartData2 = <?php echo $chartData2; ?>;
var dates = <?php echo $dates; ?>;


function generatePDF() {
    var opt = {
        margin: [.20, 0, .20, 0],
        filename: 'Disaster_Response.pdf',
        image: {
            type: 'jpeg',
            quality: 1
        },
        html2canvas: {
            scale: 2
        },
        jsPDF: {
            unit: 'in',
            format: 'letter',
            orientation: 'portrait'
        },
        pagebreak: {
            mode: 'css',
            before: '#row'
        }

    };
    document.getElementById('canvas-2').style.width = '100%';

    // Choose the element that our invoice is rendered in.
    element = document.getElementById('content');

    // Choose the element and save the PDF for our user.
    // html2pdf().set(opt).from(element).save();
    html2pdf().set(opt).from(element).toPdf().get('pdf').then(function(pdf) {
        window.open(pdf.output('bloburl'), '_blank');
    });



}
</script>
@endsection