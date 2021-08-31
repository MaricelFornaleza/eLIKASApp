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

                <a href="{{ route('evacuation-center.file.export') }}" class="btn btn-block export-btn">
                    <svg class="c-icon mr-2">
                        <use xlink:href="{{ url('/icons/sprites/free.svg#cil-file') }}"></use>
                    </svg>
                    Export to Excel
                </a>
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
                            <div class=" ml-auto ">
                                <a href="{{ route('evacuation-center.create') }}">
                                    <button class="btn btn-secondary secondary-button">
                                        Add Evacuation Center
                                    </button>
                                </a>
                            </div>
                            <div class=" ml-3 mr-4">
                                <a href="{{ route('evacuation-center.file.import') }}">
                                    <button class="btn btn-outline-primary ">
                                        Upload Excel File
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div>
                            <table id="evacuationCenter"
                            class="table table-borderless table-hover table-light table-striped " 
                                >
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
                                        <td>{{ $evacuation_center->name }}</td>
                                        <td>{{ $evacuation_center->address }}</td>
                                        @if($evacuation_center->characteristics == null)
                                        <td><strong>No description added.</strong></td>
                                        @else
                                        <td>{{ $evacuation_center->characteristics }}</td>
                                        @endif
                                        @if($evacuation_center->camp_manager_name == null)
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
                                        <!-- <td>
                                            <a href="{{ route('evacuation-center.edit', ['id' => $evacuation_center->id] ) }}"
                                                class="btn btn-light"> <i class="cil-pencil"></i></a>
                                        
                                            <a href="{{ route('evacuation-center.delete', ['id' => $evacuation_center->id] ) }}"
                                                class="btn btn-danger"> <i class="cil-trash"></i></a>
                                        </td> -->
                                        
                                        <td>
                                            <div class="row">
                                                <div class="col-6 ">
                                                    <a href="{{ route('evacuation-center.edit', ['id' => $evacuation_center->id] ) }}">
                                                        <svg
                                                            class="c-icon ">
                                                            <use
                                                                xlink:href="{{ url('/icons/sprites/free.svg#cil-pencil') }}">
                                                            </use>
                                                        </svg>
                                                    </a>

                                                </div>

                                                <div class="col-6 ">
                                                    <form action="{{ route('evacuation-center.delete', ['id' => $evacuation_center->id] ) }}"
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
    $('#evacuationCenter').DataTable({
        "scrollX": true,
    });
});
</script>

@endsection