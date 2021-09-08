@extends('layouts.mobileBase')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="col-12 text-center mt-4">
                <!-- Progress Bar -->
                <div class="progress-group">
                    <div class="progress-group-header">
                        <div>
                            <h5 class="progress-title"><b>Evacuees</b> </h5>
                        </div>
                        <div class="mfs-auto "><b>{{ $total_number_of_evacuees }}</b> ({{ round(($total_number_of_evacuees/$capacity)*100) }}%)</div>
                    </div>
                    <div class="progress-group-bars">
                        <div class="progress ">
                            <div class="progress-bar bg-secondary" role="progressbar" style="width: {{ round(($total_number_of_evacuees/$capacity)*100) }}%"
                                aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>

                <!-- Female and Male info  -->
                <div class="col-md-6 ml-auto mr-auto mt-5 mb-5">
                    <div class="row">
                        <div class="col-6 border-right ">
                            <h1 class="pb-0 mb-0"><strong>{{$female}}</strong> </h1>
                            <small>FEMALE</small>
                        </div>
                        <div class="col-6 ">
                            <h1 class="pb-0 mb-0"><strong>{{$male}}</strong> </h1>
                            <small>MALE</small>
                        </div>
                    </div>

                </div>
                <!-- Sectoral Classification Info -->
                <div class="col-md-6  ml-auto mr-auto">
                    <div class="row">
                        <div class="col-4 border p-2 ">
                            <h3 class="pb-0 mb-0"><strong>{{$children}}</strong> </h3>
                            <small class="label-small">CHILDREN</small>
                        </div>
                        <div class="col-4 border p-2">
                            <h3 class="pb-0 mb-0"><strong>{{$lactating}}</strong> </h3>
                            <small class="label-small">LACTATING</small>
                        </div>
                        <div class="col-4 border p-2">
                            <h3 class="pb-0 mb-0"><strong>{{$pwd}}</strong> </h3>
                            <small class="label-small">PWD</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-6  ml-auto mr-auto mb-4">
                    <div class="row">
                        <div class="col-4 border p-2">
                            <h3 class="pb-0 mb-0"><strong>{{$pregnant}}</strong> </h3>
                            <small class="label-small">PREGNANT</small>
                        </div>
                        <div class="col-4 border p-2">
                            <h3 class="pb-0 mb-0"><strong>{{$senior_citizen}}</strong> </h3>
                            <small class="label-small">SENIOR CITIZEN</small>
                        </div>
                        <div class="col-4 border p-2">
                            <h3 class="pb-0 mb-0"><strong>{{$solo_parent}}</strong> </h3>
                            <small class="label-small">SOLO PARENT</small>
                        </div>
                    </div>
                </div>

                <!-- Admit and Discharge supply buttons -->
                <div class="col-12 center mt-5 p-0">
                    <div class="col-md-6 p-0 ">
                        <a href="/camp-manager/admit-view">
                            <button class="btn btn-accent  px-4 ">Admit</button>
                        </a>
                    </div>
                </div>
                <div class="col-12 center mt-4 p-0">
                    <div class="col-md-6 mb-4 p-0">
                        <a href="/camp-manager/discharge-view">
                            <button class="btn btn-accent-outline  px-4 ">Discharge</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection