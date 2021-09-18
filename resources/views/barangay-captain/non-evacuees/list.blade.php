@extends('layouts.mobileBase')

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
<link href="{{ asset('css/sectoral-class.css') }}" rel="stylesheet">
@endsection

@section('content')

<div class="container-fluid">
    <div class="fade-in">
        <div class="row center">
            <div class="col-md-8">
                <div class="row center">
                    <div class="col-md-6 p-0 px-3 mb-3">
                        <h5 class="font-weight-bold">Non Evacuees</h5>
                    </div>

                </div>
                <div class="row center">
                    <div class="col-md-6 justify-content-between d-flex">
                        <div class="dropdown ">
                            <button class=" btn btn-outline-primary p-1" type=" button" data-toggle="dropdown">Filter
                                <span>
                                    <svg class="c-icon ">
                                        <use xlink:href="/assets/icons/coreui/free-symbol-defs.svg#cui-filter"></use>
                                    </svg>
                                </span>
                            </button>
                            <ul id="dropdownMenuButton1" class="dropdown-menu p-2"
                                aria-labelledby="dropdownMenuButton1">
                                <li onclick="filter('all')"><a id="all" class="dropdown-item active">Show All</a></li>
                                <li onclick="filter('Yes')"><a id="Yes" class="dropdown-item">Family Representative</a>
                                </li>
                                <li onclick="filter('Children')"><a id="Children" class="dropdown-item">Children</a>
                                </li>
                                <li onclick="filter('Lactating')"><a id="Lactating" class="dropdown-item">Lactating</a>
                                </li>
                                <li onclick="filter('Person with Disability')"><a id="Person with Disability"
                                        class="dropdown-item">PWD</a></li>
                                <li onclick="filter('Senior Citizen')"><a id="Senior Citizen"
                                        class="dropdown-item">Senior
                                        Citizen</a></li>
                                <li onclick="filter('Pregnant')"><a id="Pregnant" class="dropdown-item">Pregnant</a>
                                </li>
                                <li onclick="filter('Solo Parent')"><a id="Solo Parent" class="dropdown-item">Solo
                                        Parent</a></li>
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


                <div class="col-md-6 mx-auto px-0 pt-4 ">
                    <ul id="result" class="list-group list-group-hover list-group-striped">
                        @foreach($non_evacuees as $non_evacuee)
                        <li
                            class="list-group-item list-group-item-action {{ $non_evacuee->is_family_head }} {{ $non_evacuee->sectoral_classification }} ">
                            <div class="form-check">
                                <label class="form-check-label" for="name0">
                                    {{$non_evacuee->name}}
                                </label>
                                <span class="float-right my-2">
                                    @if($non_evacuee->sectoral_classification == 'Children')
                                    <div class="rounded-circle children" style="height: 10px; width:10px;"></div>
                                    @elseif($non_evacuee->sectoral_classification == 'Lactating')
                                    <div class="rounded-circle lactating" style="height: 10px; width:10px;"></div>
                                    @elseif($non_evacuee->sectoral_classification == 'Person with Disability')
                                    <div class="rounded-circle pwd" style="height: 10px; width:10px;"></div>
                                    @elseif($non_evacuee->sectoral_classification == 'Pregnant')
                                    <div class="rounded-circle pregnant" style="height: 10px; width:10px;"></div>
                                    @elseif($non_evacuee->sectoral_classification == 'Senior Citizen')
                                    <div class="rounded-circle senior" style="height: 10px; width:10px;"></div>
                                    @elseif($non_evacuee->sectoral_classification == 'Solo Parent')
                                    <div class="rounded-circle solo_parent" style="height: 10px; width:10px;"></div>
                                    @else
                                    <div class="rounded-circle none" style="height: 10px; width:10px;"></div>
                                    @endif
                                </span>
                            </div>
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
var li, li_a, li_b, li_c, li_d, li_e, li_f, li_g;
filter('all');

function filter(supply_type) {
    //var def = document.getElementById("default");
    li = document.getElementsByClassName('list-group-item');
    li_a = document.getElementsByClassName('Yes');
    li_b = document.getElementsByClassName('Children');
    li_c = document.getElementsByClassName('Lactating');
    li_d = document.getElementsByClassName('Person with Disability');
    li_e = document.getElementsByClassName('Senior Citizen');
    li_f = document.getElementsByClassName('Pregnant');
    li_g = document.getElementsByClassName('Solo Parent');

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

    if (x === 'Yes') {
        if (li_a !== null) document.getElementById('Yes').classList.add('active');
        for (var i = 0; i < li_a.length; i++) {
            if (li_a !== null) li_a[i].style.display = "";
        }
    }

    if (x === 'Children') {
        if (li_b !== null) document.getElementById('Children').classList.add('active');
        for (var i = 0; i < li_b.length; i++) {
            if (li_b !== null) li_b[i].style.display = "";
        }
    }
    if (x === 'Lactating') {
        if (li_c !== null) document.getElementById('Lactating').classList.add('active');
        for (var i = 0; i < li_c.length; i++) {
            if (li_c !== null) li_c[i].style.display = "";
        }
    }

    if (x === 'Person with Disability') {
        if (li_d !== null) document.getElementById('Person with Disability').classList.add('active');
        for (var i = 0; i < li_d.length; i++) {
            if (li_d !== null) li_d[i].style.display = "";
        }
    }

    if (x === 'Senior Citizen') {
        if (li_e !== null) document.getElementById('Senior Citizen').classList.add('active');
        for (var i = 0; i < li_e.length; i++) {
            if (li_e !== null) li_e[i].style.display = "";
        }
    }
    if (x === 'Pregnant') {
        if (li_f !== null) document.getElementById('Pregnant').classList.add('active');
        for (var i = 0; i < li_f.length; i++) {
            if (li_f !== null) li_f[i].style.display = "";
        }
    }
    if (x === 'Solo Parent') {
        if (li_g !== null) document.getElementById('Solo Parent').classList.add('active');
        for (var i = 0; i < li_g.length; i++) {
            if (li_g !== null) li_g[i].style.display = "";
        }
    }
}
</script>
<script>
$(document).ready(function() {
    $('#search-text').keyup(function() {
        var text = $(this).val();
        $.ajax({
            url: "search/non-evacuees",
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
                        .is_family_head + data.sectoral_classification + ' ">' +
                        '<div class="form-check">' +
                        '<label class="form-check-label" for="name0">' +
                        data.name +
                        '</label>' +
                        '<span class="float-right my-2">';
                    if (data.sectoral_classification == 'Children')
                        _html +=
                        '<div class="rounded-circle children" style="height: 10px; width:10px;"></div>';
                    else if (data.sectoral_classification == 'Lactating')
                        _html +=
                        '<div class="rounded-circle lactating" style="height: 10px; width:10px;"></div>';
                    else if (data.sectoral_classification ==
                        'Person with Disability')
                        _html +=
                        '<div class="rounded-circle pwd" style="height: 10px; width:10px;"></div>';
                    else if (data.sectoral_classification == 'Pregnant')
                        _html +=
                        '<div class="rounded-circle pregnant" style="height: 10px; width:10px;"></div>';
                    else if (data.sectoral_classification == 'Senior Citizen')
                        _html +=
                        '<div class="rounded-circle senior" style="height: 10px; width:10px;"></div>';
                    else if (data.sectoral_classification == 'Solo Parent')
                        _html +=
                        '<div class="rounded-circle solo_parent" style="height: 10px; width:10px;"></div>';
                    else
                        _html +=
                        '<div class="rounded-circle none" style="height: 10px; width:10px;"></div>';
                    _html += '</span>' + '</div> </li>';
                });
                $('#result').html(_html);
            }

        })
    })
})
</script>


@endsection