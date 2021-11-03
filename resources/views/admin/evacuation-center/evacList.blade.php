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
        <!-- modal  -->
        <div class="modal fade" id="view" data-backdrop="static" data-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-secondary text-white">
                        <h5 class="modal-title" id="staticBackdropLabel">Details
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="mb-2 col-6">
                                <label for="name" class="col-form-label small ">Name:</label>
                                <h6 id="name" class="font-weight-bold"></h6>

                            </div>
                            <div class="mb-2 col-6">
                                <label for="address" class="col-form-label small ">Address:</label>
                                <span class="badge badge-pill text-white verify">
                                </span>
                                <h6 id="address" class="font-weight-bold">
                                </h6>
                            </div>

                        </div>
                        <div class="row">
                            <div class="mb-2 col-6">
                                <label for="capacity" class="col-form-label small ">Total
                                    Capacity:</label>

                                <h6 id="capacity" class="font-weight-bold">
                                </h6>
                            </div>
                            <div class="mb-2 col-6">
                                <label for="camp_manager" class="col-form-label small ">Camp
                                    Manager:</label>
                                <h6 id="camp_manager" class="font-weight-bold">
                                </h6>
                            </div>

                        </div>


                        <div class="mb-2 ">
                            <label for="characteristics" class="col-form-label small ">Characteristics:</label>
                            <h6 id="characteristics" class="font-weight-bold">
                            </h6>
                        </div>


                    </div>
                    <div class="dropdown-divider"></div>

                    <!-- Female and Male info  -->
                    <div class="col-md-8 ml-auto mr-auto mt-5 mb-5 text-center">
                        <div class="row">
                            <div class="col-6 border-right ">
                                <h1 class="pb-0 mb-0">
                                    <strong id=female></strong>
                                </h1>
                                <small>FEMALE</small>
                            </div>
                            <div class="col-6 ">
                                <h1 class="pb-0 mb-0"><strong id="male"></strong>
                                </h1>
                                <small>MALE</small>
                            </div>
                        </div>

                    </div>
                    <!-- Sectoral Classification Info -->
                    <div class="col-md-8  ml-auto mr-auto text-center">
                        <div class="row">
                            <div class="col-4 border p-2 ">
                                <h3 class="pb-0 mb-0">
                                    <strong id="children"></strong>
                                </h3>
                                <small class="label-small">CHILDREN</small>
                            </div>
                            <div class="col-4 border p-2">
                                <h3 class="pb-0 mb-0">
                                    <strong id="lactating"></strong>
                                </h3>
                                <small class="label-small">LACTATING</small>
                            </div>
                            <div class="col-4 border p-2">
                                <h3 class="pb-0 mb-0"><strong id="pwd"></strong>
                                </h3>
                                <small class="label-small">PWD</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8  ml-auto mr-auto mb-4 text-center">
                        <div class="row">
                            <div class="col-4 border p-2">
                                <h3 class="pb-0 mb-0">
                                    <strong id="pregnant"></strong>
                                </h3>
                                <small class="label-small">PREGNANT</small>
                            </div>
                            <div class="col-4 border p-2">
                                <h3 class="pb-0 mb-0">
                                    <strong id="senior_citizen"></strong>
                                </h3>
                                <small class="label-small">SENIOR
                                    CITIZEN</small>
                            </div>
                            <div class="col-4 border p-2">
                                <h3 class="pb-0 mb-0">
                                    <strong id="solo_parent"></strong>
                                </h3>
                                <small class="label-small">SOLO PARENT</small>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <a href="" id="edit">
                            <button type="button" class="btn bg-secondary text-white">Edit</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- row  -->
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
                                class="table table-borderless table-hover table-light table-striped "
                                style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>NAME</th>
                                        <th>ADDRESS</th>

                                        <th>CAMP MANAGER</th>
                                        <th>TOTAL CAPACITY</th>


                                        <th>ACTIONS</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($evacuation_centers as $evacuation_center)
                                    <tr>
                                        <td>{{ $evacuation_center['name'] }}</td>
                                        <td>{{ $evacuation_center['address'] }}</td>

                                        @if($evacuation_center['camp_manager_name'] == null)
                                        <td class="text-danger"><strong>{{ __('None') }}</strong></td>
                                        @else
                                        <td>{{ $evacuation_center['camp_manager_name'] }}</td>
                                        @endif
                                        <td>{{ $evacuation_center['capacity'] }}</td>



                                        <td>
                                            <div class="row">

                                                <div class="mr-4 ">
                                                    <button type="button" class="btn bg-secondary-accent text-white "
                                                        id="button" data-toggle="modal" data-target="#view"
                                                        data-array="{{json_encode($evacuation_center)}}">
                                                        View
                                                    </button>

                                                </div>


                                                <div class="col-6 ">
                                                    <form
                                                        action="{{ route('evacuation-center.delete', ['id' => $evacuation_center['id']] ) }}"
                                                        method="post">
                                                        @csrf
                                                        @method("DELETE")
                                                        <button type="submit" value="Delete" name="submit"
                                                            class=" btn btn-transparent text-danger"
                                                            onclick="return confirm('Are you sure to delete?')">
                                                            Delete
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

<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
<script>
$(document).ready(function() {
    $('#evacuationCenter').DataTable({

    });
    $('#view').on('shown.coreui.modal', function(e) {

        var modal = $(this);
        var button = $(e.relatedTarget);
        var data = button.data('array');

        modal.find('#name').text(data['name']);
        modal.find('#address').text(data['address']);
        if (data['camp_manager_name'] == null) {
            modal.find('#camp_manager').text("None");
        } else {
            modal.find('#camp_manager').text(data['camp_manager_name']);
        }
        modal.find('#capacity').text(data['capacity']);
        if (data['characteristics'] == null) {
            modal.find('#characteristics').text("No description added.");
        } else {
            modal.find('#characteristics').text(data['characteristics']);
        }
        modal.find("#female").text(data['female']);
        modal.find("#male").text(data['male']);
        modal.find("#children").text(data['children']);
        modal.find("#lactating").text(data['lactating']);
        modal.find("#pwd").text(data['pwd']);
        modal.find("#pregnant").text(data['pregnant']);
        modal.find("#senior_citizen").text(data['senior_citizen']);
        modal.find("#solo_parent").text(data['solo_parent']);
        modal.find("#edit").attr('href',
            "{{route('evacuation-center.edit',)}}?id=" + data['id']);
        console.log(data['id'])


    });

});
</script>

@endsection