@extends('layouts.webBase')

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
@endsection

@section('content')

<div class="container-fluid">
    <div class="fade-in">

        <div class="row justify-content-between d-flex">
            <div class="col-lg-6 ">
                <h1 class="title">
                    Inventory
                </h1>
            </div>

            <div class="dropdown mr-4">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                    data-toggle="dropdown" aria-expanded="false">
                    Export to
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="{{ url('/export/supplies') }}">Excel</a>
                    <a class="dropdown-item" href="{{ url('/export/supplies/pdf') }}" target="_blank">PDF</a>
                </div>
            </div>


        </div>
        @include('admin.inventory-resource.stats')


        <!-- end -->

        <div class="row">
            @if(count($errors) > 0)
            <div class="alert alert-danger col-12">
                <h6>
                    Upload Validation error
                </h6>
                <ul>
                    @foreach($errors as $error)
                    <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
            @endif

        </div>
        <div class="row">
            <div class="col-12">
                @if(Session::has('message'))
                <div class="alert alert-success">{{ Session::get('message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                @if(Session::has('error'))
                <div class="alert alert-danger">{{ Session::get('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
            </div>
        </div>

        <!-- /.row-->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="ml-auto">
                                <div class="dropdown mr-4 ">
                                    <button class="btn btn-secondary secondary-button dropdown-toggle" type="button"
                                        id="dropdownMenuButton1" data-toggle="dropdown" aria-expanded="false">
                                        Action
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <a class="dropdown-item" href="{{ route('supplies.create') }}">Add Supply</a>
                                        <a class="dropdown-item" href="{{ url('/import/supplies') }}">Upload Excel
                                            File</a>
                                    </div>
                                </div>
                            </div>
                        </div>



                    </div>
                    <div class="card-body ">
                        <div>
                            <table id="suppliesTable"
                                class="table table-borderless table-hover table-light table-striped "
                                style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>DATE</th>
                                        <th>SUPPLY_TYPE</th>
                                        <th>QUANTITY</th>
                                        <th>SOURCE</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($inventory_supplies as $supply)

                                    <tr>
                                        <td>{{ $supply->date  }}</td>
                                        <td>{{ $supply->supply_type }}</td>
                                        <td>{{ $supply->quantity }}</td>
                                        <td>{{ $supply->source }}</td>
                                        <td>
                                            <div class="row">
                                                <div class="col-6 ">
                                                    <a href="{{ url('/supplies/' . $supply->id . '/edit') }}"><svg
                                                            class="c-icon ">
                                                            <use
                                                                xlink:href="/assets/icons/coreui/free-symbol-defs.svg#cui-pencil">
                                                            </use>
                                                        </svg>
                                                    </a>

                                                </div>

                                                <div class="col-6 ">
                                                    <form action="{{ route('supplies.destroy', $supply->id ) }}"
                                                        method="post">
                                                        @csrf
                                                        @method("DELETE")
                                                        <button type="submit" value="Delete" name="submit"
                                                            class=" btn-borderless"
                                                            onclick="return confirm('Are you sure to delete?')">
                                                            <svg class="c-icon ">
                                                                <use
                                                                    xlink:href="/assets/icons/coreui/free-symbol-defs.svg#cui-delete">
                                                                </use>
                                                            </svg>
                                                        </button>


                                                    </form>
                                                </div>
                                                </form>
                                            </div>

                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>


                    </div>
                </div>
            </div>
            <!-- /.col-->
        </div>
        <!-- /.row-->
    </div>
</div>

@endsection

@section('javascript')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
<script>
$(document).ready(function() {
    $('#suppliesTable').DataTable({
        "scrollX": true,
    });
});
</script>
@endsection