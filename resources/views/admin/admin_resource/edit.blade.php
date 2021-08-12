@extends('layouts.webBase')

@section('css')

@endsection

@section('content')

<div class="container-fluid">
    <div class="fade-in">

        <div class="row center">
            <div class="col-lg-8 ">
                <div class="card">
                    <div class="card-header">
                        Edit Profile

                    </div>
                    <div class="card-body ">
                        <form method="POST" action="/profile/{{$user->id}}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input class="form-control " value="{{ $user->name }}" required
                                            autocomplete="name" id="name" name="name" type="text">
                                    </div>
                                </div>
                            </div>
                            <!-- /.row-->
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="email">Email Address</label>
                                        <input class="form-control" value="{{ $user->email }}" required
                                            autocomplete="email" id="email" name="email" type="email">
                                    </div>
                                </div>
                            </div>
                            <!-- /.row-->
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="contact_no">Contact Number</label>
                                        @foreach($user->user_contacts as $contact)
                                        <input class="form-control" value="{{ $contact->contact_no }}" required
                                            autocomplete="contact_no" id="contact_no" name="contact_no" type="number">

                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <!-- /.row-->
                            <div class="row" id='branch'>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="branch">Branch</label>
                                        <input class="form-control" value="{{ $user->branch }}" autocomplete="branch"
                                            id="branch" name="branch" type="text">
                                    </div>
                                </div>
                            </div>

                            <!-- /.row-->
                            <div class="form-group">
                                <label for="photo">Upload your Profile Picture</label>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <svg class="c-icon mr-2 image-icon " height="50px">
                                            <use xlink:href="{{ url('/icons/sprites/free.svg#cil-image1') }}"></use>
                                        </svg>
                                        <input class="form-control" type="file" name="photo">
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <input class="form-control" value="{{ $user->password }}" required
                                                autocomplete="password" id="password" name="password" type="text">
                                        </div>
                                    </div>

                                </div>


                            </div>
                            <div class="row mt-5 center">
                                <div class="col-4 ">
                                    <button class="btn btn-primary px-4 " type="submit">{{ __('Update') }}</button>
                                </div>
                                <div class="col-4 ">
                                    <button class="btn btn-outline-primary px-4 "
                                        type="cancel">{{ __('Cancel') }}</button>
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