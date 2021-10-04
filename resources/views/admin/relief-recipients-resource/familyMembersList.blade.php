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
                                        <th>GENDER</th>
                                        <th>BIRTHDATE</th>
                                        <th>SECTORAL CLASSIFICATION</th>
                                        <th>FAMILY HEAD</th>
                                        <th>ADDRESS</th>
                                        <th>STATUS</th>
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
                                        <td>{{ $family_member->gender }}</td>
                                        <td>{{ $family_member->birthdate }}</td>
                                        <td>{{ $family_member->sectoral_classification }}</td>
                                        <td>{{ $family_member->is_family_head }}</td>
                                        <td>{{ $family_member->street }}, {{ $family_member->barangay }}</td>
                                        @if($family_member->affected_resident_type == "")
                                        <td>Non-Evacuee</td>
                                        @else
                                        <td>{{ $family_member->affected_resident_type }}</td>
                                        @endif

                                        <td>
                                            <div class="row">
                                                <div class="col-6 ">
                                                    <a
                                                        href="{{ url('/residents/' . $family_member->fm_id . '/edit') }}"><svg
                                                            class="c-icon ">
                                                            <use
                                                                xlink:href="/assets/icons/coreui/free-symbol-defs.svg#cui-pencil">
                                                            </use>
                                                        </svg>
                                                    </a>

                                                </div>

                                                <div class="col-6 ">
                                                    <form
                                                        action="{{ route('residents.destroy', $family_member->fm_id ) }}"
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
    $('#familyMembersTable').DataTable({
        "scrollX": true,
    });
});
</script>
@endsection