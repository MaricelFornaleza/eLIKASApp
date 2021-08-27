@extends('layouts.webBase')

@section('css')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
    integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
    crossorigin="" />
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
    integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
    crossorigin=""></script>

<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

<style>
#mapid {
    height: 75vh;
}
</style>

@endsection('css')

@section('content')

<div class="container-fluid">
    <div class="animated fadeIn">
        <div class="row justify-content-center">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="card">
                    <div class="card-header ">
                        {{ __('Add an Evacuation Center') }}
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('evacuation-center.store') }}">
                            @csrf

                            <div class="form-group row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group row px-3">
                                        <label for="name">Name of the Evacuation Center <code>*</code></label>
                                        <input class="form-control @error('name') is-invalid @enderror" type="text"
                                            placeholder="{{ __('Enter evacuation center name') }}" name="name" required
                                            value="{{ old('name') }}" autofocus>
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-group row px-3">
                                        <label>Address <code>*</code></label>
                                        <input class="form-control @error('address') is-invalid @enderror"
                                            value="{{ old('address') }}" type="text"
                                            placeholder="{{ __('Enter evacuation center address') }}" name="address"
                                            required>
                                        @error('address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12 col-md-12 col-lg-8 col-xl-6">
                                            <div class="form-group row px-3">
                                                <label for="camp_manager_id">Camp Manager</label>
                                                <!-- <input class="form-control" type="text" placeholder="{{ __('Enter name') }}" name="camp_manager" required autofocus> -->
                                                <select name="camp_manager_id" id='camp_manager_id'
                                                    class="h-100 form-control">
                                                    <option value=''>Select User</option>
                                                    @foreach($camp_managers as $camp_manager)
                                                    <option value='{{ $camp_manager->id }}'>
                                                        {{ $camp_manager->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                <!-- <input type='button' value='Seleted option' id='but_read'>
                                                <br/>
                                                <div id='result'></div> -->
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-6 col-lg-8 col-xl-6">
                                            <div class="form-group row px-3">
                                                <label>Capacity
                                                    <code>*</code></label>
                                                <input class="form-control @error('capacity') is-invalid @enderror"
                                                    value="{{ old('capacity') }}" type="number"
                                                    placeholder="{{ __('Enter Capacity') }}" value=0 name="capacity"
                                                    required>
                                                @error('capacity')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row px-3">
                                        <label for="characteristics">Other Characteristics</label>
                                        <textarea class="form-control @error('characteristics') is-invalid @enderror"
                                            value="{{ old('characteristics') }}" id="characteristics"
                                            name="characteristics" rows="6"
                                            placeholder="Enter evacuation center characteristics" autofocus></textarea>
                                        @error('characteristics')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-6">
                                            <label for="latitude">Latitude</label>
                                            <input name="latitude" id="latitude"
                                                class="form-control @error('latitude') is-invalid @enderror"
                                                value="{{ old('latitude') }}" pattern="[+-]?([0-9]*[.])?[0-9]+"
                                                required />
                                            @error('latitude')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="col-6">
                                            <label for="longitude">Longitude</label>
                                            <input name="longitude" id="longitude"
                                                class="form-control @error('longitude') is-invalid @enderror"
                                                value="{{ old('longitude') }}" pattern="[+-]?([0-9]*[.])?[0-9]+"
                                                required />
                                            @error('longitude')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-2">Please place the pin on the exact location</div>
                                    <div class="w-100 " id="mapid"></div>
                                </div>
                            </div>

                            <button class="btn  btn-warning" type="submit">{{ __('Submit') }}</button>
                            <a href="{{ route('evacuation-center.index') }}"
                                class="btn btn-outline-secondary">{{ __('Cancel') }}</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('javascript')
<script src="{{ asset('js/map-js/maps-functions.js') }}"></script>
<script src="{{ asset('js/map-js/leaflet-maps-simplified.js') }}"></script>
{{-- <script src="{{ asset('js/map-js/evacuation-centers/add-marker-on-click.js') }}"></script> --}}

<script>
var clickMarker = new L.marker();
addMarker(mymap, clickMarker);
document.getElementById('latitude').oninput = function() {
    get_lat()
};
document.getElementById('longitude').oninput = function() {
    get_lng()
};

$(document).ready(function() {
    // Initialize select2
    $("#camp_manager_id").select2();
    // Read selected option
    // $('#read_coordinates').click(function(){
    //     //var username = $('#camp_manager_id option:selected').text();
    //     //var userid = $('#camp_manager_id').val();
    //     //$('#result').html("id : " + userid + ", name : " + username);
    //     var lat = $('#latitude').val();
    //     var lng = $('#longitude').val();
    //     clickMarker.setLatLng(lat,lng).setIcon(evacIcon()).addTo(mymap);
    // });
});
</script>
@endsection