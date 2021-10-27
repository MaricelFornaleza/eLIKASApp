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
                    Group Family Members
                </h1>
            </div>

        </div>
    </div>
    <div class="row">
        @if(count($errors) > 0)
        <div class="alert alert-danger col-12">
            <h6>
                Input Error
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
            @elseif(Session::has('error'))
            <div class="alert alert-danger">{{ Session::get('error') }}</div>
            @endif
        </div>
    </div>

    <!-- /.row-->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="col-sm-6 mr-auto">
                        <h4 class="title">
                            List of Residents
                        </h4>
                    </div>
                </div>
                <div class="card-body ">
                    <form method="POST" action="residents.groupResidents">
                        @csrf
                        <div>
                            <table id="residentsTable"
                                class="table table-borderless table-hover table-light table-striped "
                                style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>NAME</th>
                                        <th>SECTORAL CLASSIFICATION</th>
                                        <th>FAMILY HEAD</th>
                                        <th>ADDRESS</th>
                                    </tr>
                                </thead>
                                <tbody id="tableBody" name="tableBody">
                                    @foreach($family_members as $family_member)
                                    <!-- //     value="<tr><td><input class='col-sm-2 align-middle' type='radio' value='{{ $family_member->id }}' id='selectedRepresentative' name='selectedRepresentative'>{{ $family_member->name }}</td><td>{{ $family_member->sectoral_classification  }}</td></tr> <input type='hidden' value='{{ $family_member->id }}' name='selectedResidents[]'>"  -->
                                    <tr>
                                        <td><input class="col-sm-2 align-middle" type="checkbox"
                                                name="selectedResidents[]"
                                                value='{{$family_member->id}}'>{{ $family_member->name }}</td>
                                        <td>{{ $family_member->sectoral_classification }}</td>
                                        <td>{{ $family_member->is_family_head }}</td>
                                        <td>{{ $family_member->street }}, {{ $family_member->barangay }}</td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                            <div class="row mt-5 center">
                                <div class="col-4 ">
                                    <button class="btn btn-primary px-4 " type="submit">{{ __('Submit') }}</button>
                                </div>
                                <div class="col-4 ">
                                    <a href="{{ route('residents.index') }}"
                                        class="btn btn-outline-primary px-4 ">{{ __('Cancel') }}</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /.row-->


</div>
</div>



@endsection

@section('javascript')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
<script>
$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#residentsTable').DataTable({

    });
    $('#familyMembersTable').DataTable({

    });

});
</script>
@endsection