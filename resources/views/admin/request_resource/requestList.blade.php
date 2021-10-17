@extends('layouts.webBase')
@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
    integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
    crossorigin="" />
<!-- Make sure you put this AFTER Leaflet's CSS -->
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
    integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
    crossorigin=""></script>
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

<link href="{{ asset('css/map.css') }}" rel="stylesheet">
<style>
#mapid {
    height: 75vh;
}
</style>
@endsection
@section('content')

<div class="container-fluid">
    <div class="animated fadeIn">
        <div class="row justify-content-between d-flex">
            <div class="col-lg-6 ">
                <h1 class="title">
                    Requests
                </h1>
            </div>

            <div class="dropdown mr-4">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                    data-toggle="dropdown" aria-expanded="false">
                    Export to
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="{{ url('/export/requests') }}">Excel</a>
                    <a class="dropdown-item" href="{{ url('/export/requests/pdf') }}" target="_blank">PDF</a>
                </div>
            </div>


        </div>
        <div class="row">
            @if(count($errors) > 0)
            <div class="alert alert-danger col-12">
                <h6>
                    Upload Validation error
                </h6>
                <ul>
                    @foreach($errors as $error)
                    <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
            @endif

        </div>
        <div class="row">
            <div class="col-12">
                @if(Session::has('message'))
                <div class="alert alert-success">
                    {{ Session::get('message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="card">
                    {{-- <div class="card-header">
                    </div> --}}
                    <div class="card-body">
                        <div id="requestList">
                            <table id="requesTable" class="table table-borderless table-hover table-light table-striped"
                                style="max-width: 300%;">
                                <thead>
                                    <tr>
                                        <th>TIME RECEIVED</th>
                                        <th>REQUEST ID</th>
                                        <th>CAMP MANAGER NAME</th>
                                        <th>EVACUATION CENTER</th>
                                        <th>FOOD PACKS</th>
                                        <th>WATER</th>
                                        <th>HYGIENE KIT</th>
                                        <th>CLOTHES</th>
                                        <th>MEDICINE</th>
                                        <th>EMERGENCY SHELTER ASSISTANCE</th>
                                        <th>NOTE</th>

                                        <th>STATUS</th>


                                        <th>ACTIONS</th>

                                    </tr>
                                </thead>
                                <tbody id="request-tbody">
                                    <div id="request-wrapper">
                                        @foreach($delivery_requests as $delivery_request)
                                        <tr>
                                            <td>{{date('g:i a m/d/Y', strtotime($delivery_request->updated_at)) }}</td>
                                            <td>{{ $delivery_request->id }}</td>
                                            <td>{{ $delivery_request->camp_manager_name }}</td>
                                            <td class="evac-data " id="{{ $delivery_request->evacuation_center_id }}"
                                                data-toggle="popover">
                                                <u> {{ $delivery_request->evacuation_center_name }},
                                                    {{ $delivery_request->evacuation_center_address }}</u>
                                            </td>
                                            <td>{{ $delivery_request->food_packs }}</td>
                                            <td>{{ $delivery_request->water }}</td>
                                            <td>{{ $delivery_request->hygiene_kit }}</td>
                                            <td>{{ $delivery_request->clothes }}</td>
                                            <td>{{ $delivery_request->medicine }}</td>
                                            <td>{{ $delivery_request->emergency_shelter_assistance }}</td>
                                            <td>{{ $delivery_request->note }}</td>

                                            @if( $delivery_request->status == 'pending' )
                                            <td>
                                                <div class="badge badge-pill bg-secondary-accent text-white">
                                                    {{ strtoupper($delivery_request->status) }}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="row">
                                                    <div class="col-6 ">
                                                        <a href="{{ route('request.approve', ['id' => $delivery_request->id] ) }}"
                                                            onclick="return confirm('Are you sure to approve the request?')">
                                                            {{-- <img class="c-icon" src="{{ url('icons/sprites/accept-request.svg') }}"
                                                            /> --}}
                                                            <svg width="25" height="25"
                                                                xmlns="http://www.w3.org/2000/svg">
                                                                <image
                                                                    href="{{ url('icons/sprites/approve-request.svg') }}"
                                                                    height="25" width="25" />
                                                            </svg>
                                                        </a>
                                                    </div>
                                                    <div class="col-6">
                                                        {{-- <form action="" method="post">
                                                            @csrf
                                                            @method("DELETE")
                                                            <button type="submit" value="Delete" name="submit" class="btn-borderless" onclick="return confirm('Are you sure to delete?')">
                                                                <svg width="25" height="25" xmlns="http://www.w3.org/2000/svg">
                                                                    <image href="{{ url('icons/sprites/decline-request.svg') }}"
                                                        height="25" width="25"/>
                                                        </svg>
                                                        </button>
                                                        </form> --}}
                                                        <a href="{{ route('request.admin_decline', ['id' => $delivery_request->id] ) }}"
                                                            onclick="return confirm('Are you sure to decline the request?')">
                                                            <svg width="25" height="25"
                                                                xmlns="http://www.w3.org/2000/svg">
                                                                <image
                                                                    href="{{ url('icons/sprites/decline-request.svg') }}"
                                                                    height="25" width="25" />
                                                            </svg>
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                            @elseif( $delivery_request->status == 'preparing' &&
                                            empty($delivery_request->courier_id))
                                            <td>
                                                <span class="badge badge-pill bg-accent text-white">
                                                    {{ strtoupper($delivery_request->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="row">
                                                    <div class="col-6 ">
                                                        <a href="" data-toggle="modal" data-target="#assignModal"
                                                            data-evac-id="{{ $delivery_request->evacuation_center_id }}">
                                                            {{-- <img class="c-icon" src="{{ url('icons/sprites/accept-request.svg') }}"
                                                            /> --}}
                                                            <svg width="25" height="25"
                                                                xmlns="http://www.w3.org/2000/svg">
                                                                <image
                                                                    href="{{ url('icons/sprites/assign-courier.svg') }}"
                                                                    height="25" width="25" />
                                                            </svg>
                                                        </a>
                                                        <!-- Button trigger modal -->
                                                        {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                                            Launch demo modal
                                                        </button> --}}

                                                        <!-- Modal -->
                                                        <div class="modal fade" id="assignModal" tabindex="-1"
                                                            role="dialog" aria-labelledby="exampleModalLabel"
                                                            aria-hidden="true" data-backdrop="static"
                                                            data-keyboard="false">
                                                            <div class="modal-dialog modal-lg" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        {{-- <h5 class="modal-title" id="exampleModalLabel">Assign Courier</h5> --}}
                                                                        <form method="POST"
                                                                            action="{{ route('request.assign_courier', ['id' => $delivery_request->id] ) }}">
                                                                            @csrf
                                                                            <label for="courier_id"
                                                                                class="mr-3 lead modal-title"
                                                                                id="exampleModalLabel">Assign
                                                                                Courier</label>
                                                                            <select name="courier_id" id='courier_id'
                                                                                class="w-100 form-control" required>
                                                                                {{-- <option value=''>Select User</option> --}}
                                                                                {{-- @foreach($couriers as $courier)
                                                                            <option value='{{ $courier->id }}'>
                                                                                {{ $courier->name }}
                                                                                </option>
                                                                                @endforeach --}}
                                                                            </select>

                                                                            <input type="submit" id="submit-form"
                                                                                class="hidden d-none" />
                                                                        </form>

                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="row">
                                                                            <div class="w-100" id="mapid"></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-dismiss="modal">Close</button>
                                                                        {{-- <button type="button" class="btn btn-warning">Assign</button> --}}
                                                                        <label for="submit-form" class="btn btn-warning"
                                                                            tabindex="0">Assign</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <a href="{{ route('request.cancel', ['id' => $delivery_request->id] ) }}"
                                                            onclick="return confirm('Are you sure to cancel the request?')">
                                                            <svg width="25" height="25"
                                                                xmlns="http://www.w3.org/2000/svg">
                                                                <image
                                                                    href="{{ url('icons/sprites/decline-request.svg') }}"
                                                                    height="25" width="25" />
                                                            </svg>
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                            @elseif( $delivery_request->status == 'preparing' &&
                                            !empty($delivery_request->courier_id) )
                                            <td>
                                                <span class="badge badge-pill bg-accent text-white">
                                                    {{-- {{ strtoupper($delivery_request->status) }} --}}
                                                    PREPARING
                                                </span>
                                            </td>
                                            <td>
                                                <div class="row">
                                                    <div class="col-6 ">
                                                    </div>
                                                    <div class="col-6">
                                                        <a href="{{ route('request.cancel', ['id' => $delivery_request->id] ) }}"
                                                            onclick="return confirm('Are you sure to cancel the request?')">
                                                            <svg width="25" height="25"
                                                                xmlns="http://www.w3.org/2000/svg">
                                                                <image
                                                                    href="{{ url('icons/sprites/decline-request.svg') }}"
                                                                    height="25" width="25" />
                                                            </svg>
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                            @elseif( $delivery_request->status == 'in-transit' )
                                            <td>
                                                <span class="badge badge-pill bg-secondary text-white">
                                                    {{ strtoupper($delivery_request->status) }}
                                                </span>
                                            </td>
                                            <td>
                                            </td>
                                            @elseif( $delivery_request->status == 'delivered' )
                                            <td>
                                                <span class="badge badge-pill badge-primary text-white">
                                                    {{ strtoupper($delivery_request->status) }}
                                                </span>
                                            </td>
                                            <td>
                                            </td>
                                            @elseif( $delivery_request->status == 'declined' ||
                                            $delivery_request->status == 'cancelled')
                                            <td>
                                                <span class="badge badge-pill badge-danger text-white">
                                                    {{ strtoupper($delivery_request->status) }}
                                                </span>
                                            </td>
                                            <td>
                                            </td>
                                            @endif
                                        </tr>
                                        @endforeach
                                    </div>
                                </tbody>
                            </table>
                        </div>

                        {{-- {{ $evacuation_centers->links() }} --}}


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


@section('javascript')

<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>

<script src="{{ asset('js/map-js/maps-functions.js') }}"></script>
<script src="{{ asset('js/map-js/leaflet-maps-simplified.js') }}"></script>
<script>
var markers = L.layerGroup();
var ajax_request;
$(document).ready(function() {
    var evac_id = $('.evac-data').attr('id');
    $('.evac-data').popover({
        placement: "left",
        title: "Evacuation Center Data",
        content: fetchData(),
        html: true,
    }, );

    function fetchData() {
        var fetch_data = '';
        $.ajax({
            url: "requests/evac-data/" + evac_id,
            type: "GET",
            // async: false,
            data: "",
            success: function(data) {
                fetch_data = data;
            }
        });
        return fetch_data;
    }
});
$(document).ready(function() {
    var table = $('#requesTable').DataTable({
        "scrollX": true,
        "order": [],
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // $("#courier_id").select2();

    $("#assignModal").on('shown.coreui.modal', function(e) {
        $("#courier_id").select2();
        $("#courier_id").prop('disabled', true);
        $('#courier_id').append('<option value=' + '>Select Courier</option>');
        //console.log('The modal is fully shown.');
        setTimeout(function() {
            mymap.invalidateSize();
        }, 1);

        var evacID = $(e.relatedTarget).data('evac-id');
        //console.log(evacID);
        ajax_request = $.ajax({
            method: "GET",
            url: "/map/get_locations/" + evacID,
        }).done(function(data) {
            // markers.clearLayers();
            var evacuation = data.evacuation_center;
            console.log(evacuation);
            var result = data.couriers;
            $.each(result, function(key, value) {
                //console.log(value.latitude);
                $('#courier_id').append('<option value=' + value.id + '>' + value.name +
                    '</option>');
                if (value.latitude && value.longitude) {
                    var courier = L.marker([value.latitude, value.longitude], {
                            icon: truckIcon()
                        })
                        .bindPopup('<div class="font-weight-bold text-center">' + value
                            .name + '</div>', truckOptions())
                        .addTo(markers);
                    markers.addTo(mymap);
                    courier.openPopup();
                }

            });
            L.marker([evacuation.latitude, evacuation.longitude], {
                    icon: L.icon({
                        iconUrl: '/././assets/img/pins/orange-pin.png',
                        iconSize: [61, 52],
                        iconAnchor: [9, 48],
                        popupAnchor: [6, -50]
                    }),
                    title: evacuation.name
                })
                .bindPopup('<div class="font-weight-bold text-center">' + evacuation.name +
                    '</div>', truckOptions())
                .addTo(markers);
            markers.addTo(mymap);
            mymap.setView([evacuation.latitude, evacuation.longitude], 13);

            $("#courier_id").prop('disabled', false);
        });
    });

    $("#assignModal").on('hidden.coreui.modal', function(e) {
        markers.clearLayers();
        $('#courier_id').empty();

        ajax_request.abort();
        //$(".modal.fade.in").removeClass("modal fade in");
    });



    //remove on production
    // Pusher.logToConsole = true;

    var pusher = new Pusher('ab82b7896a919c5e39dd', {
        cluster: 'ap1'
    });

    var channel = pusher.subscribe('requests-admin-channel');
    channel.bind('deliver-event', function(data0) {
        if ($.fn.dataTable.isDataTable('#requestTable')) {
            $('#requestTable').DataTable().clear();
            $('#requestTable').DataTable().destroy();
        }

        $.ajax({
            method: "GET",
            url: "/requests/refresh",
        }).done(function(data) {


            //this is the shortcut implementation
            $('#requestList').html(data);
            var table = $('#requestTable').DataTable({
                "scrollX": true,
                "order": [],

            });

        });
    });

});
</script>

@endsection