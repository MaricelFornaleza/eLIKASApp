@extends('layouts.webBase')

@section('css')
<link rel="stylesheet" href="//cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
@endsection

@section('content')

<div class="container-fluid">
    <div class="fade-in">
        <div class="row">
            <div class="col-lg-6 mr-auto mb-2">
                <h1 class="title">
                    Field Officers
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
            @if(count($errors) > 0)
            <div class="alert alert-danger">
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
                            <div class=" mr-auto ">
                                <a href="{{ url('/field_officers/create') }}">
                                    <button class="btn btn-secondary secondary-button">
                                        Add Field Officer
                                    </button>
                                </a>

                            </div>
                            <form action="post" enctype="multipart/form-data" action="#">
                                @csrf
                                <div class="ml-4 mr-4">

                                    <input type="file" name="select_file">

                                    <input type="submit" name="upload" class="btn btn-outline-primary" value="Upload">
                                    </input>
                                </div>
                            </form>

                        </div>

                    </div>
                    <div class="card-body ">
                        <div style="overflow-x:auto !important;" class="table-responsive">
                            <table id="fieldOfficers"
                                class="table table-borderless table-hover table-light table-striped ">
                                <thead>
                                    <tr>
                                        <th>PHOTO</th>
                                        <th>NAME</th>
                                        <th>OFFICER TYPE</th>
                                        <th>EMAIL ADDRESS</th>
                                        <th>CONTACT NUMBER</th>
                                        <th>ASSIGNED AREA</th>
                                        <th>DESIGNATION</th>
                                        <th>ACTION</th>



                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($field_officers as $field_officer)

                                    <tr>
                                        <td><img class="image rounded-circle"
                                                src="{{asset('/public/images/'.$field_officer -> photo)}}"
                                                alt="profile_image" style="width: 60px;height: 60px;"></td>
                                        <td>{{ $field_officer -> name }}</td>
                                        <td>{{ $field_officer -> type}}</td>
                                        <td>{{ $field_officer -> email }}</td>
                                        <td>@foreach($field_officer->user_contacts as $contact)
                                            {{$contact -> contact_no}}
                                            @endforeach
                                        </td>
                                        <td>{{ $field_officer -> barangay}}</td>
                                        <td>{{ $field_officer -> designation}} </td>
                                        <td>
                                            <div class="row">
                                                <div class="col-6 ">
                                                    <a href="/field_officers/{{$field_officer->id}}/edit"><svg
                                                            class="c-icon ">
                                                            <use
                                                                xlink:href="{{ url('/icons/sprites/free.svg#cil-pencil') }}">
                                                            </use>
                                                        </svg>
                                                    </a>

                                                </div>

                                                <div class="col-6 ">
                                                    <form action="/field_officers/{{$field_officer->id}}" method="post">
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
<script src="//cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function() {
    $('#fieldOfficers').DataTable({
        fixedColumns: true,
    });
});
</script>
@endsection