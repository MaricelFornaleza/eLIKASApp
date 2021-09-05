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
                        Start Disaster Response
                    </div>
                    <div class="card-body ">
                        <form method="POST" action="{{ url('/disaster-response/store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="form-group col-sm-12">
                                    <label for="disaster_type">Type of Disaster</label>
                                    <select name="disaster_type"
                                        class="form-control @error('disaster_type') is-invalid @enderror"
                                        id="disaster_type">
                                        <option value="">Select Type</option>
                                        <option value="Drought">Drought</option>
                                        <option value="Earthquake">Earthquake</option>
                                        <option value="Flood">Flood</option>
                                        <option value="Landslide">Landslide</option>
                                        <option value="Tornado">Tornado</option>
                                        <option value="Typhoon">Typhoon</option>
                                        <option value="Volcanic Eruption">Volcanic Eruption</option>
                                        <option value="Wildfire">Wildfire</option>

                                    </select>
                                    @error('disaster_type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror

                                </div>
                            </div>
                            <!-- /.row-->
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <input class="form-control @error('description') is-invalid @enderror"
                                            id="description" name="description" type="description"
                                            placeholder="Type description here..." value="{{ old('description') }}">
                                        @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <!-- /.row-->
                            <div class="row mt-2">
                                <div class="col-md-5">
                                    <h6>Affected Areas</h6>
                                </div>
                                @error('barangay')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror

                            </div>

                            <div class="row mt-2">
                                <div class="col-12">
                                    <!-- <div class="list-group">
                                        <div class="list-group-item list-group-item-action ">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="all" id="all">
                                                <label class="form-check-label" for="all">
                                                    Select All
                                                </label>
                                        </div>
                                    </div> -->
                                    <div class="result">
                                        <input type="hidden" name="city_code" id="city_code"
                                            value="{{$admin_city->city_psgc}}">
                                        <input type="hidden" name="barangay[]" id="barangays" value="">


                                        <select name="barangay_dropdown[]" multiple="multiple" size="10"
                                            id="barangay_dropdown" onchange="change()" required
                                            class=" form-control barangay_option @error('barangay') is-invalid @enderror">

                                        </select>

                                    </div>



                                </div>
                            </div>
                    </div>

                    <div class="row my-5  center">
                        <div class="col-4 ">
                            <button class="btn btn-primary px-4 " type="submit">{{ __('Add') }}</button>
                        </div>
                        <div class="col-4 ">
                            <a href="{{url()->previous()}}" class="btn btn-outline-primary px-4 ">{{ __('Cancel') }}</a>
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

<script type="text/javascript" src="https://f001.backblazeb2.com/file/buonzz-assets/jquery.ph-locations.js"></script>
<script type="text/javascript">
var city_code = $('#city_code').val();

$(function() {
    $('#barangay_dropdown').ph_locations({
        'location_type': 'barangays'
    });
    $('#barangay_dropdown').ph_locations('fetch_list', [{
        "city_code": city_code
    }]);
});

function change() {
    var option_array = [];

    $barangay_name = $('#barangay_dropdown').find(':selected').each(function() {
        option_array.push($(this).text());

    });
    $('#barangays').val(option_array);


    console.log($('#barangays').val());


}
$(document).ready(function() {
    $('#all').change(function() {
        $("input:checkbox").prop('checked', $(this).prop("checked"));
    });

    $('.checkbox').on('click', function() {
        if ($('.checkbox:checked').length == $('.checkbox').length) {
            $('#all').prop('checked', true);
        } else {
            $('#all').prop('checked', false);
        }
    });
    $("#barangay_dropdown").select2({
        closeOnSelect: false,
        placeholder: "Select barangay",
        allowClear: true
    });

    // $('#barangay_dropdown').on('select2:select', function(e) {
    //     var data = $(this).select2('data');
    //     option_array[option_array.length] = data.text;
    // });
    // $('#barangay_dropdown').on("select2:select select2:unselecting", function(e) {
    //     //For selecting the new option
    //     var currentName = $(this).select2('data')[0].text;
    //     console.log(currentName); //you can get old name here also
    // });




});
</script>


@endsection