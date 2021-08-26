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
                    <h5 class="font-weight-bold">Supply Details</h5>
                </div>

                <div class="col-md-6 px-0 pt-4 ">
                    <ul class="list-group list-group-hover list-group-striped">
                        <li class="list-group-item list-group-item-action ">
                            <div class="row">
                                <div class="col-5">
                                    <h6 class="font-weight-bold">Date:</h6>
                                </div>
                                <div class="col-7">
                                    <h6>{{ date('F j, Y', strtotime($supply->created_at)) }}</h6>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item list-group-item-action ">
                            <div class="row">
                                <div class="col-5">
                                    <h6 class="font-weight-bold">Supply Type:</h6>
                                </div>
                                <div class="col-7">
                                    <h6>{{ $supply->supply_type }}</h6>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item list-group-item-action ">
                            <div class="row">
                                <div class="col-5">
                                    <h6 class="font-weight-bold">Quantity:</h6>
                                </div>
                                <div class="col-7">
                                    <h6>{{ $supply->quantity }}</h6>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item list-group-item-action ">
                            <div class="row">
                                <div class="col-5">
                                    <h6 class="font-weight-bold">Source:</h6>
                                </div>
                                <div class="col-7">
                                    <h6>{{ $supply->source }}</h6>
                                </div>
                            </div>
                        </li>
                    </ul>

                </div>
                <!-- Buttons -->
                <div class="fixed-bottom px-2">
                    <div class="col-12 center mt-5 ">
                        <div class="col-md-6 p-0 ">
                            <a href="">
                                <button class="btn btn-accent  px-4 ">Edit</button>
                            </a>
                        </div>
                    </div>
                    <div class="col-12 center mt-4">
                        <div class="col-md-6 mb-4 p-0">
                            <a href="">
                                <button class="btn btn-accent-outline  px-4 ">Delete</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('javascript')

@endsection