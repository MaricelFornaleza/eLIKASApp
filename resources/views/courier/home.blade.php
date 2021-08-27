@extends('layouts.mobileBase')

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
@endsection

@section('content')

<div class="container-fluid">
    <div class="fade-in">
        <div class="row center">
            <div class="col-md-8">
                <!-- Title  -->
                <div class="col-md-12 justify-content-between d-flex align-items-baseline p-0 mb-3">
                    <h5 class="font-weight-bold">Deliveries</h5>
                    <div class="dropdown ">
                        <button class=" btn btn-outline-primary " type=" button" data-toggle="dropdown">Filter
                            <span>
                                <svg class="c-icon ">
                                    <use xlink:href="/assets/icons/coreui/free-symbol-defs.svg#cui-filter"></use>
                                </svg>
                            </span>
                        </button>
                        <ul class="dropdown-menu p-2">
                            <li><a href="#">Pending</a></li>
                            <li><a href="#">In-transit</a></li>
                            <li><a href="#">Delivered</a></li>
                        </ul>
                    </div>
                </div>


                <div class="col-md-6 px-0 pt-4 ">
                    <ul class="list-group list-group-hover list-group-striped">
                        <li class="list-group-item list-group-item-action ">
                            <a href="/courier/details">
                                <div class="row">
                                    <div class="col-8">
                                        <h6 class="font-weight-bold">July 10, 2021</h6>
                                        <small>Del Rosario Elementary School</small>

                                    </div>
                                    <div class="col-4">
                                        <span class="float-right ">
                                            <div class="btn btn-acccent bg-accent text-white text-center">
                                                Accept</div>
                                        </span>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="list-group-item list-group-item-action ">
                            <a href="/courier/details">
                                <div class="row">
                                    <div class="col-8">
                                        <h6 class="font-weight-bold">July 10, 2021</h6>
                                        <small>Del Rosario Elementary School</small>

                                    </div>
                                    <div class="col-4">
                                        <span class="float-right ">
                                            <div class="rounded bg-secondary text-white text-center px-2 py-1">
                                                In-transit</div>
                                        </span>
                                    </div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('javascript')

@endsection