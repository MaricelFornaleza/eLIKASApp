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

<link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

<link href="{{ asset('css/map.css') }}" rel="stylesheet">
<style>
#mapid {
    height: 75vh;
}

.supply-icon {
    height: 40px;

}

.h-line {
    width: 50px;
    height: 3px;
    background-color: #DAE1EC;
}

.leaflet-popup-content {
    width: 300px !important;
    max-width: 450px !important;
}

.data {
    color: var(--primary);
}

.supply-card {
    padding-left: 10px !important;
    padding-right: 10px !important;
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
<script src="{{ asset('js/app.js') }}"></script>

<script type="text/javascript">
var evaclocations = '{{ $evacuation_centers }}';
var courierlocations = '{{ $couriers }}';
var result1 = JSON.parse(evaclocations.replace(/&quot;/g, '"'));
var result2 = JSON.parse(courierlocations.replace(/&quot;/g, '"'));
var evac_markers = L.layerGroup();
var courier_markers = L.layerGroup();
layerControl.addOverlay(evac_markers, "Evacuation Centers");
layerControl.addOverlay(courier_markers, "Couriers");

$.each(result1, function(key, value) {
    if (value.latitude !== null && value.longitude !== null) {
        var marker = new L.marker([value.latitude, value.longitude], {
                icon: evacIcon()
            })
            .bindPopup('<div class="font-weight-bold">' + value.address + ", " + value.name + '</div>' +
                '<div class="my-2">' +
                '<div class="row">' +
                // clothes column
                '<div class="supply-card col-4 d-flex align-items-center flex-column"> ' +
                '<img class="supply-icon my-2" src="/assets/supply-icon/supply-icon-circle/Clothes.svg">' +
                '<div class="progress-group my-1">' +
                '<div class="progress-group-header align-items-center">' +
                '<h2 class="data font-weight-bold py-0 mx-2">' + value.clothes + '</h2>' +
                '</div>' +
                '<div class="progress-group-bars">' +
                '<div class="progress progress-xs">' +
                '<div class="progress-bar bg-warning" role="progressbar" style="width: ' +
                (value.clothes / value.capacity * 100) +
                '%" aria-valuenow="56" aria-valuemin="0" aria-valuemax="' + value.capacity + '"></div>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '<h6 class="small text-center  my-1">Clothes (' + (value.clothes / value
                    .capacity *
                    100) +
                '%)</h6>' +

                '</div>' +

                // esa column
                '<div class="supply-card col-4 d-flex align-items-center flex-column"> ' +
                '<img class="supply-icon my-2" src="/assets/supply-icon/supply-icon-circle/ESA.svg">' +
                '<div class="progress-group my-1">' +
                '<div class="progress-group-header align-items-center">' +
                '<h2 class="data font-weight-bold py-0 mx-2">' + value.emergency_shelter_assistance + '</h2>' +
                '</div>' +
                '<div class="progress-group-bars">' +
                '<div class="progress progress-xs">' +
                '<div class="progress-bar bg-warning" role="progressbar" style="width: ' +
                (value.emergency_shelter_assistance / value.capacity * 100) +
                '%" aria-valuenow="56" aria-valuemin="0" aria-valuemax="' + value.capacity + '"></div>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '<h6 class="small text-center  my-1">ESA (' + (value
                    .emergency_shelter_assistance /
                    value.capacity *
                    100) +
                '%)</h6>' +

                '</div>' +

                // Food column
                '<div class="supply-card col-4 d-flex align-items-center flex-column"> ' +
                '<img class="supply-icon my-2" src="/assets/supply-icon/supply-icon-circle/Food.svg">' +
                '<div class="progress-group my-1">' +
                '<div class="progress-group-header align-items-center">' +
                '<h2 class="data font-weight-bold py-0 mx-2">' + value.food_packs + '</h2>' +
                '</div>' +
                '<div class="progress-group-bars">' +
                '<div class="progress progress-xs">' +
                '<div class="progress-bar bg-warning" role="progressbar" style="width: ' +
                (value.food_packs / value.capacity * 100) +
                '%" aria-valuenow="56" aria-valuemin="0" aria-valuemax="' + value.capacity + '"></div>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '<h6 class="small text-center  my-1">Food Packs (' + (value.food_packs / value
                    .capacity *
                    100) +
                '%)</h6>' +

                '</div>' +

                // row end
                '</div>' +

                '<div class="row pt-2 mt-1 border-top">' +
                // hygiene kit column
                '<div class="supply-card col-4 d-flex align-items-center flex-column"> ' +
                '<img class="supply-icon my-2" src="/assets/supply-icon/supply-icon-circle/Hygiene kit.svg">' +
                '<div class="progress-group my-1">' +
                '<div class="progress-group-header align-items-center">' +
                '<h2 class="data font-weight-bold py-0 mx-2">' + value.hygiene_kit + '</h2>' +
                '</div>' +
                '<div class="progress-group-bars">' +
                '<div class="progress progress-xs">' +
                '<div class="progress-bar bg-warning" role="progressbar" style="width: ' +
                (value.hygiene_kit / value.capacity * 100) +
                '%" aria-valuenow="56" aria-valuemin="0" aria-valuemax="' + value.capacity + '"></div>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '<h6 class="small text-center  my-1">Hygiene Kit (' + (value.hygiene_kit / value
                    .capacity *
                    100) +
                '%)</h6>' +

                '</div>' +

                // Medicine column
                '<div class="supply-card col-4 d-flex align-items-center flex-column"> ' +
                '<img class="supply-icon my-2" src="/assets/supply-icon/supply-icon-circle/Medicine.svg">' +
                '<div class="progress-group my-1">' +
                '<div class="progress-group-header align-items-center">' +
                '<h2 class="data font-weight-bold py-0 mx-2">' + value.medicine + '</h2>' +
                '</div>' +
                '<div class="progress-group-bars">' +
                '<div class="progress progress-xs">' +
                '<div class="progress-bar bg-warning" role="progressbar" style="width: ' +
                (value.medicine / value.capacity * 100) +
                '%" aria-valuenow="56" aria-valuemin="0" aria-valuemax="' + value.capacity + '"></div>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '<h6 class="small text-center  my-1">Medicine (' + number_format((float)(value
                    .medicine /
                    value.capacity *
                    100), 2, '.', '') +
                '%)</h6>' +

                '</div>' +

                // Water column
                '<div class="supply-card col-4 d-flex align-items-center flex-column"> ' +
                '<img class="supply-icon my-2" src="/assets/supply-icon/supply-icon-circle/Water.svg">' +
                '<div class="progress-group my-1">' +
                '<div class="progress-group-header align-items-center">' +
                '<h2 class="data font-weight-bold py-0 mx-2">' + value.water + '</h2>' +
                '</div>' +
                '<div class="progress-group-bars">' +
                '<div class="progress progress-xs">' +
                '<div class="progress-bar bg-warning" role="progressbar" style="width: ' +
                (value.water / value.capacity * 100) +
                '%" aria-valuenow="56" aria-valuemin="0" aria-valuemax="' + value.capacity + '"></div>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '<h6 class="small text-center  my-1">Water (' + (value.water / value
                    .capacity *
                    100) +
                '%)</h6>' +

                '</div>' +

                // row end
                '</div>' +

                '</div>', evacOptions())
            .addTo(evac_markers);

        evac_markers.addTo(mymap);
    }
});

$.each(result2, function(key, value) {
    if (value.latitude !== null && value.longitude !== null) {
        var marker = L.marker([value.latitude, value.longitude], {
                icon: truckIcon()
            })
            .bindPopup('<div class="font-weight-bold text-center">' + value.name + '</div>', truckOptions())
            .addTo(courier_markers);
        courier_markers.addTo(mymap);
    }
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
                if (value.latitude !== null && value.longitude !== null) {
                    var marker = new L.marker([value[i].latitude, value[i].longitude], {
                            icon: evacIcon()
                        })
                        .bindPopup('<div class="font-weight-bold">' + value[i].name + '</div>' +
                            '<div class="my-2">' +
                            '<div class="progress-group">' +
                            '<div class="progress-group-header align-items-end">' +
                            '<div>Food</div>' +
                            '<div class="ml-auto font-weight-bold mr-2">' + value[i]
                            .food_packs +
                            '</div>' +
                            '<div class="text-muted small">(' + (value[i].food_packs / value[i]
                                .capacity * 100) +
                            '%)</div>' +
                            '</div>' +
                            '<div class="progress-group-bars">' +
                            '<div class="progress progress-xs">' +
                            '<div class="progress-bar bg-warning" role="progressbar" style="width: ' +
                            (value[i].food_packs / value[i].capacity * 100) +
                            '%" aria-valuenow="56" aria-valuemin="0" aria-valuemax="' + value[i]
                            .capacity + '"></div>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '<div class="progress-group">' +
                            '<div class="progress-group-header align-items-end">' +
                            '<div>Water</div>' +
                            '<div class="ml-auto font-weight-bold mr-2">' + value[i].water +
                            '</div>' +
                            '<div class="text-muted small">(' + (value[i].water / value[i]
                                .capacity * 100) +
                            '%)</div>' +
                            '</div>' +
                            '<div class="progress-group-bars">' +
                            '<div class="progress progress-xs">' +
                            '<div class="progress-bar bg-warning" role="progressbar" style="width: ' +
                            (value[i].water / value[i].capacity * 100) +
                            '%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="' + value[i]
                            .capacity + '"></div>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '<div class="progress-group">' +
                            '<div class="progress-group-header align-items-end">' +
                            '<div>Clothes</div>' +
                            '<div class="ml-auto font-weight-bold mr-2">' + value[i].clothes +
                            '</div>' +
                            '<div class="text-muted small">(' + (value[i].clothes / value[i]
                                .capacity * 100) +
                            '%)</div>' +
                            '</div>' +
                            '<div class="progress-group-bars">' +
                            '<div class="progress progress-xs">' +
                            '<div class="progress-bar bg-warning" role="progressbar" style="width: ' +
                            (value[i].clothes / value[i].capacity * 100) +
                            '%" aria-valuenow="11" aria-valuemin="0" aria-valuemax="' + value[i]
                            .capacity + '"></div>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '<div class="progress-group">' +
                            '<div class="progress-group-header align-items-end">' +
                            '<div>Hygiene Kit</div>' +
                            '<div class="ml-auto font-weight-bold mr-2">' + value[i]
                            .hygiene_kit +
                            '</div>' +
                            '<div class="text-muted small">(' + (value[i].hygiene_kit / value[i]
                                .capacity * 100) +
                            '%)</div>' +
                            '</div>' +
                            '<div class="progress-group-bars">' +
                            '<div class="progress progress-xs">' +
                            '<div class="progress-bar bg-warning" role="progressbar" style="width: ' +
                            (value[i].hygiene_kit / value[i].capacity * 100) +
                            '%" aria-valuenow="8" aria-valuemin="0" aria-valuemax="' + value[i]
                            .capacity + '"></div>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '<div class="progress-group">' +
                            '<div class="progress-group-header align-items-end">' +
                            '<div>Medicine</div>' +
                            '<div class="ml-auto font-weight-bold mr-2">' + value[i].medicine +
                            '</div>' +
                            '<div class="text-muted small">(' + (value[i].medicine / value[i]
                                .capacity * 100) +
                            '%)</div>' +
                            '</div>' +
                            '<div class="progress-group-bars">' +
                            '<div class="progress progress-xs">' +
                            '<div class="progress-bar bg-warning" role="progressbar" style="width: ' +
                            (value[i].medicine / value[i].capacity * 100) +
                            '%" aria-valuenow="8" aria-valuemin="0" aria-valuemax="' + value[i]
                            .capacity + '"></div>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '<div class="progress-group">' +
                            '<div class="progress-group-header align-items-end">' +
                            '<div>ESA</div>' +
                            '<div class="ml-auto font-weight-bold mr-2">' +
                            value[i].emergency_shelter_assistance + '</div>' +
                            '<div class="text-muted small">(' +
                            (value[i].emergency_shelter_assistance / value[i].capacity * 100) +
                            '%)</div>' +
                            '</div>' +
                            '<div class="progress-group-bars">' +
                            '<div class="progress progress-xs">' +
                            '<div class="progress-bar bg-warning" role="progressbar" style="width: ' +
                            (value[i].emergency_shelter_assistance / value[i].capacity * 100) +
                            '%" aria-valuenow="8" aria-valuemin="0" aria-valuemax="' + value[i]
                            .capacity + '"></div>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>', evacOptions())
                        .addTo(evac_markers);
                    evac_markers.addTo(mymap);
                }
            }
        });
    });

    channel.bind('courier-event', function(data) {
        var result = data;
        courier_markers.clearLayers();
        $.each(result, function(key, value) {
            for (var i = 0; i < value.length; ++i) {
                //console.log(i);
                if (value.latitude !== null && value.longitude !== null) {
                    var marker = new L.marker([value[i].latitude, value[i].longitude], {
                            icon: truckIcon()
                        })
                        .bindPopup('<div class="font-weight-bold">' + value[i].name + '</div>',
                            truckOptions())
                        .addTo(courier_markers);
                    courier_markers.addTo(mymap);
                }
            }
        })
    });

    channel.bind('disaster_response-event', function(data) {
        setTimeout(function() {
            window.location.reload(true)
        }, 1000);
    });

    //display the affected barangays
    Promise.all([_affectedAreas(), _loadGeoJson(), ])
        .then(([data, json]) => {
            drawPolygons(data, json);
        }).catch(error => {
            console.log(error); // rejectReason of any first rejected promise
        });
});

// import data from "{{ asset('js/map-js/Barangays.json') }}" assert { type: "json" };
// var geojs = {"type":"FeatureCollection","features":[{"type":"Feature","geometry":{"type":"Polygon","coordinates":[[[123.26497650146484,13.666029930114746],[123.26141357421898,13.665860176086483],[123.2579574584961,13.665369987487793],[123.2511672973634,13.663149833679256],[123.24574279785156,13.662039756774902],[123.24458312988281,13.661829948425407],[123.24183654785168,13.661100387573299],[123.23719024658226,13.659810066223258],[123.23184967041038,13.658370018005371],[123.22580718994152,13.65711975097662],[123.21806335449219,13.655480384826774],[123.2148208618164,13.655090332031364],[123.21016693115246,13.654740333557243],[123.22844696044933,13.64896011352539],[123.23222351074241,13.643070220947266],[123.24571228027344,13.643560409545955],[123.24471282958984,13.63661003112793],[123.27207946777344,13.637920379638672],[123.27108001708984,13.640680313110295],[123.27066802978516,13.643520355224666],[123.26983642578136,13.645910263061637],[123.2689437866211,13.64923954010004],[123.26750946044945,13.656009674072266],[123.2668685913086,13.65814018249506],[123.26612091064453,13.661700248718262],[123.26566314697277,13.663310050964412],[123.2655029296875,13.665140151977539],[123.26497650146484,13.666029930114746]]]},"properties":{"ID_0":177,"ISO":"PHL","NAME_0":"Philippines","ID_1":20,"NAME_1":"Camarines Sur","ID_2":370,"NAME_2":"Naga City","ID_3":8734,"NAME_3":"Pacol","NL_NAME_3":"","VARNAME_3":"","TYPE_3":"Barangay","ENGTYPE_3":"Village","PROVINCE":"Camarines Sur","REGION":"Bicol Region (Region V)"}},
// ]};

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
</script>
@endsection