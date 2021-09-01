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
            <div class="col-md-8">
                <div class="col-md-12 justify-content-between d-flex align-items-baseline p-0">
                    <div class="col-7">
                        <h5 class="font-weight-bold">Delivery Details</h5>
                    </div>
                    <div class="col-5 text-right ">
                        <span class="float-right ">
                            @if( $delivery_request->status == 'pending' )
                            <div class="badge-pill bg-secondary-accent text-center text-white" style="height: 20px; width:100px;">
                            @elseif( $delivery_request->status == 'preparing' )
                            <div class="badge-pill bg-accent text-center text-white" style="height: 20px; width:100px;">
                            @elseif( $delivery_request->status == 'in-transit' )
                            <div class="badge-pill bg-secondary text-center text-white" style="height: 20px; width:100px;">
                            @elseif( $delivery_request->status == 'delivered' )
                            <div class="badge-pill badge-primary text-center text-white" style="height: 20px; width:100px;">
                            @elseif( $delivery_request->status == 'declined' || $delivery_request->status == 'cancelled' )
                            <div class="badge-pill badge-danger text-center text-white" style="height: 20px; width:100px;">
                            @endif
                            {{ strtoupper($delivery_request->status) }}</div>
                        </span>
                    </div>
    
                </div>
                <!-- request info -->

                <div class="form-group row px-3 mt-1">
                    <div class="col-4 font-weight-bold">
                        Recipient:
                    </div>
                    <div class="col-8 ">
                        <h6>{{ $delivery_request->camp_manager_name }}</h6>
                    </div>
                </div>
                <div class="form-group row px-3 mt-3">
                    <div class="col-4 font-weight-bold">
                        Address:
                    </div>
                    <div class="col-8 ">
                        <h6>{{ $delivery_request->evacuation_center_name }}</h6>
                        <small>{{ $delivery_request->address }}</small>

                    </div>
                </div>
                <!-- Supply Info Form -->
                <div class="supply-info mt-4 mb-2">
                    <!-- title -->
                    <div class="row title px-3 mb-2 font-weight-bold ">
                        <div class="col-7">
                            Supply Type
                        </div>
                        <div class="col-5 text-right">
                            Quantity
                        </div>
                    </div>
                    <!-- food packs input -->
                    <div class="form-group row px-3 py-0 my-1 ">
                        <label class="col-7 col-form-label" for="food-qty">Food Packs</label>
                        <div class="col-5 text-right my-auto">
                            <h6>{{ $delivery_request->food_packs }}</h6>

                        </div>
                    </div>
                    <!-- Water input -->
                    <div class="form-group row px-3 py-0 my-1 ">
                        <label class="col-7 col-form-label" for="food-qty">Water</label>
                        <div class="col-5 text-right my-auto">
                            <h6>{{ $delivery_request->water }}</h6>

                        </div>
                    </div>

                    <!-- Clothes input -->
                    <div class="form-group row px-3 py-0 my-1">
                        <label class="col-7 col-form-label" for="food-qty">Clothes</label>
                        <div class="col-5 text-right my-auto">
                            <h6>{{ $delivery_request->clothes }}</h6>

                        </div>
                    </div>

                    <!-- Hygiene Kit input -->
                    <div class="form-group row px-3 py-0 my-1">
                        <label class="col-7 col-form-label" for="food-qty">Hygiene Kit</label>
                        <div class="col-5 text-right my-auto">
                            <h6>{{ $delivery_request->hygiene_kit }}</h6>

                        </div>
                    </div>

                    <!-- Medicine input -->
                    <div class="form-group row px-3 py-0 my-1">
                        <label class="col-7 col-form-label" for="food-qty">Medicine</label>
                        <div class="col-5 text-right my-auto">
                            <h6>{{ $delivery_request->medicine }}</h6>

                        </div>
                    </div>
                    <!-- Emergency Shelter Assistance input -->
                    <div class="form-group row px-3 py-0 my-1">
                        <label class="col-7 col-form-label" for="food-qty">Emergency Shelter Assistance</label>
                        <div class="col-5 text-right my-auto">
                            <h6>{{ $delivery_request->emergency_shelter_assistance }}</h6>

                        </div>
                    </div>
                    <!-- Note text Area -->
                    <div class="col-12">
                        <label for="note">Note</label>
                        <textarea class="form-control" id="note" name="note" placeholder="Write something.."
                        rows="5" disabled>{{ $delivery_request->note }}
                        </textarea>
                    </div>

                </div>

                
                <!-- Buttons -->
                <div class="">
                    @if( $delivery_request->status == "preparing")
                    <div class="col-12 center mt-5 ">
                        <div class="col-md-6 p-0 ">
                            <a href="{{ route('request.courier_accept', [ 'id' => $delivery_request->id ]) }}"
                                onclick="return confirm('Are you sure to accept the request?')">
                                <button class="btn btn-accent  px-4 ">Accept</button>
                            </a>
                        </div>
                    </div>

                    <div class="col-12 center mt-4">
                        <div class="col-md-6 mb-4 p-0">
                            <a href="{{ route('request.courier_decline', [ 'id' => $delivery_request->id ]) }}"
                                onclick="return confirm('Are you sure to decline the request?')">
                                <button class="btn btn-accent-outline  px-4 ">Decline</button>
                            </a>
                        </div>
                    </div>
                    @elseif( $delivery_request->status == "in-transit")
                    <div class="col-12 center mt-4">
                        <div class="col-md-6 mt-4 mb-4 p-0">
                            <a href="{{ route('request.cancel', [ 'id' => $delivery_request->id ]) }}"
                                onclick="return confirm('Are you sure to cancel the request?')"> 
                                <button class="btn btn-accent-outline  px-4 ">Cancel Request</button>
                            </a>
                        </div>
                    </div>
                    @else
                    <div class="col-md-6 mt-4 mb-4 p-0">
                    </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>

@endsection

@section('javascript')

@endsection