@extends('layouts.mobileBase')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Barangay Information  -->
            <div class="col-md-12 justify-content-between d-flex align-items-baseline p-0">
                <div class="col-6">
                    <h6><b>Barangay:</b></h6>
                    <h6>Triangulo</h6>
                </div>
                <div class="col-6 text-right ">
                    <h1 class="mb-0 pb-0 "><b>123</b></h1>
                    <small>TOTAL RESIDENTS</small>
                </div>

            </div>
            <div class="col-12 text-center mt-4">
                <!-- Progress Bar -->
                <h5 class="progress-title"><b>100 Non Evacuees</b> (80%) </h5>
                <div class="progress">
                    <div class="progress-bar bg-accent" role="progressbar" style="width: 75%" aria-valuenow="75"
                        aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <!-- Female and Male info  -->
                <div class="col-md-6 ml-auto mr-auto mt-5 mb-5">
                    <div class="row">
                        <div class="col-6 border-right ">
                            <h1 class="pb-0 mb-0"><strong>89</strong> </h1>
                            <small>FEMALE</small>
                        </div>
                        <div class="col-6 ">
                            <h1 class="pb-0 mb-0"><strong>89</strong> </h1>
                            <small>MALE</small>
                        </div>
                    </div>

                </div>
                <!-- Sectoral Classification Info -->
                <div class="col-md-6  ml-auto mr-auto">
                    <div class="row">
                        <div class="col-4 border p-2 ">
                            <h3 class="pb-0 mb-0"><strong>89</strong> </h3>
                            <small class="label-small">CHILDREN</small>
                        </div>
                        <div class="col-4 border p-2">
                            <h3 class="pb-0 mb-0"><strong>89</strong> </h3>
                            <small class="label-small">LACTATING</small>
                        </div>
                        <div class="col-4 border p-2">
                            <h3 class="pb-0 mb-0"><strong>89</strong> </h3>
                            <small class="label-small">PWD</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-6  ml-auto mr-auto mb-4">
                    <div class="row">
                        <div class="col-4 border p-2">
                            <h3 class="pb-0 mb-0"><strong>89</strong> </h3>
                            <small class="label-small">PREGNANT</small>
                        </div>
                        <div class="col-4 border p-2">
                            <h3 class="pb-0 mb-0"><strong>89</strong> </h3>
                            <small class="label-small">SENIOR CITIZEN</small>
                        </div>
                        <div class="col-4 border p-2">
                            <h3 class="pb-0 mb-0"><strong>89</strong> </h3>
                            <small class="label-small">SOLO PARENT</small>
                        </div>
                    </div>
                </div>
                <!-- View list of non evacuees link -->
                <div class="col-md-12 center">
                    <a href="">View List</a>
                </div>
                <!-- Register a family button -->
                <div class="col-12 center mt-4 p-0">
                    <div class="col-md-6 p-0">
                        <a href="">
                            <button class="btn btn-primary px-4 ">Register a Resident</button>
                        </a>
                    </div>
                </div>
                <!-- Supply data graph -->
                <div class="col-md-12 justify-content-between d-flex align-items-baseline mt-5 mb-4 p-0">
                    <h5><b>Supply</b></h5>
                    <h6>View Inventory</h6>
                </div>
                <!-- Progress bars -->
                <div class="mb-5">
                    <div class="progress-group">
                        <div class="progress-group-header">
                            <div>Food Packs</div>
                            <div class="mfs-auto font-weight-bold">43%</div>
                        </div>
                        <div class="progress-group-bars">
                            <div class="progress progress-xs">
                                <div class="progress-bar bg-accent" role="progressbar" style="width: 43%"
                                    aria-valuenow="43" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                    <div class="progress-group">
                        <div class="progress-group-header">
                            <div>Water</div>
                            <div class="mfs-auto font-weight-bold">43%</div>
                        </div>
                        <div class="progress-group-bars">
                            <div class="progress progress-xs">
                                <div class="progress-bar bg-accent" role="progressbar" style="width: 43%"
                                    aria-valuenow="43" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                    <div class="progress-group">
                        <div class="progress-group-header">
                            <div>Clothes</div>
                            <div class="mfs-auto font-weight-bold">43%</div>
                        </div>
                        <div class="progress-group-bars">
                            <div class="progress progress-xs">
                                <div class="progress-bar bg-accent" role="progressbar" style="width: 43%"
                                    aria-valuenow="43" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                    <div class="progress-group">
                        <div class="progress-group-header">
                            <div>Hygiene Kit</div>
                            <div class="mfs-auto font-weight-bold">43%</div>
                        </div>
                        <div class="progress-group-bars">
                            <div class="progress progress-xs">
                                <div class="progress-bar bg-accent" role="progressbar" style="width: 43%"
                                    aria-valuenow="43" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                    <div class="progress-group">
                        <div class="progress-group-header">
                            <div>Medicine</div>
                            <div class="mfs-auto font-weight-bold">43%</div>
                        </div>
                        <div class="progress-group-bars">
                            <div class="progress progress-xs">
                                <div class="progress-bar bg-accent" role="progressbar" style="width: 43%"
                                    aria-valuenow="43" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                    <div class="progress-group">
                        <div class="progress-group-header">
                            <div>Emergency Shelter Assistance</div>
                            <div class="mfs-auto font-weight-bold">43%</div>
                        </div>
                        <div class="progress-group-bars">
                            <div class="progress progress-xs">
                                <div class="progress-bar bg-accent" role="progressbar" style="width: 43%"
                                    aria-valuenow="43" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Add and dispanse supply buttons -->
                <div class="col-12 center mt-4 p-0">
                    <div class="col-md-6 p-0 ">
                        <a href="">
                            <button class="btn btn-accent  px-4 ">Add Supply</button>
                        </a>
                    </div>
                </div>
                <div class="col-12 center mt-4 p-0">
                    <div class="col-md-6 mb-4 p-0">
                        <a href="">
                            <button class="btn btn-accent-outline  px-4 ">Dispense</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection