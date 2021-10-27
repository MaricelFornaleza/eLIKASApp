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
                    Residents
                </h1>
            </div>

            <div class="dropdown mr-4">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1"
                    data-toggle="dropdown" aria-expanded="false">
                    Export to
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <a class="dropdown-item" href="{{ url('/export/residents') }}">Excel</a>
                    <a class="dropdown-item" href="{{ url('/export/residents/pdf') }}" target="_blank">PDF</a>
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
                <div class="alert alert-success">{{ Session::get('message') }}
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
                                        id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
                                        Action
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="{{ route('residents.create') }}">Add Resident</a>
                                        <a class="dropdown-item" href="{{ route('residents.group') }}">Group
                                            Resident</a>
                                        <a class="dropdown-item" href="{{ url('/import/residents') }}">Upload Excel
                                            File</a>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="card-body ">
                        <div>
                            <table id="familyMembersTable"
                                class="table table-borderless table-hover table-light table-striped "
                                style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>FAMILY CODE</th>
                                        <th>NAME</th>
                                        <th>SECTORAL CLASSIFICATION</th>
                                        <th>ADDRESS</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($family_members as $family_member)

                                    <tr>
                                        @if($family_member->family_code == "")
                                        <td class="text-danger"><strong>{{ __('N/A') }}</strong></td>
                                        @else
                                        <td>{{ $family_member->family_code }}</td>
                                        @endif
                                        <td>{{ $family_member->name }}</td>
                                        <td>{{ $family_member->sectoral_classification }}</td>
                                        <td>{{ $family_member->street }}, {{ $family_member->barangay }}</td>
                                        <td>
                                            <div class="row">
                                                <div class="mr-4 ">
                                                    <button type="button" class="btn bg-secondary-accent text-white "
                                                        id="button" data-toggle="modal" data-target="#view"
                                                        data-array="{{json_encode($family_member)}}">
                                                        View
                                                    </button>

                                                </div>
                                                <!-- view modal  -->
                                                <div class="modal fade" id="view" data-backdrop="static"
                                                    data-keyboard="false" tabindex="-1"
                                                    aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-secondary text-white">
                                                                <h5 class="modal-title" id="staticBackdropLabel">Details
                                                                </h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close"><span
                                                                        aria-hidden="true">&times;</span></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="mb-2 col-6">
                                                                        <label for="family_code"
                                                                            class="col-form-label small ">Family
                                                                            Code:</label>
                                                                        <h6 id="family_code" class="font-weight-bold">
                                                                        </h6>

                                                                    </div>
                                                                    <div class="mb-2 col-6">
                                                                        <label for="status"
                                                                            class="col-form-label small ">Status:</label>
                                                                        <span
                                                                            class="badge badge-pill text-white verify">
                                                                        </span>
                                                                        <h6 id="status" class="font-weight-bold">
                                                                        </h6>
                                                                    </div>

                                                                </div>
                                                                <div class="row">
                                                                    <div class="mb-2 col-6">
                                                                        <label for="name"
                                                                            class="col-form-label small ">Name:</label>

                                                                        <h6 id="name" class="font-weight-bold">
                                                                        </h6>
                                                                    </div>
                                                                    <div class="mb-2 col-6">
                                                                        <label for="gender"
                                                                            class="col-form-label small ">Gender:</label>
                                                                        <h6 id="gender" class="font-weight-bold">
                                                                        </h6>
                                                                    </div>

                                                                </div>
                                                                <div class="row">
                                                                    <div class="mb-2 col-6">
                                                                        <label for="address"
                                                                            class="col-form-label small ">Address:</label>

                                                                        <h6 id="address" class="font-weight-bold">
                                                                        </h6>
                                                                    </div>
                                                                    <div class="mb-2 col-6">
                                                                        <label for="birthdate"
                                                                            class="col-form-label small ">Birthdate:</label>
                                                                        <h6 id="birthdate" class="font-weight-bold">
                                                                        </h6>
                                                                    </div>

                                                                </div>
                                                                <div class="row">
                                                                    <div class="mb-2 col-6">
                                                                        <label for="sectoral_classification"
                                                                            class="col-form-label small ">Sectoral
                                                                            Classification:</label>

                                                                        <h6 id="sectoral_classification"
                                                                            class="font-weight-bold">
                                                                        </h6>
                                                                    </div>
                                                                    <div class="mb-2 col-6">
                                                                        <label for="family_head"
                                                                            class="col-form-label small ">Family
                                                                            head:</label>
                                                                        <h6 id="family_head" class="font-weight-bold">
                                                                        </h6>
                                                                    </div>

                                                                </div>

                                                            </div>

                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Close</button>
                                                                <a href="" id="edit">
                                                                    <button type="button"
                                                                        class="btn bg-secondary text-white">Edit</button>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="col-6 ">
                                                    <form
                                                        action="{{ route('residents.destroy', $family_member->fm_id ) }}"
                                                        method="post">
                                                        @csrf
                                                        @method("DELETE")
                                                        <button type="submit" value="Delete" name="submit"
                                                            class=" btn btn-transparent text-danger"
                                                            onclick="return confirm('Are you sure to delete?')">
                                                            DELETE
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

<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
<script>
$(document).ready(function() {
    $('#familyMembersTable').DataTable({

    });
    $('#view').on('shown.coreui.modal', function(e) {
        var button = $(e.relatedTarget);
        var array = button.data('array');
        console.log(array['family_code']);
        var modal = $(this);
        modal.find('#family_code').text(array['family_code']);
        modal.find('#name').text(array['name']);
        modal.find('#address').text(array['street'] + ", " + array['barangay']);
        modal.find('#sectoral_classification').text(array['sectoral_classification']);
        modal.find('#gender').text(array['gender']);
        modal.find('#birthdate').text(array['birthdate']);
        modal.find('#family_head').text(array['is_family_head']);
        if (array['affected_resident_type'] == null) {
            modal.find('#status').text("Non-evacuee");
        } else {
            modal.find('#status').text(array['affected_resident_type']);
        }
        modal.find('#edit').attr('href', 'residents/' + array['fm_id'] + '/edit');


    });

});
</script>
@endsection