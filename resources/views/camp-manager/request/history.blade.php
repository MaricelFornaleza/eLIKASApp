@extends('layouts.mobileBase')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Ttiel  -->
            <div class="col-md-12 justify-content-between d-flex align-items-baseline p-0">
                <div class="col-7">
                    <h5 class="font-weight-bold">Request History</h5>
                </div>
            </div>


            <div class="col-md-6 ">
                <div class="input-group mt-4">

                    <input type="text" name="search-text" id="search-text" placeholder="Search" class="form-control ">
                </div>
            </div>



            <div class="col-md-6 px-0 pt-4 ">
                <ul class="list-group list-group-hover list-group-striped">
                    <a href="/camp-manager/details">
                        <li class="list-group-item list-group-item-action ">
                            <div class="row">
                                <div class="col-8">
                                    <h6 class="font-weight-bold">Request ID: 1</h6>
                                    <small>July 10, 2021</small>
                                </div>
                                <div class="col-4">
                                    <span class="float-right ">
                                        <div class="rounded bg-secondary-accent text-white text-center"
                                            style="height: 20px; width:100px;">
                                            Pending</div>
                                    </span>
                                </div>
                            </div>
                        </li>
                    </a>
                    <li class="list-group-item list-group-item-action ">
                        <div class="row">
                            <div class="col-8">
                                <h6 class="font-weight-bold">Request ID: 1</h6>
                                <small>July 10, 2021</small>
                            </div>
                            <div class="col-4">
                                <span class="float-right ">
                                    <div class="rounded bg-primary text-white text-center"
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
                                    <div class="rounded bg-accent text-white text-center"
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
                                    <div class="rounded bg-secondary text-white text-center"
                                        style="height: 20px; width:100px;">
                                        In-transit</div>
                                </span>
                            </div>
                        </div>
                    </li>

                </ul>
            </div>



        </div>
    </div>
</div>
@endsection