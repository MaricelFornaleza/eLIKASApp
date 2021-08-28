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
                    <h5 class="font-weight-bold">Inventory</h5>
                </div>
                <div class="row">
                    <div class="col-12">
                        @if(Session::has('message'))
                        <div class="alert alert-success">{{ Session::get('message') }}</div>
                        @endif
                    </div>
                </div>
                <div class="justify-content-between d-flex">
                    <div class="dropdown ">
                        <button class=" btn btn-outline-primary " type=" button" data-toggle="dropdown">Filter
                            <span>
                                <svg class="c-icon ">
                                    <use xlink:href="/assets/icons/coreui/free-symbol-defs.svg#cui-filter"></use>
                                </svg>
                            </span>
                        </button>
                        <ul class="dropdown-menu p-2">
                            <li><a href="#">Food Packs</a></li>
                            <li><a href="#">Water</a></li>
                            <li><a href="#">Clothes</a></li>
                            <li><a href="#">Hygiene Kit</a></li>
                            <li><a href="#">Medicine</a></li>
                            <li><a href="#">ESA</a></li>
                        </ul>
                    </div>
                    <div class="col-9 p-0 float-right">
                        <div class="input-group">
                            <!-- <span class="input-group-addon">Search</span> -->
                            <input type="text" name="search-text" id="search-text" placeholder="Search"
                                class="form-control ">
                        </div>
                        </span>

                    </div>

                </div>

                <div class="col-md-6 px-0 pt-4 ">
                    <ul class="list-group list-group-hover list-group-striped">
                        @foreach($inventory_supplies as $supply)
                        <a href="/barangay-captain/details/{{ $supply->id }}">
                            <li class="list-group-item list-group-item-action ">
                                <div class="row">
                                    <div class="col-7">
                                        <h6 class="font-weight-bold">{{ $supply->supply_type }}</h6>
                                        <small>{{ $supply->quantity }} pcs</small>
                                        <br>
                                        <small>{{ $supply->source }} </small>
                                    </div>
                                    <div class="col-5">
                                        <span class="float-right ">
                                            <small>{{ date('F j, Y', strtotime($supply->created_at)) }}</small>
                                        </span>
                                    </div>
                                </div>
                            </li>
                        </a>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('javascript')

@endsection