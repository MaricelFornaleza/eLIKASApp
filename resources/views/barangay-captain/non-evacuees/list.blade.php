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
                    <h5 class="font-weight-bold">Non Evacuees</h5>
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
                            <li><a href="#">Family Representative</a></li>
                            <li><a href="#">Children</a></li>
                            <li><a href="#">Lactating</a></li>
                            <li><a href="#">PWD</a></li>
                            <li><a href="#">Pregnant</a></li>
                            <li><a href="#">Solo Parent</a></li>
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
                        @foreach($non_evacuees as $non_evacuee)
                        <li class="list-group-item list-group-item-action ">
                            <div class="form-check">
                                <label class="form-check-label" for="name0">
                                    {{$non_evacuee->name}}
                                </label>
                                <span class="float-right my-2">
                                    <div class="rounded-circle bg-secondary" style="height: 10px; width:10px;"></div>
                                </span>
                            </div>
                        </li>
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