@extends('layouts.mobileBase')

@section('content')
<div class="container">
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
                <ul class="list-group list-group-hover list-group-striped" id="ul-parent">
                    @foreach($delivery_requests as $delivery_request)
                    <a href="/camp-manager/details/{{ $delivery_request->id }}">
                        <li class="list-group-item list-group-item-action ">
                            <div class="row">
                                <div class="col-8">
                                    <h6 class="font-weight-bold" id="request-id">Request ID: {{ $delivery_request->id }}
                                    </h6>
                                    <small>{{date('F d, Y', strtotime($delivery_request->date)) }}</small>
                                </div>
                                <div class="col-4">
                                    <span class="float-right ">
                                        @if( $delivery_request->status == 'pending' )
                                        <div class="badge-pill bg-secondary-accent text-center"
                                            style="height: 20px; width:100px;">
                                            @elseif( $delivery_request->status == 'preparing' )
                                            <div class="badge-pill bg-accent text-center text-white"
                                                style="height: 20px; width:100px;">
                                                @elseif( $delivery_request->status == 'in transit' )
                                                <div class="badge-pill bg-secondary text-center text-white"
                                                    style="height: 20px; width:100px;">
                                                    @elseif( $delivery_request->status == 'Delivered' )
                                                    <div class="badge-pill badge-primary text-center text-white"
                                                        style="height: 20px; width:100px;">
                                                        @elseif( $delivery_request->status == 'declined' ||
                                                        $delivery_request->status == 'cancelled' )
                                                        <div class="badge-pill badge-danger text-center text-white"
                                                            style="height: 20px; width:100px;">
                                                            @endif
                                                            {{ strtoupper($delivery_request->status) }}
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

    for (var i = 0; i < a.length; i++) {
        var li = a[i].getElementsByTagName("li")[0];
        var txtValue = document.getElementById("request-id").textContent;
        //console.log(li);
        if (txtValue.toUpperCase().includes(filter)) {
            a[i].style.display = "";
        } else {
            a[i].style.display = "none";
        }
    }
}
</script>

@endsection