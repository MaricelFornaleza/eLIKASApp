@extends('layouts.webBase')

@section('css')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
    integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
    crossorigin="" />
<link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />
<!-- Make sure you put this AFTER Leaflet's CSS -->
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
    integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
    crossorigin=""></script>
<script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>

<link href="{{ asset('css/map.css') }}" rel="stylesheet">
<style>
#mapid {
    height: 75vh;
}
</style>
@endsection

@section('content')

<div class="container-fluid">
    <div class="fade-in">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header ">
                        <h4 class="my-auto">{{ __('Location of Evacuation Centers') }}</h4>
                    </div>
                    <div class="card-body">

                        <div class="w-100" id="mapid"></div>

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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
{{-- <script src="{{ asset('js/map-js/evacuation-centers/markers-evacuationCenters.js') }}"></script>
<script src="{{ asset('js/map-js/couriers/markers-Couriers.js') }}"></script> --}}

{{-- <!-- <script src="{{ asset('js/map-js/leaflet-maps.js') }}"></script> --> --}}

{{-- <!-- <script src="{{ asset('js/map-js/customOptions.js') }}"></script> -->
<!-- <script src="{{ asset('js/map-js/couriers/custom-popup.js') }}"></script>
<script src="{{ asset('js/map-js/evacuation-centers/custom-popup.js') }}"></script> --> --}}

<script src="{{ asset('js/map-js/maps-functions.js') }}"></script>
<script src="{{ asset('js/map-js/leaflet-maps-simplified.js') }}"></script>

<script type="text/javascript">
// var evacOptions = evacOptions();
var evaclocations = '{{ $evacuation_centers }}';
var courierlocations = '{{ $couriers }}';
var result1 = JSON.parse(evaclocations.replace(/&quot;/g, '"'));
var result2 = JSON.parse(courierlocations.replace(/&quot;/g, '"'));
//console.log(result2);
var evac_markers = L.layerGroup();
var courier_markers = L.layerGroup();

$.each(result1, function(key, value) {
    //console.log(value.latitude);
    var marker = new L.marker([value.latitude, value.longitude], {icon: evacIcon()})
        .bindPopup('<div class="font-weight-bold">' + value.name + '</div>' +
                '<div class="my-2">' +
                '<div class="progress-group">' +
                '<div class="progress-group-header align-items-end">' +
                '<div>Food</div>' +
                '<div class="ml-auto font-weight-bold mr-2">' + value.food_packs +
                '</div>' +
                '<div class="text-muted small">(' + (value.food_packs / 100 * 100) +
                '%)</div>' +
                '</div>' +
                '<div class="progress-group-bars">' +
                '<div class="progress progress-xs">' +
                '<div class="progress-bar bg-warning" role="progressbar" style="width: ' +
                (value.food_packs / 100 * 100) +
                '%" aria-valuenow="56" aria-valuemin="0" aria-valuemax="100"></div>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '<div class="progress-group">' +
                '<div class="progress-group-header align-items-end">' +
                '<div>Water</div>' +
                '<div class="ml-auto font-weight-bold mr-2">' + value.water +
                '</div>' +
                '<div class="text-muted small">(' + (value.water / 100 * 100) +
                '%)</div>' +
                '</div>' +
                '<div class="progress-group-bars">' +
                '<div class="progress progress-xs">' +
                '<div class="progress-bar bg-warning" role="progressbar" style="width: ' +
                (value.water / 100 * 100) +
                '%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '<div class="progress-group">' +
                '<div class="progress-group-header align-items-end">' +
                '<div>Clothes</div>' +
                '<div class="ml-auto font-weight-bold mr-2">' + value.clothes +
                '</div>' +
                '<div class="text-muted small">(' + (value.clothes / 100 * 100) +
                '%)</div>' +
                '</div>' +
                '<div class="progress-group-bars">' +
                '<div class="progress progress-xs">' +
                '<div class="progress-bar bg-warning" role="progressbar" style="width: ' +
                (value.clothes / 100 * 100) +
                '%" aria-valuenow="11" aria-valuemin="0" aria-valuemax="100"></div>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '<div class="progress-group">' +
                '<div class="progress-group-header align-items-end">' +
                '<div>Hygiene Kit</div>' +
                '<div class="ml-auto font-weight-bold mr-2">' + value.hygiene_kit +
                '</div>' +
                '<div class="text-muted small">(' + (value.hygiene_kit / 100 * 100) +
                '%)</div>' +
                '</div>' +
                '<div class="progress-group-bars">' +
                '<div class="progress progress-xs">' +
                '<div class="progress-bar bg-warning" role="progressbar" style="width: ' +
                (value.hygiene_kit / 100 * 100) +
                '%" aria-valuenow="8" aria-valuemin="0" aria-valuemax="100"></div>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '<div class="progress-group">' +
                '<div class="progress-group-header align-items-end">' +
                '<div>Medicine</div>' +
                '<div class="ml-auto font-weight-bold mr-2">' + value.medicine +
                '</div>' +
                '<div class="text-muted small">(' + (value.medicine / 100 * 100) +
                '%)</div>' +
                '</div>' +
                '<div class="progress-group-bars">' +
                '<div class="progress progress-xs">' +
                '<div class="progress-bar bg-warning" role="progressbar" style="width: ' +
                (value.medicine / 100 * 100) +
                '%" aria-valuenow="8" aria-valuemin="0" aria-valuemax="100"></div>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '<div class="progress-group">' +
                '<div class="progress-group-header align-items-end">' +
                '<div>ESA</div>' +
                '<div class="ml-auto font-weight-bold mr-2">' + value 
                .emergency_shelter_assistance + '</div>' +
                '<div class="text-muted small">(' + (value 
                    .emergency_shelter_assistance / 100 * 100) + '%)</div>' +
                '</div>' +
                '<div class="progress-group-bars">' +
                '<div class="progress progress-xs">' +
                '<div class="progress-bar bg-warning" role="progressbar" style="width: ' +
                (value.emergency_shelter_assistance / 100 * 100) +
                '%" aria-valuenow="8" aria-valuemin="0" aria-valuemax="100"></div>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</div>', evacOptions())
        .addTo(evac_markers);

    evac_markers.addTo(mymap);
});

$.each(result2, function(key, value) {
    var marker = L.marker([value.latitude, value.longitude], {icon: truckIcon()})
        .bindPopup('<div class="font-weight-bold">' + value.name + '</div>', truckOptions())
        .addTo(courier_markers);
    courier_markers.addTo(mymap);
});

$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    //remove on production
    Pusher.logToConsole = true;

    var pusher = new Pusher('ab82b7896a919c5e39dd', {
        cluster: 'ap1'
    });

    var channel = pusher.subscribe('location-channel');
    channel.bind('evac-event', function(data) {
        var result = data;
        evac_markers.clearLayers();
        $.each(result, function(key, value) {
            for (var i = 0; i < value.length; ++i) {
                //console.log(i);
                var marker = new L.marker([value[i].latitude, value[i].longitude], { icon: evacIcon()} )
                    .bindPopup('<div class="font-weight-bold">' + value[i].name + '</div>' +
                                '<div class="my-2">' +
                                '<div class="progress-group">' +
                                '<div class="progress-group-header align-items-end">' +
                                '<div>Food</div>' +
                                '<div class="ml-auto font-weight-bold mr-2">' + value[i].food_packs +
                                '</div>' +
                                '<div class="text-muted small">(' + (value[i].food_packs / 100 * 100) +
                                '%)</div>' +
                                '</div>' +
                                '<div class="progress-group-bars">' +
                                '<div class="progress progress-xs">' +
                                '<div class="progress-bar bg-warning" role="progressbar" style="width: ' +
                                (value[i].food_packs / 100 * 100) +
                                '%" aria-valuenow="56" aria-valuemin="0" aria-valuemax="100"></div>' +
                                '</div>' +
                                '</div>' +
                                '</div>' +
                                '<div class="progress-group">' +
                                '<div class="progress-group-header align-items-end">' +
                                '<div>Water</div>' +
                                '<div class="ml-auto font-weight-bold mr-2">' + value[i].water +
                                '</div>' +
                                '<div class="text-muted small">(' + (value[i].water / 100 * 100) +
                                '%)</div>' +
                                '</div>' +
                                '<div class="progress-group-bars">' +
                                '<div class="progress progress-xs">' +
                                '<div class="progress-bar bg-warning" role="progressbar" style="width: ' +
                                (value[i].water / 100 * 100) +
                                '%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>' +
                                '</div>' +
                                '</div>' +
                                '</div>' +
                                '<div class="progress-group">' +
                                '<div class="progress-group-header align-items-end">' +
                                '<div>Clothes</div>' +
                                '<div class="ml-auto font-weight-bold mr-2">' + value[i].clothes +
                                '</div>' +
                                '<div class="text-muted small">(' + (value[i].clothes / 100 * 100) +
                                '%)</div>' +
                                '</div>' +
                                '<div class="progress-group-bars">' +
                                '<div class="progress progress-xs">' +
                                '<div class="progress-bar bg-warning" role="progressbar" style="width: ' +
                                (value[i].clothes / 100 * 100) +
                                '%" aria-valuenow="11" aria-valuemin="0" aria-valuemax="100"></div>' +
                                '</div>' +
                                '</div>' +
                                '</div>' +
                                '<div class="progress-group">' +
                                '<div class="progress-group-header align-items-end">' +
                                '<div>Hygiene Kit</div>' +
                                '<div class="ml-auto font-weight-bold mr-2">' + value[i].hygiene_kit +
                                '</div>' +
                                '<div class="text-muted small">(' + (value[i].hygiene_kit / 100 * 100) +
                                '%)</div>' +
                                '</div>' +
                                '<div class="progress-group-bars">' +
                                '<div class="progress progress-xs">' +
                                '<div class="progress-bar bg-warning" role="progressbar" style="width: ' +
                                (value[i].hygiene_kit / 100 * 100) +
                                '%" aria-valuenow="8" aria-valuemin="0" aria-valuemax="100"></div>' +
                                '</div>' +
                                '</div>' +
                                '</div>' +
                                '<div class="progress-group">' +
                                '<div class="progress-group-header align-items-end">' +
                                '<div>Medicine</div>' +
                                '<div class="ml-auto font-weight-bold mr-2">' + value[i].medicine +
                                '</div>' +
                                '<div class="text-muted small">(' + (value[i].medicine / 100 * 100) +
                                '%)</div>' +
                                '</div>' +
                                '<div class="progress-group-bars">' +
                                '<div class="progress progress-xs">' +
                                '<div class="progress-bar bg-warning" role="progressbar" style="width: ' +
                                (value[i].medicine / 100 * 100) +
                                '%" aria-valuenow="8" aria-valuemin="0" aria-valuemax="100"></div>' +
                                '</div>' +
                                '</div>' +
                                '</div>' +
                                '<div class="progress-group">' +
                                '<div class="progress-group-header align-items-end">' +
                                '<div>ESA</div>' +
                                '<div class="ml-auto font-weight-bold mr-2">' + value[i] 
                                .emergency_shelter_assistance + '</div>' +
                                '<div class="text-muted small">(' + (value[i] 
                                    .emergency_shelter_assistance / 100 * 100) + '%)</div>' +
                                '</div>' +
                                '<div class="progress-group-bars">' +
                                '<div class="progress progress-xs">' +
                                '<div class="progress-bar bg-warning" role="progressbar" style="width: ' +
                                (value[i].emergency_shelter_assistance / 100 * 100) +
                                '%" aria-valuenow="8" aria-valuemin="0" aria-valuemax="100"></div>' +
                                '</div>' +
                                '</div>' +
                                '</div>' +
                                '</div>', evacuationOptions())
                    .addTo(evac_markers);
                evac_markers.addTo(mymap);
            }
        });
    });

    channel.bind('courier-event', function(data) {
        var result = data;
        courier_markers.clearLayers();
        $.each(result, function(key, value) {
            for (var i = 0; i < value.length; ++i) {
                //console.log(i);
                var marker = new L.marker([value[i].latitude, value[i].longitude], {icon: truckIcon()})
                    .bindPopup('<div class="font-weight-bold">' + value[i].name + '</div>', truckOptions())
                    .addTo(courier_markers);
                courier_markers.addTo(mymap);
            }
        })
    });

    //AJAX IMPLEMENTATION
    /*
    $.ajax({
        method: "GET",
        url: "/map/get_evac",
    }).done(function(data) {
        //console.log(data);
        var result = data;
        var length = 0;
        $.each(result, function(key, value) {
            
            //console.log("id: ", value[1].id, "camp_manager_id: ", value[1].camp_manager_id, "name: ", value[1].name, "address: ", value[1].address,
            //"latitude: ", value[1].latitude, "longitude: ", value[1].longitude, "capacity: ", value[1].capacity, "characteristics: ", value[1].characteristics);
            // console.log("name: ", value[length].name, "camp_manager_id: ", value[length].camp_manager_id);

            //---------change total of 100 to the true total of each stock levels ---to be updated/changed in the future 
            //either store in a variable to add all or query from DB the total of all then pass
            for (var i = 0; i < value.length; ++i) {
                //console.log(i);
                L.marker([value[i].latitude, value[i].longitude], {
                        icon: evacIcon()
                    })
                    .bindPopup('<div class="font-weight-bold">' + value[i].name + '</div>' +
                        '<div class="my-2">' +
                        '<div class="progress-group">' +
                        '<div class="progress-group-header align-items-end">' +
                        '<div>Food</div>' +
                        '<div class="ml-auto font-weight-bold mr-2">' + value[i].food_packs +
                        '</div>' +
                        '<div class="text-muted small">(' + (value[i].food_packs / 100 * 100) +
                        '%)</div>' +
                        '</div>' +
                        '<div class="progress-group-bars">' +
                        '<div class="progress progress-xs">' +
                        '<div class="progress-bar bg-warning" role="progressbar" style="width: ' +
                        (value[i].food_packs / 100 * 100) +
                        '%" aria-valuenow="56" aria-valuemin="0" aria-valuemax="100"></div>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '<div class="progress-group">' +
                        '<div class="progress-group-header align-items-end">' +
                        '<div>Water</div>' +
                        '<div class="ml-auto font-weight-bold mr-2">' + value[i].water +
                        '</div>' +
                        '<div class="text-muted small">(' + (value[i].water / 100 * 100) +
                        '%)</div>' +
                        '</div>' +
                        '<div class="progress-group-bars">' +
                        '<div class="progress progress-xs">' +
                        '<div class="progress-bar bg-warning" role="progressbar" style="width: ' +
                        (value[i].water / 100 * 100) +
                        '%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '<div class="progress-group">' +
                        '<div class="progress-group-header align-items-end">' +
                        '<div>Clothes</div>' +
                        '<div class="ml-auto font-weight-bold mr-2">' + value[i].clothes +
                        '</div>' +
                        '<div class="text-muted small">(' + (value[i].clothes / 100 * 100) +
                        '%)</div>' +
                        '</div>' +
                        '<div class="progress-group-bars">' +
                        '<div class="progress progress-xs">' +
                        '<div class="progress-bar bg-warning" role="progressbar" style="width: ' +
                        (value[i].clothes / 100 * 100) +
                        '%" aria-valuenow="11" aria-valuemin="0" aria-valuemax="100"></div>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '<div class="progress-group">' +
                        '<div class="progress-group-header align-items-end">' +
                        '<div>Hygiene Kit</div>' +
                        '<div class="ml-auto font-weight-bold mr-2">' + value[i].hygiene_kit +
                        '</div>' +
                        '<div class="text-muted small">(' + (value[i].hygiene_kit / 100 * 100) +
                        '%)</div>' +
                        '</div>' +
                        '<div class="progress-group-bars">' +
                        '<div class="progress progress-xs">' +
                        '<div class="progress-bar bg-warning" role="progressbar" style="width: ' +
                        (value[i].hygiene_kit / 100 * 100) +
                        '%" aria-valuenow="8" aria-valuemin="0" aria-valuemax="100"></div>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '<div class="progress-group">' +
                        '<div class="progress-group-header align-items-end">' +
                        '<div>Medicine</div>' +
                        '<div class="ml-auto font-weight-bold mr-2">' + value[i].medicine +
                        '</div>' +
                        '<div class="text-muted small">(' + (value[i].medicine / 100 * 100) +
                        '%)</div>' +
                        '</div>' +
                        '<div class="progress-group-bars">' +
                        '<div class="progress progress-xs">' +
                        '<div class="progress-bar bg-warning" role="progressbar" style="width: ' +
                        (value[i].medicine / 100 * 100) +
                        '%" aria-valuenow="8" aria-valuemin="0" aria-valuemax="100"></div>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '<div class="progress-group">' +
                        '<div class="progress-group-header align-items-end">' +
                        '<div>ESA</div>' +
                        '<div class="ml-auto font-weight-bold mr-2">' + value[i]
                        .emergency_shelter_assistance + '</div>' +
                        '<div class="text-muted small">(' + (value[i]
                            .emergency_shelter_assistance / 100 * 100) + '%)</div>' +
                        '</div>' +
                        '<div class="progress-group-bars">' +
                        '<div class="progress progress-xs">' +
                        '<div class="progress-bar bg-warning" role="progressbar" style="width: ' +
                        (value[i].emergency_shelter_assistance / 100 * 100) +
                        '%" aria-valuenow="8" aria-valuemin="0" aria-valuemax="100"></div>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>', evacOptions)
                    .addTo(mymap);
            }
        });
    });

    $.ajax({
        method: "GET",
        url: "/map/get_couriers",
    }).done(function(data) {
        //console.log(data);
        var result = data;
        var length = 0;
        $.each(result, function(key, value) {
            for (var i = 0; i < value.length; ++i) {
                //console.log(i);
                L.marker([value[i].latitude, value[i].longitude], {
                        icon: truckIcon()
                    })
                    .bindPopup(truckOptions)
                    .addTo(mymap);
            }
        });
    });
    */
});
</script>
@endsection