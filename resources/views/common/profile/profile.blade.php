@extends('layouts.mobileBase')

@section('css')

@endsection

@section('content')

<div class="container-fluid">
    <div class="fade-in">

        <div class="row center">
            <div class="col-lg-8 ">
                <div class="row">
                    <div class="col-12">
                        @if(Session::has('message'))
                        <div class="alert alert-success">{{ Session::get('message') }}</div>
                        @endif
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="ml-2 mr-auto ">
                                <h4>Profile</h4>
                            </div>
                            <div class="ml-4 mr-4">
                                <a href="/profile/{{$user->user_id}}/edit">
                                    <button class="btn btn-primary">
                                        Edit Profile
                                    </button>
                                </a>
                            </div>

                        </div>

                    </div>
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-md-3 center ml-2 mr-2">
                                <img class="image rounded-circle" src="{{asset('/public/images/'.$user-> photo)}}"
                                    alt="profile_image">
                            </div>
                            <div class="col-md-4 info mt-4">
                                <h3 class="title"> {{$user -> name}}</h3>
                                <h6>{{ $user ->officer_type}} - {{ $user ->designation}}
                                    {{ $user ->cm_designation}}
                                    {{ $user ->barangay}}
                                </h6>
                                <h6>{{ $user ->email}}</h6>
                                <h6>{{ $user ->contact_no}}</h6>

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