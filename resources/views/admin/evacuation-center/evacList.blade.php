@extends('layouts.webBase')
@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">

@endsection
@section('content')

<div class="container-fluid">
    <div class="animated fadeIn">
        <div class="row justify-content-between d-flex">
            <div class="col-lg-6 ">
                <h1 class="title">
                    Evacuation Centers
                </h1>
            </div>

            <div class="dropdown mr-4">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                    data-toggle="dropdown" aria-expanded="false">
                    Export to
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="{{ url('/export/evacuation_centers') }}">Excel</a>
                    <a class="dropdown-item" href="{{ url('/export/evacuation_centers/pdf') }}" target="_blank">PDF</a>
                </div>
            </div>


        </div>
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
                <div class="alert alert-success">
                    {{ Session::get('message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
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
                                        <a class="dropdown-item" href="{{ route('evacuation-center.create') }}">Add
                                            Evacuation Center</a>
                                        <a class="dropdown-item"
                                            href="{{ route('evacuation-center.file.import') }}">Upload
                                            Excel File</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div>
                            <table id="evacuationCenter"
                                class="table table-borderless table-hover table-light table-striped ">
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

                                        <th>ACTIONS</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($evacuation_centers as $evacuation_center)
                                    <tr>
                                        <td>{{ $evacuation_center['name'] }}</td>
                                        <td>{{ $evacuation_center['address'] }}</td>
                                        @if($evacuation_center['characteristics'] == null)
                                        <td class="font-italic">No description added.</td>
                                        @else
                                        <td>{{ $evacuation_center['characteristics'] }}</td>
                                        @endif
                                        @if($evacuation_center['camp_manager_name'] == null)
                                        <td class="text-danger"><strong>{{ __('None') }}</strong></td>
                                        @else
                                        <td>{{ $evacuation_center['camp_manager_name'] }}</td>
                                        @endif
                                        <td>{{ $evacuation_center['capacity'] }}</td>
                                        <td>{{ $evacuation_center['total_number_of_evacuees'] }}</td>
                                        <td>{{ $evacuation_center['male'] }}</td>
                                        <td>{{ $evacuation_center['female'] }}</td>
                                        <td>{{ $evacuation_center['lactating'] }}</td>
                                        <td>{{ $evacuation_center['pwd'] }}</td>
                                        <td>{{ $evacuation_center['senior_citizen'] }}</td>
                                        <td>{{ $evacuation_center['children'] }}</td>
                                        <td>{{ $evacuation_center['pregnant'] }}</td>
                                        <td>{{ $evacuation_center['solo_parent'] }}</td>
                                        
                   
                                        <td>
                                            <div class="row">
                                                <div class="col-6 ">
                                                    <a
                                                        href="{{ route('evacuation-center.edit', ['id' => $evacuation_center['id']] ) }}">
                                                        <svg class="c-icon ">
                                                            <use
                                                                xlink:href="/assets/icons/coreui/free-symbol-defs.svg#cui-pencil">
                                                            </use>
                                                        </svg>
                                                    </a>

                                                </div>

                                                <div class="col-6 ">
                                                    <form
                                                        action="{{ route('evacuation-center.delete', ['id' => $evacuation_center['id']] ) }}"
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
    $('#evacuationCenter').DataTable({
        "scrollX": true,
    });
});
</script>

@endsection