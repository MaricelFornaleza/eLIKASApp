@extends('layouts.initial-configuration')

@section('css')

@endsection

@section('content')

<div class="container-fluid">
    <div class="fade-in">

        <div class="row center">
            <div class="col-lg-6 ">
                <div class="card">
                    <div class="card-header">
                        <h4 class="title">Welcome to eLIKAS!</h4>

                    </div>
                    <div class="card-body ">
                        <h6 class="mb-4">Set up your account to get started.</h6>

                        <form action="{{ url('/config') }}" method="post">
                            @csrf
                            <div class="input-group mb-3 ">
                                <input type="hidden" name="region" id="region_name" value="">
                                <input type="hidden" name="province" id="province_name" value="">
                                <input type="hidden" name="city" id="city_name" value="">

                                <div class="form-group col-12 m-0 p-0">
                                    <label for="region_psgc">Region</label>
                                    <select name="region_psgc" id="region_psgc"
                                        class=" form-control @error('region') is-invalid @enderror">
                                    </select>
                                    @error('region')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="input-group mb-3 ">
                                <div class="form-group col-12 m-0 p-0">
                                    <label for="province_psgc">Province</label>
                                    <select name="province_psgc" id="province_psgc"
                                        class=" form-control @error('province') is-invalid @enderror">
                                    </select>
                                    @error('province')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="input-group  ">
                                <div class="form-group col-12 m-0 p-0">
                                    <label for="city_psgc">City / Municipality</label>
                                    <select name="city_psgc" id="city_psgc"
                                        class=" form-control @error('city') is-invalid @enderror">
                                    </select>
                                    @error('city')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="input-group">

                                <input type="hidden" name="barangays[]" id="barangay_name" value="">
                                <div class="form-group col-12 m-0 p-0">

                                    <select name="barangay_psgc" id="barangay_psgc" multiple="multiple"
                                        class=" form-control @error('barangay') is-invalid @enderror">
                                    </select>
                                    @error('barangay')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div id="all-barangays"></div>

                            </div>
                    </div>
                    <div class="row my-4 center">
                        <div class="col-4 ">
                            <button class="btn btn-primary px-4 " type="submit"
                                onclick="change()">{{ __('Submit') }}</button>
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
<script src=" https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js">
</script>

<script type="text/javascript" src="https://f001.backblazeb2.com/file/buonzz-assets/jquery.ph-locations.js">
</script>

<script type="text/javascript">
$(document).ready(function(e) {
    $("#region_psgc").select2({
        placeholder: "Select Region"
    });
    $("#province_psgc").select2({
        placeholder: "Select Province"
    });
    $("#city_psgc").select2({
        placeholder: "Select City/Municipality"
    });
    $("#barangay_psgc").select2().next().hide();


});
var my_handlers = {
    fill_provinces: function() {
        var region_psgc = $(this).val();
        $('#province_psgc').ph_locations('fetch_list', [{
            "region_code": region_psgc
        }]);
        var myselectedtxt = $('#region_psgc').find(
            "option:selected").text();
        $('#region_name').val(myselectedtxt);

    },
    fill_cities: function() {
        var province_psgc = $(this).val();
        $('#city_psgc').ph_locations('fetch_list', [{
            "province_code": province_psgc
        }]);
        var myselectedtxt = $('#province_psgc').find(
            "option:selected").text();
        $('#province_name').val(myselectedtxt);
    },
    fill_barangays: function() {
        var city_psgc = $(this).val();
        $('#barangay_psgc').ph_locations('fetch_list', [{
            "city_code": city_psgc
        }]);
        var myselectedtxt = $('#city_psgc').find(
            "option:selected").text();
        $('#city_name').val(myselectedtxt);
    },

};

$(function() {
    $('#region_psgc').on('change', my_handlers.fill_provinces);
    $('#province_psgc').on('change', my_handlers.fill_cities);
    $('#city_psgc').on('change', my_handlers.fill_barangays);

    $('#region_psgc').ph_locations({
        'location_type': 'regions'
    });
    $('#province_psgc').ph_locations({
        'location_type': 'provinces'
    });
    $('#city_psgc').ph_locations({
        'location_type': 'cities'
    });
    $('#barangay_psgc').ph_locations({
        'location_type': 'barangays'
    });
    $('#region_psgc').ph_locations('fetch_list');


});

function change() {
    var option_array = [];
    barangay_name = $('#barangay_psgc').find('option').each(function() {
        option_array.push($(this).text());
    });
    $('#barangay_name').val(option_array);

    console.log(option_array);


}
</script>
@endsection