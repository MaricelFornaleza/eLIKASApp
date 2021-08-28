@extends('layouts.mobileBase')

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
@endsection

@section('content')

<div class="container-fluid">
    <div class="fade-in">
        <div class="row center">
            <div class="col-md-8">

                <!-- request info -->

                <div class="form-group row px-3 mt-3">
                    <div class="col-4 font-weight-bold">
                        Recipient:
                    </div>
                    <div class="col-8 ">
                        <h6>Quantity</h6>
                    </div>
                </div>
                <div class="form-group row px-3 mt-3">
                    <div class="col-4 font-weight-bold">
                        Address:
                    </div>
                    <div class="col-8 ">
                        <h6>Del Rosario Elementary School</h6>
                        <small>Del Rosario, Naga City</small>

                    </div>
                </div>
                <!-- Supply Info Form -->
                <div class="supply-info mt-5 mb-2">
                    <!-- title -->
                    <div class="row title px-3 font-weight-bold ">
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
                            <h6>200</h6>

                        </div>
                    </div>
                    <!-- Water input -->
                    <div class="form-group row px-3 py-0 my-1 ">
                        <label class="col-7 col-form-label" for="food-qty">Water</label>
                        <div class="col-5 text-right my-auto">
                            <h6>200</h6>

                        </div>
                    </div>

                    <!-- Clothes input -->
                    <div class="form-group row px-3 py-0 my-1">
                        <label class="col-7 col-form-label" for="food-qty">Clothes</label>
                        <div class="col-5 text-right my-auto">
                            <h6>200</h6>

                        </div>
                    </div>

                    <!-- Hygiene Kit input -->
                    <div class="form-group row px-3 py-0 my-1">
                        <label class="col-7 col-form-label" for="food-qty">Hygiene Kit</label>
                        <div class="col-5 text-right my-auto">
                            <h6>200</h6>

                        </div>
                    </div>

                    <!-- Medicine input -->
                    <div class="form-group row px-3 py-0 my-1">
                        <label class="col-7 col-form-label" for="food-qty">Medicine</label>
                        <div class="col-5 text-right my-auto">
                            <h6>200</h6>

                        </div>
                    </div>
                    <!-- Emergency Shelter Assistance input -->
                    <div class="form-group row px-3 py-0 my-1">
                        <label class="col-7 col-form-label" for="food-qty">Emergency Shelter Assistance</label>
                        <div class="col-5 text-right my-auto">
                            <h6>200</h6>

                        </div>
                    </div>
                    <!-- Note text Area -->
                    <div class="col-12">
                        <label for="note">Note</label>
                        <textarea id="note" name="note" placeholder="Write something.."
                            style="width:100%; height:100px;"></textarea>

                    </div>



                </div>
                <!-- Buttons -->
                <div class="">
                    <div class="col-12 center mt-5 ">
                        <div class="col-md-6 p-0 ">
                            <a href="">
                                <button class="btn btn-accent  px-4 ">Accept</button>
                            </a>
                        </div>
                    </div>
                    <div class="col-12 center mt-4">
                        <div class="col-md-6 mb-4 p-0">
                            <a href="">
                                <button class="btn btn-accent-outline  px-4 ">Cancel</button>
                            </a>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>

@endsection

@section('javascript')

@endsection