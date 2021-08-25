@extends('layouts.mobileBase')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Barangay Information  -->
            <div class="col-md-12 justify-content-between d-flex align-items-middle p-0">
                <div class="col-6">
                    <h6><b>Evacuation Center</b></h6>
                    <h6>Del Rosario Elementary School</h6>
                </div>
                <div class="col-6 text-right ">
                    <h1 class="mb-0 pb-0 "><b>123</b></h1>
                    <small>TOTAL EVACUEES</small>
                </div>

            </div>
            <div class="col-12 text-center mt-5  ">
                <!-- Progress Bar -->
                <h5 class="progress-title"><b>100 Evacuees</b> (80%) </h5>
                <div class="progress">
                    <div class="progress-bar bg-secondary" role="progressbar" style="width: 75%" aria-valuenow="75"
                        aria-valuemin="0" aria-valuemax="100"></div>
                </div>

                <div class="row mt-5">
                    <!-- Evacuees button -->
                    <div class="col-md-6 col-lg-4  ">
                        <div class="card overflow-hidden">
                            <div class="card-body p-0 d-flex align-items-center">
                                <div class="bg-accent py-4 px-4 mfe-3">
                                    <svg class="c-icon c-icon-xl">
                                        <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-settings"></use>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-value text-accent">
                                        <h5 class="mb-0 pb-0"><b>Evacuees</b> </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Supply Button -->
                    <div class="col-md-6 col-lg-4  ">
                        <div class="card overflow-hidden">
                            <div class="card-body p-0 d-flex align-items-center">
                                <div class="bg-secondary py-4 px-4 mfe-3">
                                    <svg class="c-icon c-icon-xl">
                                        <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-settings"></use>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-value text-secondary">
                                        <h5 class="mb-0 pb-0"><b>Supply</b> </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Request Button -->
                    <div class="col-md-6 col-lg-4  ">
                        <div class="card overflow-hidden">
                            <div class="card-body p-0 d-flex align-items-center">
                                <div class="bg-primary py-4 px-4 mfe-3">
                                    <svg class="c-icon c-icon-xl">
                                        <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-settings"></use>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-value text-primary">
                                        <h5 class="mb-0 pb-0"><b>Request</b> </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>


            </div>
        </div>
    </div>
    @endsection