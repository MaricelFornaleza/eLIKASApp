@extends('layouts.webBase')

@section('css')

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
<!-- <link rel="stylesheet" href="//cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css"> -->

@endsection

@section('content')

<div class="container-fluid">
    <div class="fade-in">
        <div class="row justify-content-between d-flex">
            <div class="col-lg-6 ">
                <h1 class="title">
                    Field Officers
                </h1>
            </div>

            <div class="dropdown mr-4">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                    data-toggle="dropdown" aria-expanded="false">
                    Export to
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="{{ url('/export/field_officers') }}">Excel</a>
                    <a class="dropdown-item" href="{{ url('/export/field_officers/pdf') }}" target="_blank">PDF</a>
                </div>
            </div>


        </div>
        <div class="row">
            @if(count($errors) > 0)
            <div class="alert alert-danger col-12">
                <h6>
                    Upload Error
                </h6>
                <!-- <ul>
                    @foreach($errors as $error)
                    <li>{{$error}}</li>
                    @endforeach
                </ul> -->
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
                                        id="dropdownMenuButton1" data-toggle="dropdown" aria-expanded="false">
                                        Action
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <a class="dropdown-item" href="{{ url('/field_officers/create') }}">Add Field
                                            Officer</a>
                                        <a class="dropdown-item" href="{{ url('/import/field_officers') }}">Upload
                                            Excel File</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-body ">
                        <div>
                            <table id="fieldOfficers"
                                class="table table-borderless table-hover table-light table-striped "
                                style="width: 150%;">
                                <thead>
                                    <tr>
                                        <th>PHOTO</th>
                                        <th>NAME</th>
                                        <th>OFFICER TYPE</th>
                                        <th>EMAIL ADDRESS</th>
                                        <th>CONTACT NUMBER</th>
                                        <th>BARANGAY</th>
                                        <th>DESIGNATION</th>
                                        <th>EMAIL VERIFICATION</th>
                                        <th>ACTION</th>



                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($field_officers as $field_officer)
                                    <tr>
                                        <td><img class="image rounded-circle"
                                                src="{{asset('/public/images/'.$field_officer -> photo)}}"
                                                alt="profile_image"
                                                style="height: 40px; width: 40px; object-fit: cover;"></td>
                                        <td>{{ $field_officer -> name }}</td>
                                        <td>{{ $field_officer -> officer_type}}</td>
                                        <td>{{ $field_officer -> email }}
                                            @empty($field_officer->email_verified_at)
                                            <span class="badge badge-pill bg-accent text-white">
                                                Unverified
                                            </span>
                                            @else
                                            <span class="badge badge-pill bg-primary text-white">
                                                Verified
                                            </span>
                                            @endempty
                                        </td>
                                        <td>0{{$field_officer -> contact_no}}
                                            @empty($field_officer->globe_labs_access_token)
                                            <div class="rounded-circle bg-danger" style="height: 10px; width:10px;">
                                            </div>
                                            @else
                                            <div class="rounded-circle bg-success" style="height: 10px; width:10px;">
                                            </div>
                                            @endempty


                                        </td>
                                        <td>@empty($field_officer -> barangay )
                                            NA
                                            @endempty
                                            {{ $field_officer -> barangay}}
                                        </td>
                                        <td>
                                            @if($field_officer -> camp_designation == null && $field_officer ->
                                            designation == null)
                                            NA
                                            @else
                                            {{ $field_officer -> camp_designation }}
                                            {{ $field_officer -> designation }}
                                            @endif
                                        </td>
                                        <td>
                                            @empty($field_officer->email_verified_at)
                                            <a href="/resend-verification/{{$field_officer->remember_token}}"
                                                class="btn bg-secondary-accent text-white ">Resend</a>
                                            @else
                                            N/A
                                            @endempty

                                        </td>
                                        <td>
                                            <div class="row">
                                                <div class="col-6 ">
                                                    <a href="/field_officers/{{$field_officer->user_id}}/edit"><svg
                                                            class="c-icon ">
                                                            <use
                                                                xlink:href="/assets/icons/coreui/free-symbol-defs.svg#cui-pencil">
                                                            </use>
                                                        </svg>
                                                    </a>
                                                </div>

                                                <div class="col-6 ">
                                                    <form action="/field_officers/{{$field_officer->user_id}}"
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
    $('#fieldOfficers').DataTable({
        "scrollX": true,

    });
});
</script>
@endsection