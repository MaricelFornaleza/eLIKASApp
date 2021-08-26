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
                                        <td><input class="col-sm-2 align-middle" type="checkbox" name= "{{ $family_member->id  }}" value="<tr><td><input class='col-sm-2 align-middle' type='radio' value='{{ $family_member->id }}' id='selectedRepresentative' name='selectedRepresentative'>{{ $family_member->name }}</td><td>{{ $family_member->sectoral_classification  }}</td></tr> <input type='hidden' value='{{ $family_member->id }}' name='selectedResidents[]'>" >{{ $family_member->name }}</td>
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
                        <form method="POST" action="residents.groupResidents">
                        @csrf
                        <div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="lead">Address</label>
                                        <input class="form-control @error('address') is-invalid @enderror" type="text" placeholder="{{ __('Enter Address') }}" name="address" required autofocus>
                                        @error('address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="px-3 row justify-content-start">
                                <div class="col-sm-6">
                                    <div class="form-group row px-3">
                                    <input class="form-check-input @error('recipient_type') is-invalid @enderror" type="radio" name="recipient_type" id="radio_evacuee" value="Evacuee" required autofocus>
                                    <label class="form-check-label" for="radio_evacuee">
                                           Evacuee
                                    </label>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group row px-3">
                                    <input class="form-check-input @error('recipient_type') is-invalid @enderror" type="radio" name="recipient_type" id="radio_non_evacuee" value="Non-Evacuee" checked>
                                    <label class="form-check-label" for="radio_non_evacuee">
                                        Non-Evacuee
                                    </label>
                                    </div>
                                </div>
                            </div>

                            <table id=""
                                class="table table-borderless table-hover table-light table-striped "
                                style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th class="col-sm-6">NAME</th>
                                        <th class="col-sm-6">SECTORAL CLASSIFICATION</th>
                                    </tr>
                                </thead>
                                <tbody id="selectedResident" name="selectedResident">
                                </tbody>
                            </table>
                      
                            

                            <div class="row mt-5 center">
                                <div class="col-4 ">
                                    <button class="btn btn-primary px-4 " type="submit">{{ __('Submit') }}</button>
                                </div>
                                <div class="col-4 ">
                                    <a href="{{ route('residents.index') }}" class="btn btn-outline-primary px-4 "
                                        >{{ __('Cancel') }}</a>
                                </div>
                            </div>
                        </div>
                        </form>
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
        "scrollX": true,
    });
    $('#familyMembersTable').DataTable({
        "scrollX": true,
    });

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
    let textHtml = "";
    for (let i=0; i < checkedResidents.length; i++) {
        textHtml += checkedResidents[i];
    }
    
    $('#selectedResident').html(textHtml);  
         
        // checkedResidents.forEach(function(value) {
        //     $('#thiswan').append('<tr><td>'value'</td></tr>');    
        // });
        
    });
});

</script>
@endsection