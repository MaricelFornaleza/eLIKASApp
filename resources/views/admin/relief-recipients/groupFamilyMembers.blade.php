@extends('layouts.webBase')

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
@endsection

@section('content')

<script>
var checkedResidents = new Array();

$('#residentsTable :checkbox').change(function() 
{
    checkedResidents = new Array();
    $('#residentsTable :checkbox').each(function(i, item){
        if($(item).is(':checked'))
        {
            var resident = $(item).val();
            
            checkedResidents.push(resident); 
        }
    });
    
   console.log("checkedResidents:", checkedResidents);
});
</script>

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
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <div class="col-sm-6 mr-auto">
                            <h4 class="title">
                                List of Residents
                            </h4>
                        </div>
                    </div>
                    <div class="card-body ">
                        <div>
                            <table id="residentsTable"
                                class="table table-borderless table-hover table-light table-striped "
                                style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>NAME</th>
                                        <th>SECTORAL CLASSIFICATION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($family_members as $family_member)

                                    <tr>
                                        <td><input class="col-sm-2 align-middle" type="checkbox" name= "name" value="{ id : {{ $family_member->id  }}, name : '{{ $family_member->name  }}' }" >{{ $family_member->name }}</td>
                                        <td>{{ $family_member->sectoral_classification }}</td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <div class="col-lg-12 mr-auto">
                            <h4 class="title">
                                Choose Family Representative
                            </h4>
                        </div>
                    </div>
                    <div class="card-body ">
                        <div>
                            <table id="familyMembersTable"
                                class="table table-borderless table-hover table-light table-striped "
                                style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>NAME</th>
                                        <th>SECTORAL CLASSIFICATION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($family_members as $family_member)
                                      
                                        <tr>
                                            <td>{{ $family_member->name }}</td>
                                            <td>{{ $family_member->sectoral_classification }}</td>
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
    $('#residentsTable').DataTable({
        "scrollX": true,
    });
    $('#familyMembersTable').DataTable({
        "scrollX": true,
    });
});

</script>
@endsection