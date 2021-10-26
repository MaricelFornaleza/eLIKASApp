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
                                style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>PHOTO</th>
                                        <th>NAME</th>
                                        <th>OFFICER TYPE</th>
                                        <th>EMAIL ADDRESS</th>
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

                                        <td>
                                            <div class="row ">
                                                <div class="mr-4 ">
                                                    <button type="button" class="btn bg-secondary-accent text-white"
                                                        data-toggle="modal" data-target="#view"
                                                        data-id="{{$field_officer->user_id}}"
                                                        data-photo="{{$field_officer->photo}}"
                                                        data-name="{{$field_officer->name}}"
                                                        data-email="{{$field_officer->email}}"
                                                        data-verified="{{$field_officer->email_verified_at}}"
                                                        data-contact="{{$field_officer->contact_no}}"
                                                        data-subscribed="{{$field_officer->globe_labs_access_token}}"
                                                        data-barangay="{{$field_officer->barangay}}"
                                                        data-designation="{{$field_officer->designation}}{{ $field_officer -> camp_designation }}"
                                                        data-token="{{$field_officer->remember_token}}">
                                                        View
                                                    </button>

                                                </div>
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
                                                                    <div class="col-4">
                                                                        <img class="image modal-image" src=""
                                                                            alt="profile_image"
                                                                            style="height: 100%; width: 100%; object-fit: cover;">

                                                                    </div>
                                                                    <div class="col-8 ">

                                                                        <div class="mb-2">
                                                                            <label for="name"
                                                                                class="col-form-label small ">Name:</label>
                                                                            <h6 id="name" class="font-weight-bold"></h6>

                                                                        </div>
                                                                        <div class="mb-2">
                                                                            <label for="email"
                                                                                class="col-form-label small ">Email
                                                                                Address:</label>
                                                                            <span
                                                                                class="badge badge-pill text-white verify">
                                                                            </span>
                                                                            <h6 id="email" class="font-weight-bold">
                                                                            </h6>
                                                                        </div>
                                                                        <div class="mb-2">
                                                                            <label for="contact_no"
                                                                                class="col-form-label small ">Contact
                                                                                Number:</label>

                                                                            <h6 id="contact_no"
                                                                                class="font-weight-bold"></h6>
                                                                        </div>
                                                                        <div class="mb-2 barangay">
                                                                            <label for="barangay"
                                                                                class="col-form-label small ">Barangay:</label>
                                                                            <h6 id="barangay" class="font-weight-bold">
                                                                            </h6>
                                                                        </div>
                                                                        <div class="mb-2 designation">
                                                                            <label for="designation"
                                                                                class="col-form-label small ">Designation:</label>
                                                                            <h6 id="designation"
                                                                                class="font-weight-bold"></h6>
                                                                        </div>
                                                                        <div class="col-10 mx-0 px-0 mt-3">
                                                                            <a href="" id="resend-verification"><button
                                                                                    type="button"
                                                                                    class="btn btn-primary text-white resend">Resend
                                                                                    Email verification</button></a>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Close</button>
                                                                <a href="" id="edit-fo">
                                                                    <button type="button"
                                                                        class="btn bg-secondary text-white">Edit</button>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="">
                                                    <form action="/field_officers/{{$field_officer->user_id}}"
                                                        method="post">
                                                        @csrf
                                                        @method("DELETE")
                                                        <button type="submit" value="Delete" name="submit"
                                                            class="btn btn-transparent text-danger"
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
    $('#view').on('shown.coreui.modal', function(e) {
        var button = $(e.relatedTarget);
        var modal = $(this);
        var photo = button.data('photo'),
            id = button.data('id'),
            name = button.data('name'),
            email = button.data('email'),
            email_verified = button.data('verified'),
            contact = button.data('contact'),
            subscribed = button.data('subscribed'),
            barangay = button.data('barangay'),
            designation = button.data('designation'),
            token = button.data('token');

        modal.find(".modal-image").attr('src', "{{ URL::asset('/public/images/') }}/" + photo);
        modal.find("#email").text(email);
        modal.find("#name").text(name);
        modal.find("#contact_no").text(contact);
        modal.find("#barangay").text(barangay);
        modal.find("#designation").text(designation);
        modal.find('#edit-fo').attr('href', 'field_officers/' + id + '/edit');
        if (email_verified == "") {
            modal.find(".verify").text('Unverified');
            modal.find(".verify").addClass('bg-accent');
            modal.find('#resend-verification').attr('href', '/resend-verification/' + token);
            modal.find("#resend-verification").show();
        } else {
            modal.find(".verify").text('Verified');
            modal.find(".verify").addClass('bg-primary');
            modal.find("#resend-verification").hide();
        }

        if (subscribed == null) {
            modal.find(".subscribe").addClass('bg-danger');
        } else {
            modal.find(".subscribe").addClass('bg-success');
        }
        if (barangay == "") {
            modal.find('.barangay').hide();

            modal.find('.designation').show();

        } else {
            modal.find('.barangay').show();
            modal.find('.designation').hide();

        }
    });

});
</script>
@endsection