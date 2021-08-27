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
                        Edit Field Officer

                    </div>
                    <div class="card-body ">
                        <form method="POST" action="/field_officers/{{$user->id}}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input class="form-control @error('name') is-invalid @enderror "
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
                                <div class="col-sm-6">
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
                            </div>

                            <!-- /.row-->
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label for="officer_type">Officer Type</label>
                                    <select name="officer_type" class="form-control" id="officer_type"
                                        onChange="update()">
                                        <option value="{{$user->officer_type}}">{{$user->officer_type}}</option>
                                    </select>

                                </div>
                                @if($user->officer_type == "Barangay Captain")
                                <div class="col-sm-6" id='barangay'>
                                    <div class=" form-group">
                                        <label for="barangay">Barangay</label>
                                        <select name="barangay" id="barangay"
                                            class=" form-control @error('barangay') is-invalid @enderror">
                                            <option value='{{ $barangay_captain->barangay }}' selected>
                                                {{ $barangay_captain->barangay }}
                                            </option>
                                            @foreach($barangays as $barangay)
                                            <option value='{{ $barangay->name }}'>
                                                {{ $barangay->name }}
                                            </option>
                                            @endforeach
                                        </select>

                                        @error('barangay')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                @elseif($user->officer_type == "Camp Manager")

                                <div class="col-sm-6" id='designation'>
                                    <div class="form-group">
                                        <label for="designation">Designation</label>
                                        <input class="form-control @error('designation') is-invalid @enderror"
                                            id="designation" name="designation" type="text"
                                            placeholder="Enter your Designation"
                                            value="{{ $camp_designation->designation }}">
                                        @error('designation')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                @elseif($user->officer_type == "Courier")
                                <div class="col-sm-6" id='designation'>
                                    <div class="form-group">
                                        <label for="designation">Designation</label>
                                        <input class="form-control @error('designation') is-invalid @enderror"
                                            id="designation" name="designation" type="text"
                                            placeholder="Enter your Designation"
                                            value="{{ $courier_designation->designation }}">
                                        @error('designation')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                @endif

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
                                            <input class="form-control  @error('password') is-invalid @enderror"
                                                autocomplete="password" id="password" name="password" type="password">
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
function update() {
    var select = document.getElementById('officer_type');
    if (select.value == 'Barangay Captain') {
        document.getElementById('barangay').style.display = "block";
        document.getElementById('designation').style.display = "none";

    } else {
        document.getElementById('barangay').style.display = "none";
        document.getElementById('designation').style.display = "block";
    }
}

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