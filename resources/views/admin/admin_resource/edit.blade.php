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
                                        <input class="form-control @error('name') is-invalid @enderror"
                                            value="{{ $user->name }}" required autocomplete="name" id="name" name="name"
                                            type="text">
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <!-- /.row-->
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="email">Email Address</label>
                                        <input class="form-control @error('email') is-invalid @enderror"
                                            value="{{ $user->email }}" required autocomplete="email" id="email"
                                            name="email" type="email">
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <!-- /.row-->
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="contact_no">Contact Number</label>
                                        <input class="form-control @error('contact_no') is-invalid @enderror" required
                                            id="contact_no" name="contact_no" type="number"
                                            value="0{{$user->contact_no}}" placeholder="e.g. 09xxxxxxxxx">
                                        @error('contact_no')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="branch">Branch</label>
                                        <input class="form-control" value="{{ $admin->branch }}" autocomplete="branch"
                                            id="branch" name="branch" type="text">
                                        @error('branch')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                            </div>


                            <!-- /.row-->
                            <div class="form-group">

                                <div class="row">
                                    <div class="col-sm-6">
                                        <label for="photo">Upload your Profile Picture</label>
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                                <img id="preview-image-before-upload"
                                                    src="/public/images/{{$user->photo}}" alt="preview image"
                                                    style="height: 100px; width: 100px; object-fit: cover;"
                                                    class="rounded-circle mb-2">
                                                <input class=" form-control @error('photo') is-invalid @enderror "
                                                    type="file" name="photo" value="{{ old('photo') }}" id="photo">
                                                @error('photo')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="password">New Password</label>
                                            <input class="form-control" autocomplete="password" id="password"
                                                name="password" type="password">
                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="password">Confirm Password</label>
                                            <input class="form-control" autocomplete="password" id="password-confirm"
                                                name="password_confirmation" type="password">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-5 center">
                                <div class="col-4 ">
                                    <button class="btn btn-primary px-4 " type="submit">{{ __('Update') }}</button>
                                </div>
                                <div class="col-4 ">
                                    <a href="{{url()->previous()}}"
                                        class="btn btn-outline-primary px-4 ">{{ __('Cancel') }}</a>
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
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>

<script type="text/javascript">
$(document).ready(function(e) {
    $('#photo').change(function() {
        let reader = new FileReader();
        reader.onload = (e) => {
            $('#preview-image-before-upload').attr('src', e.target.result);
        }
        reader.readAsDataURL(this.files[0]);
    });
});
</script>
@endsection