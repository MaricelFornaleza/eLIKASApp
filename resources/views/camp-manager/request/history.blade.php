@extends('layouts.mobileBase')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            @if(Session::has('message'))
            <div class="alert alert-success">
                {{ Session::get('message') }}
                <button type="button" class="close align-middle" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @elseif(Session::has('error'))
            <div class="alert alert-danger">
                {{ Session::get('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Ttiel  -->
            <div class="col-md-12 justify-content-between d-flex align-items-baseline p-0">
                <div class="col-7">
                    <h4 class="font-weight-bold">Request History</h4>
                </div>
            </div>

            <div class="col-md-6 ">
                <div class="input-group mt-4">
                    <input type="text" name="search-text" id="search-text" placeholder="Search" onkeyup="searchText()"
                        class="form-control ">
                </div>
            </div>

            <div class="col-md-6 px-0 pt-4 ">
                <ul class="list-group list-group-hover list-group-striped mb-4" id="ul-parent">
                    @foreach($delivery_requests as $delivery_request)
                    <a href="/camp-manager/details/{{ $delivery_request->id }}">
                        <li class="list-group-item list-group-item-action ">
                            <div class="row">
                                <div class="col-8">
                                    <h6 class="font-weight-bold request-id">Request ID: {{ $delivery_request->id }}</h6>
                                    <small
                                        class="request-date">{{date('F d, Y, g:i a', strtotime($delivery_request->updated_at)) }}</small>
                                </div>
                                <div class="col-4">
                                    <span class="float-right ">
                                        @if( $delivery_request->status == 'pending' )
                                        <div class="badge-pill bg-secondary-accent text-center text-white"
                                            style="height: 20px; width:100px;">
                                            @elseif( $delivery_request->status == 'preparing')
                                            <div class="badge-pill bg-accent text-center text-white"
                                                style="height: 20px; width:100px;">
                                                @elseif( $delivery_request->status == 'in-transit' )
                                                <div class="badge-pill bg-secondary text-center text-white"
                                                    style="height: 20px; width:100px;">
                                                    @elseif( $delivery_request->status == 'delivered' )
                                                    <div class="badge-pill badge-primary text-center text-white"
                                                        style="height: 20px; width:100px;">
                                                        @elseif( $delivery_request->status == 'declined' ||
                                                        $delivery_request->status == 'cancelled' )
                                                        <div class="badge-pill badge-danger text-center text-white"
                                                            style="height: 20px; width:100px;">
                                                            @endif
                                                            <strong class="request-status">
                                                                @if( $delivery_request->status == 'preparing and
                                                                accepted' )
                                                                PREPARING
                                                                @else
                                                                {{ strtoupper($delivery_request->status) }}
                                                                @endif
                                                            </strong>
                                                        </div>
                                    </span>
                                </div>
                            </div>
                        </li>
                    </a>
                    @endforeach
                    {{-- <li class="list-group-item list-group-item-action ">
                        <div class="row">
                            <div class="col-8">
                                <h6 class="font-weight-bold">Request ID: 1</h6>
                                <small>July 10, 2021</small>
                            </div>
                            <div class="col-4">
                                <span class="float-right ">
                                    <div class="badge-pill bg-primary text-white text-center"
                                        style="height: 20px; width:100px;">
                                        Delivered</div>
                                </span>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item list-group-item-action ">
                        <div class="row">
                            <div class="col-8">
                                <h6 class="font-weight-bold">Request ID: 1</h6>
                                <small>July 10, 2021</small>
                            </div>
                            <div class="col-4">
                                <span class="float-right ">
                                    <div class="badge-pill badge-danger text-white text-center"
                                        style="height: 20px; width:100px;">
                                        Preparing</div>
                                </span>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item list-group-item-action ">
                        <div class="row">
                            <div class="col-8">
                                <h6 class="font-weight-bold">Request ID: 1</h6>
                                <small>July 10, 2021</small>
                            </div>
                            <div class="col-4">
                                <span class="float-right ">
                                    <div class="badge-pill bg-secondary text-white text-center"
                                        style="height: 20px; width:100px;">
                                        In-transit</div>
                                </span>
                            </div>
                        </div>
                    </li> --}}

                </ul>
            </div>



        </div>
    </div>
</div>
@endsection

@section('javascript')

<script>
function searchText() {
    var input = document.getElementById('search-text');
    var filter = input.value.toUpperCase();
    var ul = document.getElementById("ul-parent");
    var a = ul.getElementsByTagName('a');

    filter = filter.replace(/\s+/g, '');
    var reqID, date, status, a;
    for (var i = 0; i < a.length; i++) {
        //li = a[i].getElementsByTagName("li")[0];
        reqID = document.getElementsByClassName("request-id")[i].textContent.replace(/\s+/g, '');
        date = document.getElementsByClassName("request-date")[i].textContent.replace(/\s+/g, '');
        status = document.getElementsByClassName("request-status")[i].textContent.replace(/\s+/g, '');

        if (reqID.toUpperCase().includes(filter) || date.toUpperCase().includes(filter) || status.toUpperCase()
            .includes(filter)) {
            a[i].style.display = "";
        } else {
            a[i].style.display = "none";
        }
    }
}

var my_id = "{{ Auth::id() }}";
$(document).ready(function() {
    //remove on production
    Pusher.logToConsole = true;

    var pusher = new Pusher('ab82b7896a919c5e39dd', {
        cluster: 'ap1'
    });

    var channel = pusher.subscribe('requests-CM' + my_id + '-channel');
    channel.bind('deliver-event', function(data) {
        var html = "";
        if(my_id == data.recipient) {
            var result = data.delivery_requests;
            $.each(result, function(key, value) {
                for (var i = 0; i < value.length; i++) {
                    html += `<a href="/camp-manager/details/${value[i].id}">
                        <li class="list-group-item list-group-item-action ">
                            <div class="row">
                                <div class="col-8">
                                    <h6 class="font-weight-bold request-id">Request ID: ${value[i].id}</h6>
                                    <small class="request-date">` + value[i].updated_at + `</small>
                                </div>
                                <div class="col-4">
                                    <span class="float-right ">`;
                    if (value[i].status == 'pending')
                        html +=
                        `<div class="badge-pill bg-secondary-accent text-center text-white" style="height: 20px; width:100px;">`;
                    else if (value[i].status == 'preparing')
                        html +=
                        `<div class="badge-pill bg-accent text-center text-white" style="height: 20px; width:100px;">`;
                    else if (value[i].status == 'in-transit')
                        html +=
                        `<div class="badge-pill bg-secondary text-center text-white" style="height: 20px; width:100px;">`;
                    else if (value[i].status == 'delivered')
                        html +=
                        `<div class="badge-pill badge-primary text-center text-white" style="height: 20px; width:100px;">`;
                    else if (value[i].status == 'declined' || value[i].status == 'cancelled')
                        html +=
                        `<div class="badge-pill badge-danger text-center text-white" style="height: 20px; width:100px;">`;

                    // console.log(value[i].updated_at);
                    // console.log(value[i].status);
                    html += `<strong class="request-status">` + value[i].status.toUpperCase() +
                        `</strong>`;
                    html += `</div></span></div></div></li></a>`;

                }
            });
            $('#ul-parent').html(html);
        }
    });
});
</script>

@endsection