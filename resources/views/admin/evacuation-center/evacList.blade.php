@extends('layouts.webBase')
@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">

@endsection
@section('content')

<div class="container-fluid">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-lg-6 mr-auto mb-2">
                <h1 class="title">
                    Evacuation Centers
                </h1>
            </div>
            <div class="col-lg-3 ml-auto">

                <button class="btn btn-block export-btn">
                    <svg class="c-icon mr-2">
                        <use xlink:href="{{ url('/icons/sprites/free.svg#cil-file') }}"></use>
                    </svg>
                    Export to Excel
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                @if(Session::has('message'))
                <div class="alert alert-success">{{ Session::get('message') }}</div>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class=" ml-auto ">
                                <a href="{{ route('evacuation-center.create') }}">
                                    <button class="btn btn-secondary secondary-button">
                                        Add Evacuation Center
                                    </button>
                                </a>
                            </div>
                            <div class=" ml-3 mr-4">
                                <a href="#">
                                    <button class="btn btn-outline-primary ">
                                        Upload Excel File
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div>
                            <table id="evacuation_center"
                                class="table table-borderless table-hover table-light table-striped"
                                style="width: 200%;">
                                <thead>
                                    <tr>
                                        <th>NAME</th>
                                        <th>ADDRESS</th>
                                        <th>CHARACTERISTICS</th>
                                        <th>CAMP MANAGER</th>
                                        <th>TOTAL CAPACITY</th>
                                        <th>EVACUEES</th>
                                        <th>MALE</th>
                                        <th>FEMALE</th>
                                        <th>LACTATING</th>
                                        <th>PWD</th>
                                        <th>SENIOR CITIZEN</th>
                                        <th>CHILDREN</th>
                                        <th>PREGNANT</th>
                                        <th>SOLO PARENT</th>
                                        <th></th>
                                        <th>ACTIONS</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($evacuation_centers as $evacuation_center)
                                    <tr>
                                        <td>{{ $evacuation_center->name }}</td>
                                        <td>{{ $evacuation_center->address }}</td>
                                        <td>{{ $evacuation_center->characteristics }}</td>
                                        @if($evacuation_center->camp_manager_name == "")
                                        <td class="text-danger"><strong>{{ __('None') }}</strong></td>
                                        @else
                                        <td>{{ $evacuation_center->camp_manager_name }}</td>
                                        @endif
                                        <td>{{ $evacuation_center->capacity }}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <a href="{{ route('evacuation-center.edit', ['id' => $evacuation_center->id] ) }}"
                                                class="btn btn-light"> <i class="cil-pencil"></i></a>
                                        </td>
                                        <td>
                                            <a href="{{ route('evacuation-center.delete', ['id' => $evacuation_center->id] ) }}"
                                                class="btn btn-danger"> <i class="cil-trash"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{ $evacuation_centers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


@section('javascript')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
<script>
$(document).ready(function() {
    $('#evacuation_center').DataTable({
        "scrollX": true,
    });
});
</script>

@endsection