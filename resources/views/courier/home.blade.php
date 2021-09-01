@extends('layouts.mobileBase')

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
@endsection

@section('content')

<div class="container-fluid">
    <div class="fade-in">
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
        <div class="row center">
            <div class="col-md-8 col-sm-12 col-lg-12 col-xl-12">
                <!-- Title  -->
                <div class="col-md-12 justify-content-between d-flex align-items-baseline p-0 mb-3">
                    <h5 class="font-weight-bold">Deliveries</h5>
                    <div class="dropdown ">
                        <button class=" btn btn-outline-primary " type=" button" id="dropdownMenuButton1"
                            data-toggle="dropdown">Filter
                            <span>
                                <svg class="c-icon ">
                                    <use xlink:href="/assets/icons/coreui/free-symbol-defs.svg#cui-filter"></use>
                                </svg>
                            </span>
                        </button>
                        <ul id="dropdownMenuButton1" class="dropdown-menu p-2" aria-labelledby="dropdownMenuButton1">
                            <li onclick="filter('all')"><a id="all" class="dropdown-item active">Show All</a></li>
                            <li onclick="filter('preparing')"><a id="preparing" class="dropdown-item">Preparing</a></li>
                            <li onclick="filter('in-transit')"><a id="in-transit" class="dropdown-item">In-transit</a>
                            </li>
                            <li onclick="filter('delivered')"><a id="delivered" class="dropdown-item">Delivered</a></li>
                            <li onclick="filter('cancelled')"><a id="cancelled" class="dropdown-item">Cancelled</a></li>
                            <li onclick="filter('declined')"><a id="declined" class="dropdown-item">Declined</a></li>
                        </ul>
                    </div>
                </div>


                <div class="col-md-12 col-sm-12 col-lg-12 col-xl-12 px-0 pt-4 ">
                    <ul class="list-group list-group-hover list-group-striped mb-4" id="ul-parent">
                        @if(empty($is_empty->id))
                        <li class="list-group-item list-group-item-action preparing in-transit cancelled decline delivered"
                            id="default">
                            <div class="row">
                                <div class="col-12">
                                    <h6 class="font-weight-bold text-center">
                                        No delivery requests yet.
                                    </h6>
                                </div>
                            </div>
                        </li>
                        @endif

                        @foreach($delivery_requests as $delivery_request)

                        <li class="list-group-item list-group-item-action {{ $delivery_request->status }}">
                            <a href="/courier/details/{{ $delivery_request->id }}">
                                <div class="row justify-content-between d-flex">
                                    <div>
                                        <h6 class="font-weight-bold">
                                            {{date('g:i a, F d, Y', strtotime($delivery_request->updated_at)) }}
                                        </h6>
                                        <small>{{ $delivery_request->evacuation_center_name }}</small>

                                    </div>

                                    <div>
                                        <span class="float-right ">
                                            @if( $delivery_request->status == 'preparing' )
                                            <div>
                                                <a href="/requests/courier/accept/{{ $delivery_request->id }}"
                                                    onclick="return confirm('Are you sure to accept the request?')">
                                                    <button
                                                        class="btn btn-acccent bg-accent text-white text-center">Accept</button>
                                                </a>
                                            </div>

                                            @elseif( $delivery_request->status == 'in-transit' )
                                            <div class="rounded bg-secondary text-white text-center px-2 py-1">
                                                In&#8209;transit
                                            </div>
                                            @elseif( $delivery_request->status == 'cancelled' )
                                            <div class="rounded bg-danger text-white text-center px-2 py-1">
                                                Cancelled
                                            </div>
                                            @elseif( $delivery_request->status == 'declined' )
                                            <div class="rounded bg-danger text-white text-center px-2 py-1">
                                                Declined
                                            </div>
                                            @elseif( $delivery_request->status == 'delivered' )
                                            <div class="rounded bg-primary text-white text-center px-2 py-1">
                                                Delivered
                                            </div>
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </a>
                        </li>


                        @endforeach
                        {{-- <li class="list-group-item list-group-item-action ">
                            <a href="/courier/details">
                                <div class="row">
                                    <div class="col-8">
                                        <h6 class="font-weight-bold">July 10, 2021</h6>
                                        <small>Del Rosario Elementary School</small>

                                    </div>
                                    <div class="col-4">
                                        <span class="float-right ">
                                            <div class="rounded bg-secondary text-white text-center px-2 py-1">
                                                In-transit</div>
                                        </span>
                                    </div>
                                </div>
                            </a>
                        </li> --}}
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('javascript')
<script>
var li, li_a, li_b, li_c, li_d, li_e;
filter('all');

function filter(status) {
    //var def = document.getElementById("default");
    li = document.getElementsByClassName('list-group-item');
    li_a = document.getElementsByClassName('preparing');
    li_b = document.getElementsByClassName('in-transit');
    li_c = document.getElementsByClassName('delivered');
    li_d = document.getElementsByClassName('cancelled');
    li_e = document.getElementsByClassName('declined');

    var active = document.getElementsByClassName('active');
    if (active !== null) active[0].classList.remove('active');

    for (var i = 0; i < li.length; i++) {
        //console.log(li);
        // if(def !== null )
        //     break;
        li[i].style.display = "none";
        //show_remove(status, i);
    }
    show_remove(status);
}

function show_remove(x) {
    if (x === 'all') {
        document.getElementById('all').classList.add('active');
        for (var i = 0; i < li.length; i++) {
            li[i].style.display = "";
        }
    }

    if (x === 'preparing') {
        if (li_a !== null) document.getElementById('preparing').classList.add('active');
        for (var i = 0; i < li_a.length; i++) {
            if (li_a !== null) li_a[i].style.display = "";
        }
    }

    if (x === 'in-transit') {
        if (li_b !== null) document.getElementById('in-transit').classList.add('active');
        for (var i = 0; i < li_b.length; i++) {
            if (li_b !== null) li_b[i].style.display = "";
        }
    }
    if (x === 'delivered') {
        if (li_c !== null) document.getElementById('delivered').classList.add('active');
        for (var i = 0; i < li_c.length; i++) {
            if (li_c !== null) li_c[i].style.display = "";
        }
    }

    if (x === 'cancelled') {
        if (li_d !== null) document.getElementById('cancelled').classList.add('active');
        for (var i = 0; i < li_d.length; i++) {
            if (li_d !== null) li_d[i].style.display = "";
        }
    }

    if (x === 'declined') {
        if (li_e !== null) document.getElementById('declined').classList.add('active');
        for (var i = 0; i < li_e.length; i++) {
            if (li_e !== null) li_e[i].style.display = "";
        }
    }
}
$(document).ready(function() {
    //remove on production
    Pusher.logToConsole = true;

    var pusher = new Pusher('ab82b7896a919c5e39dd', {
        cluster: 'ap1'
    });

    var channel = pusher.subscribe('requests01-channel');
    channel.bind('courier-deliver-event', function(data) {
        var html = "";
        //console.log(data.delivery_requests);
        //console.log(data.is_empty);
        if (data == null) {
            html += `<li class="list-group-item list-group-item-action ">
                        <div class="row">
                            <div class="col-12">
                                <h6 class="font-weight-bold text-center">
                                    No delivery requests yet.
                                </h6>
                            </div>
                        </div>
                    </li>`;
            return;
        }
        $.each(data, function(key, value) {
            for (var i = 0; i < value.length; ++i) {
                html += `<li class="list-group-item list-group-item-action  ${value[i].status}">
                            <a href="/courier/details/${value[i].id}">
                                    <div class="row">
                                        <div class="col-8">
                                            <h6 class="font-weight-bold">${value[i].updated_at}</h6>
                                            <small> ${value[i].evacuation_center_name} </small>
                                        </div>
                                        <div class="col-4">
                                            <span class="float-right ">`;

                if (value[i].status == 'preparing') {
                    //var url = '{{ route("request.courier_accept", ":slug") }}';
                    //var url = "{{route('request.courier_accept', '')}}"+"/"+value[i].id;
                    //url = url.replace(':slug', value[i].id);
                    html += `<a href="/requests/courier/accept/` + value[i].id + `" onclick="return confirm('Are you sure to accept the request?')">
                            <button class="btn btn-acccent bg-accent text-white text-center" >Accept</button>
                            </a>`;
                } else if (value[i].status == 'in-transit') {
                    html +=
                        `<div class="rounded bg-secondary text-white text-center px-2 py-1">In&#8209;transit</div>`;
                } else if (value[i].status == 'cancelled') {
                    html +=
                        `<div class="rounded bg-danger text-white text-center px-2 py-1">Cancelled</div>`;
                } else if (value[i].status == 'declined') {
                    html +=
                        `<div class="rounded bg-danger text-white text-center px-2 py-1">Declined</div>`;
                } else if (value[i].status == 'delivered') {
                    html +=
                        `<div class="rounded bg-primary text-white text-center px-2 py-1">Delivered</div>`;
                }
                html += `</span></div></div></a></li>`;
            }
        });
        $('#ul-parent').html(html);
    });
});
</script>
@endsection