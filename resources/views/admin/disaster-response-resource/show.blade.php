@extends('layouts.webBase')
@section('css')
<link href="{{ asset('css/disaster-response.css') }}" rel="stylesheet">

@endsection

@section('content')
<div class="container">
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
                            <h6 class="card-text ">{{ date('F j, Y', strtotime($disaster_response->date_started)) }}
                            </h6>
                        </div>

                        <div class="ml-auto mr-2">
                            <a href="/disaster-response/export/{{$disaster_response->id}}">
                                <button class="btn btn-danger ">
                                    Export to PDF
                                </button>
                            </a>
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
                <!-- left panel  -->
                <div class="col-md-8">
                    <h5 class="pt-3 pb-3 title">Total Number of Evacuees</h5>
                    <div class="row">
                        <div class="col-6 col-lg-4">
                            <div class="card">
                                <div class="card-body p-2 d-flex align-items-center">
                                    <div class=" p-3 mfe-3" style="background-color: #D7E37D;">
                                        <svg class="c-icon c-icon-xl">
                                            <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-bell"></use>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="text-value" style="color: #D7E37D;">
                                            <h1 class="p-0 m-0"><strong>80</strong></h1>
                                        </div>
                                        <div class="text-muted text-uppercase font-weight-bold small">Children</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-4">
                            <div class="card">
                                <div class="card-body p-2 d-flex align-items-center">
                                    <div class=" p-3 mfe-3" style="background-color: #FFB703;">
                                        <svg class="c-icon c-icon-xl">
                                            <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-bell"></use>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="text-value" style="color: #FFB703;">
                                            <h1 class="p-0 m-0"><strong>80</strong></h1>
                                        </div>
                                        <div class="text-muted text-uppercase font-weight-bold small">Lactating</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-4">
                            <div class="card">
                                <div class="card-body p-2 d-flex align-items-center">
                                    <div class=" p-3 mfe-3" style="background-color: #FB8500;">
                                        <svg class="c-icon c-icon-xl">
                                            <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-bell"></use>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="text-value" style="color: #FB8500;">
                                            <h1 class="p-0 m-0"><strong>80</strong></h1>
                                        </div>
                                        <div class="text-muted text-uppercase font-weight-bold small">PWD</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-4">
                            <div class="card">
                                <div class="card-body p-2 d-flex align-items-center">
                                    <div class=" p-3 mfe-3" style="background-color: #219EBC;">
                                        <svg class="c-icon c-icon-xl">
                                            <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-bell"></use>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="text-value" style="color: #219EBC;">
                                            <h1 class="p-0 m-0"><strong>80</strong></h1>
                                        </div>
                                        <div class="text-muted text-uppercase font-weight-bold small">Pregnant</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-4">
                            <div class="card">
                                <div class="card-body p-2 d-flex align-items-center">
                                    <div class=" p-3 mfe-3" style="background-color: #5464AF;">
                                        <svg class="c-icon c-icon-xl">
                                            <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-bell"></use>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="text-value" style="color: #5464AF;">
                                            <h1 class="p-0 m-0"><strong>80</strong></h1>
                                        </div>
                                        <div class="text-muted text-uppercase font-weight-bold small">Senior Citizen
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-4">
                            <div class="card">
                                <div class="card-body p-2 d-flex align-items-center">
                                    <div class=" p-3 mfe-3" style="background-color: #023047;">
                                        <svg class="c-icon c-icon-xl">
                                            <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-bell"></use>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="text-value" style="color: #023047;">
                                            <h1 class="p-0 m-0"><strong>80</strong></h1>
                                        </div>
                                        <div class="text-muted text-uppercase font-weight-bold small">Solo Parent</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h5 class=" title">Requested Resources Weekly Report</h5>
                        </div>
                        <div class="card-body">
                            <div class="c-chart-wrapper">
                                <canvas id="canvas-1"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- right pannel  -->
                <div class="col-md-4 pb-4 ">
                    <div class="col-12 bg-white ">
                        <h5 class="pt-4 center title">Total Number of Evacuees</h5>
                        <div class="col-12 mt-4 mb-4">
                            <div class="c-chart-wrapper">
                                <canvas id="canvas-3" height="400px"></canvas>

                            </div>
                        </div>
                        @foreach($barangays as $barangay)
                        <div class="pt-1 pb-1">
                            <div>{{$barangay->name}}</div>
                            <div class="progress progress-xs my-2">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: 25%"
                                    aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        @endforeach


                    </div>

                </div>
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
@endsection