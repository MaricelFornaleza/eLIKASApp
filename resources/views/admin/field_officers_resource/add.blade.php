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
                        Add Field Officer

                    </div>
                    <div class="card-body ">
                        <form method="POST" action="{{ url('/field_officers') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input class="form-control @error('name') is-invalid @enderror" required
                                            id="name" name="name" type="text" placeholder="Enter your name"
                                            value="{{ old('name') }}">
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
                                        <input class="form-control @error('email') is-invalid @enderror" required
                                            id="email" name="email" type="email" placeholder="yourname@gmail.com"
                                            value="{{ old('email') }}">
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
                                        <label for="contact_no[1]">Contact Number</label>
                                        <input class="form-control @error('contact_no[1]') is-invalid @enderror"
                                            required id="contact_no[1]" name="contact_no[1]" type="number"
                                            placeholder="e.g. 09xxxxxxxxx" value="{{ old('contact_no[1]') }}">
                                        @error('contact_no[1]')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="contact_no[2]">Contact Number (Optional)</label>
                                        <input class="form-control @error('contact_no[2]') is-invalid @enderror"
                                            required id="contact_no[2]" name="contact_no[2]" type="number"
                                            placeholder="e.g. 09xxxxxxxxx" value="{{ old('contact_no[2]') }}">
                                        @error('contact_no[2]')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <!-- /.row-->
                            <div class="row" id='barangay'>
                                <div class="form-group col-sm-6">
                                    <label for="officer_type">Officer Type</label>
                                    <select name="officer_type" class="form-control" id="officer_type"
                                        onChange="update()">
                                        <option value="barangay_captain">Barangay Captain</option>
                                        <option value="camp_manager">Camp Manager</option>
                                        <option value="courier">Courier</option>

                                    </select>

                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="barangay">Barangay</label>
                                        <input class="form-control @error('barangay') is-invalid @enderror"
                                            id="barangay" name="barangay" type="text" placeholder="Enter your Barangay"
                                            value="{{ old('barangay') }}">
                                        @error('barangay')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <!-- /.row-->
                            <div class="row" id='designation' style="display: none;">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="designation">Designation</label>
                                        <input class="form-control @error('designation') is-invalid @enderror"
                                            id="designation" name="designation" type="text"
                                            placeholder="Enter your Designation" value="{{ old('designation') }}">
                                        @error('designation')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <!-- /.row-->
                            <div class="form-group">
                                <label for="photo">Upload your Profile Picture</label>
                                <div class="row">
                                    <div class="col-sm-6 rounded-circle">
                                        <img id="preview-image-before-upload" src="" alt="preview image"
                                            style="max-height: 200px; ">
                                        <input class=" form-control @error('photo') is-invalid @enderror " type="file"
                                            name="photo" value="{{ old('photo') }}" id="photo">
                                        @error('photo')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>


                                </div>


                            </div>
                            <div class="row mt-5 center">
                                <div class="col-4 ">
                                    <button class="btn btn-primary px-4 " type="submit">{{ __('Add') }}</button>
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