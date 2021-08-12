@extends('layouts.mobileBase')

@section('css')

@endsection

@section('content')

<div class="container-fluid">
    <div class="fade-in">

        <div class="row center">
            <div class="col-lg-8 ">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="ml-2 mr-auto ">
                                <h4>Profile</h4>
                            </div>
                            <div class="ml-4 mr-4">
                                <a href="/profile/{{$user->id}}/edit">
                                    <button class="btn btn-primary">
                                        Edit Profile
                                    </button>
                                </a>
                            </div>

                        </div>

                    </div>
                    <div class="card-body ">
                        <div class="row ">
                            <div class="col-3 center ml-2 mr-2">
                                <img class="image rounded-circle" src="{{asset('/public/images/'.$user-> photo)}}"
                                    alt="profile_image">
                            </div>
                            <div class="col-8 ">
                                <h3 class="title"> {{$user -> name}}</h3>
                                <h6>{{ $user ->type}}</h6>
                                <h6>{{ $user ->email}}</h6>
                                <h6>@if($user->user_contacts->count() > 1)
                                    @foreach($user->user_contacts as $contact)
                                    {{$contact -> contact_no}} /
                                    @endforeach
                                    @else
                                    @foreach($user->user_contacts as $contact)
                                    {{$contact -> contact_no}}
                                    @endforeach
                                    @endif
                                </h6>
                                <h6>{{ $user ->branch}}</h6>



                            </div>

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
<script type="text/javascript">
function update() {
    var select = document.getElementById('officer_type');
    if (select.value == 'barangay_captain') {
        document.getElementById('barangay').style.display = "block";
        document.getElementById('designation').style.display = "none";
    } else {
        document.getElementById('barangay').style.display = "none";
        document.getElementById('designation').style.display = "block";
    }
}
</script>
@endsection