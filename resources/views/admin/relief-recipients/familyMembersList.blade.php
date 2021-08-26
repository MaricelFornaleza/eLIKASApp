@extends('layouts.webBase')

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
@endsection

@section('content')

<div class="container-fluid">
    <div class="fade-in">
        <div class="row">
            <div class="col-lg-6 mr-auto mb-2">
                <h1 class="title">
                    Residents
                </h1>
            </div>
            <div class="col-lg-3 ml-auto">

                <a href="{{ url('/export/supplies') }}" class="btn btn-block export-btn">
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
                <div class="alert alert-success">{{ Session::get('message') }}</div>
                @endif
            </div>
        </div>

        <!-- /.row-->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class=" ml-auto ">
                                <a href="{{ route('residents.create') }}">
                                    <button class="btn btn-secondary secondary-button">
                                        Add Resident
                                    </button>
                                </a>

                            </div>
                            <div class=" ml-3">
                                <a href="{{ route('residents.group') }}">
                                    <button class="btn btn-secondary secondary-button">
                                        Group Resident
                                    </button>
                                </a>

                            </div>
                            <div class=" ml-3 mr-4">
                                <a href="{{ url('/import/supplies') }}">
                                    <button class="btn btn-outline-primary ">
                                        Upload Excel File
                                    </button>
                                </a>

                            </div>
                            <!-- <form method="POST" enctype="multipart/form-data"
                                action="{{ url('/import_excel_supplies') }}">
                                @csrf
                                <div class="ml-4 mr-4">
                                    <input type="file" name="select_file">

                                    <input type="submit" name="upload" class="btn btn-outline-primary" value="Upload">
                                    </input>
                                </div>
                            </form> -->

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
                                        <th>FAMILY REPRESENTATIVE</th>
                                        <th>ADDRESS</th>
                                        <th>STATUS</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($family_members as $family_member)

                                    <tr>
                                        <td></td>
                                        <td>{{ $family_member->name }}</td>
                                        <td>{{ $family_member->gender }}</td>
                                        <td>{{ $family_member->birthdate }}</td>
                                        <td>{{ $family_member->sectoral_classification }}</td>
                                        <td>{{ $family_member->is_representative }}</td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <div class="row">
                                                <div class="col-6 ">
                                                    <a href="{{ url('/residents/' . $family_member->id . '/edit') }}"><svg
                                                            class="c-icon ">
                                                            <use
                                                                xlink:href="{{ url('/icons/sprites/free.svg#cil-pencil') }}">
                                                            </use>
                                                        </svg>
                                                    </a>

                                                </div>

                                                <div class="col-6 ">
                                                    <form action="{{ route('residents.destroy', $family_member->id ) }}"
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