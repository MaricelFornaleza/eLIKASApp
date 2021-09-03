@extends('layouts.webBase')

@section('css')
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

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
                                <div class="col-sm-6">
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
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="contact_no">Contact Number</label>
                                        <input class="form-control @error('contact_no') is-invalid @enderror" required
                                            id="contact_no" name="contact_no" type="number"
                                            placeholder="e.g. 09xxxxxxxxx" value="{{ old('contact_no') }}">
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
                                        <option value="Barangay Captain">Barangay Captain</option>
                                        <option value="Camp Manager">Camp Manager</option>
                                        <option value="Courier">Courier</option>

                                    </select>

                                </div>

                                <div class="col-sm-6 pr-3" id='barangay'>
                                    <input type="hidden" name="city_code" id="city_code"
                                        value="{{$admin_city->city_psgc}}">
                                    <input type="hidden" name="barangay" id="barangay_name" value="">
                                    <div class="form-group ">
                                        <label for="barangay">Barangay</label>
                                        <select name="barangay_dropdown" id="barangay_dropdown"
                                            class=" form-control barangay_option @error('barangay') is-invalid @enderror"
                                            onChange="change()">
                                        </select>

                                        @error('barangay')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6" id='designation' style="display: none;">
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
                                    <div class="col-sm-6 ">
                                        <img id="preview-image-before-upload" src="/public/images/Upload Image.png"
                                            alt="preview image" style="height: 100px; width: 100px; object-fit: cover;"
                                            class="rounded-circle mb-2">
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

                            {{-- <select id="region"><option value=''>Select Region</option></select> <br />
                            <select id="province"><option value=''>Select Province</option></select> <br />
                            <select id="city"><option value=''>Select City</option></select> <br /> 
                            <select id="barangay_1"><option value=''>Select Barangay</option></select> <br />  --}}
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
{{-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> --}}
<script type="text/javascript" src="https://f001.backblazeb2.com/file/buonzz-assets/jquery.ph-locations.js"></script>

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

function change() {
    var myselectedtxt = $('#barangay_dropdown').find("option:selected").text();
    $('#barangay_name').val(myselectedtxt);
}
var city_code = $('#city_code').val();
$(function() {

    $('#barangay_dropdown').ph_locations({
        'location_type': 'barangays'
    });
    $('#barangay_dropdown').ph_locations('fetch_list', [{
        "city_code": city_code
    }]);
});

$(document).ready(function(e) {
    $('#photo').change(function() {
        let reader = new FileReader();
        reader.onload = (e) => {
            $('#preview-image-before-upload').attr('src', e.target.result);
        }
        reader.readAsDataURL(this.files[0]);
    });
<<<<<<< HEAD

    // $("#region").select2()
    // $("#province").select2();
    // $("#city").select2();
    $("#barangay_1").select2();
    // $("#barangay_name").select2();

=======
    $("#barangay_dropdown").select2();
>>>>>>> 5c7a13496cb6a3fcfeed1a6afc82afed67dc989f
});
</script>
@endsection