@extends('layouts.mobileBase')

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
@endsection

@section('content')

<div class="container-fluid">
    <div class="fade-in">
        <div class="row center">
            <div class="col-md-8">
                <!-- Title  -->
                <div class="row center">
                    <div class="col-md-6 px-3 p-0 mb-3">
                        <h5 class="font-weight-bold">Inventory</h5>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        @if(Session::has('message'))
                        <div class="alert alert-success">{{ Session::get('message') }}</div>
                        @endif
                    </div>
                </div>
                <div class="row center">
                    <div class="col-md-6 justify-content-between d-flex">
                        <div class="dropdown ">
                            <button class=" btn btn-outline-primary p-1" type=" button" id="dropdownMenuButton1"
                                data-toggle="dropdown">Filter
                                <span>
                                    <svg class="c-icon ">
                                        <use xlink:href="/assets/icons/coreui/free-symbol-defs.svg#cui-filter"></use>
                                    </svg>
                                </span>
                            </button>
                            <ul id="dropdownMenuButton1" class="dropdown-menu p-2"
                                aria-labelledby="dropdownMenuButton1">
                                <li onclick="filter('all')"><a id="all" class="dropdown-item active">Show All</a></li>
                                <li onclick="filter('Food Packs')"><a id="Food Packs" class="dropdown-item">Food
                                        Packs</a>
                                </li>
                                <li onclick="filter('Water')"><a id="Water" class="dropdown-item">Water</a></li>
                                <li onclick="filter('Clothes')"><a id="Clothes" class="dropdown-item">Clothes</a></li>
                                <li onclick="filter('Hygiene Kit')"><a id="Hygiene Kit" class="dropdown-item">Hygiene
                                        Kit</a></li>
                                <li onclick="filter('Medicine')"><a id="Medicine" class="dropdown-item">Medicine</a>
                                </li>
                                <li onclick="filter('ESA')"><a id="ESA" class="dropdown-item">ESA</a></li>
                            </ul>
                        </div>
                        <div class="col-9 p-0 float-right">
                            <div class="input-group">
                                <!-- <span class="input-group-addon">Search</span> -->
                                <input type="text" name="search-text" id="search-text" placeholder="Search"
                                    class="form-control ">
                            </div>
                            </span>

                        </div>

                    </div>
                </div>


                <div class="col-md-6 px-0 pt-4 mx-auto">
                    <ul id="result" class="list-group list-group-hover list-group-striped">
                        @if(empty($is_empty->id))
                        <li class="list-group-item list-group-item-action Food Packs Water Clothes Hygiene Kit Medicine ESA"
                            id="default">
                            <div class="row">
                                <div class="col-12">
                                    <h6 class="font-weight-bold text-center">
                                        No supplies.
                                    </h6>
                                </div>
                            </div>
                        </li>
                        @endif
                        @foreach($inventory_supplies as $supply)
                        <li class="list-group-item list-group-item-action {{ $supply->supply_type }}">
                            <a href="/barangay-captain/details/{{ $supply->id }}">
                                <div class="row">
                                    <div class="col-7">
                                        <h6 class="font-weight-bold">{{ $supply->supply_type }}</h6>
                                        <small>{{ $supply->quantity }} pcs</small>
                                        <br>
                                        <small>{{ $supply->source }} </small>
                                    </div>
                                    <div class="col-5">
                                        <span class="float-right ">
                                            <small>{{ $supply->date  }}</small>
                                        </span>
                                    </div>
                                </div>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('javascript')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>
var li, li_a, li_b, li_c, li_d, li_e, li_f;
filter('all');

function filter(supply_type) {
    //var def = document.getElementById("default");
    li = document.getElementsByClassName('list-group-item');
    li_a = document.getElementsByClassName('Food Packs');
    li_b = document.getElementsByClassName('Water');
    li_c = document.getElementsByClassName('Clothes');
    li_d = document.getElementsByClassName('Hygiene Kit');
    li_e = document.getElementsByClassName('Medicine');
    li_f = document.getElementsByClassName('ESA');

    var active = document.getElementsByClassName('active');
    if (active !== null) active[0].classList.remove('active');

    for (var i = 0; i < li.length; i++) {
        li[i].style.display = "none";
    }
    show_remove(supply_type);
}

function show_remove(x) {
    if (x === 'all') {
        document.getElementById('all').classList.add('active');
        for (var i = 0; i < li.length; i++) {
            li[i].style.display = "";
        }
    }

    if (x === 'Food Packs') {
        if (li_a !== null) document.getElementById('Food Packs').classList.add('active');
        for (var i = 0; i < li_a.length; i++) {
            if (li_a !== null) li_a[i].style.display = "";
        }
    }

    if (x === 'Water') {
        if (li_b !== null) document.getElementById('Water').classList.add('active');
        for (var i = 0; i < li_b.length; i++) {
            if (li_b !== null) li_b[i].style.display = "";
        }
    }
    if (x === 'Clothes') {
        if (li_c !== null) document.getElementById('Clothes').classList.add('active');
        for (var i = 0; i < li_c.length; i++) {
            if (li_c !== null) li_c[i].style.display = "";
        }
    }

    if (x === 'Hygiene Kit') {
        if (li_d !== null) document.getElementById('Hygiene Kit').classList.add('active');
        for (var i = 0; i < li_d.length; i++) {
            if (li_d !== null) li_d[i].style.display = "";
        }
    }

    if (x === 'Medicine') {
        if (li_e !== null) document.getElementById('Medicine').classList.add('active');
        for (var i = 0; i < li_e.length; i++) {
            if (li_e !== null) li_e[i].style.display = "";
        }
    }
    if (x === 'ESA') {
        if (li_f !== null) document.getElementById('ESA').classList.add('active');
        for (var i = 0; i < li_f.length; i++) {
            if (li_f !== null) li_f[i].style.display = "";
        }
    }
}

$(document).ready(function() {
    $('#search-text').keyup(function() {
        var text = $(this).val();
        $.ajax({
            url: "/barangay-captain/search/bc-supplies/",
            data: {
                text: text
            },
            dataType: 'json',
            beforeSend: function() {
                $('#result').html(
                    '<li class="list-group-item">Loading...</li>')
            },
            success: function(res) {
                console.log(res);
                var _html = '';
                $.each(res, function(index, data) {
                    _html +=
                        '<li class="list-group-item list-group-item-action' + data
                        .supply_type + '">' +
                        '<a href="/barangay-captain/details/' + data.id + '">' +
                        '<div class="row">' +
                        '<div class="col-7">' +
                        '<h6 class="font-weight-bold">' + data.supply_type +
                        '</h6>' +
                        '<small>' + data.quantity + ' pcs</small>' +
                        '<br>' +
                        '<small>' + data.source + '</small>' +
                        '</div>' +
                        '<div class="col-5">' +
                        '<span class="float-right ">' +
                        '<small>' + data.date +
                        '</small>' +
                        '</span>' +
                        '</div>' +
                        '</div>' +
                        '</a>' +
                        '</li>';
                });
                $('#result').html(_html);
            }

        })
    })
})
</script>

@endsection