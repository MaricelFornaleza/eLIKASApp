@extends('layouts.mobileBase')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 my-auto">
            <!--  Title  -->
            <div class="col-md-12 justify-content-center px-0">
                <div class="col-md-6 mx-auto">
                    <h4 class="font-weight-bold">Supply</h4>
                </div>

            </div>
            <!-- Progress bars -->
            <div class="col-md-6 mx-auto my-5">
                <div class="progress-group">
                    <div class="progress-group-header">
                        <div>Food Packs</div>
                        <div class="mfs-auto font-weight-bold mr-2">{{ $stock_level->food_packs }}</div>

                        <div class="font-weight-bold">( {{ round(($stock_level->food_packs/$capacity) * 100) }} %)</div>

                    </div>
                    <div class="progress-group-bars">
                        <div class="progress progress-xs">
                            <div class="progress-bar bg-accent" role="progressbar"
                                style="width: {{ ($stock_level->food_packs/$capacity) * 100 }}%"
                                aria-valuenow="{{ ($stock_level->food_packs/$capacity) * 100 }}" aria-valuemin="0"
                                aria-valuemax="{{ $capacity }}"></div>
                        </div>
                    </div>
                </div>
                <div class="progress-group">
                    <div class="progress-group-header">
                        <div>Water</div>
                        <div class="mfs-auto font-weight-bold mr-2">{{ $stock_level->water }}</div>

                        <div class="font-weight-bold">( {{ round(($stock_level->water/$capacity) * 100) }} %)</div>

                    </div>
                    <div class="progress-group-bars">
                        <div class="progress progress-xs">
                            <div class="progress-bar bg-accent" role="progressbar"
                                style="width: {{ ($stock_level->water/$capacity) * 100 }}%"
                                aria-valuenow="{{ ($stock_level->water/$capacity) * 100 }}" aria-valuemin="0"
                                aria-valuemax="{{ $capacity }}"></div>
                        </div>
                    </div>
                </div>
                <div class="progress-group">
                    <div class="progress-group-header">
                        <div>Clothes</div>
                        <div class="mfs-auto font-weight-bold mr-2">{{ $stock_level->clothes }}</div>

                        <div class="font-weight-bold">( {{ round(($stock_level->clothes/$capacity) * 100) }} %)</div>

                    </div>
                    <div class="progress-group-bars">
                        <div class="progress progress-xs">
                            <div class="progress-bar bg-accent" role="progressbar"
                                style="width: {{ ($stock_level->clothes/$capacity) * 100 }}%"
                                aria-valuenow="{{ ($stock_level->clothes/$capacity) * 100 }}" aria-valuemin="0"
                                aria-valuemax="{{ $capacity }}"></div>
                        </div>
                    </div>
                </div>
                <div class="progress-group">
                    <div class="progress-group-header">
                        <div>Hygiene Kit</div>
                        <div class="mfs-auto font-weight-bold mr-2">{{ $stock_level->hygiene_kit }}</div>

                        <div class="font-weight-bold">( {{ round(($stock_level->hygiene_kit/$capacity) * 100) }} %)
                        </div>

                    </div>
                    <div class="progress-group-bars">
                        <div class="progress progress-xs">
                            <div class="progress-bar bg-accent" role="progressbar"
                                style="width: {{ ($stock_level->hygiene_kit/$capacity) * 100 }}%"
                                aria-valuenow="{{ ($stock_level->hygiene_kit/$capacity) * 100 }}" aria-valuemin="0"
                                aria-valuemax="{{ $capacity }}"></div>
                        </div>
                    </div>
                </div>
                <div class="progress-group">
                    <div class="progress-group-header">
                        <div>Medicine</div>
                        <div class="mfs-auto font-weight-bold mr-2">{{ $stock_level->medicine }}</div>

                        <div class="font-weight-bold">( {{ round(($stock_level->medicine/$capacity) * 100) }} %)</div>

                    </div>
                    <div class="progress-group-bars">
                        <div class="progress progress-xs">
                            <div class="progress-bar bg-accent" role="progressbar"
                                style="width: {{ ($stock_level->medicine/$capacity) * 100 }}%"
                                aria-valuenow="{{ ($stock_level->medicine/$capacity) * 100 }}" aria-valuemin="0"
                                aria-valuemax="{{ $capacity }}"></div>
                        </div>
                    </div>
                </div>
                <div class="progress-group">
                    <div class="progress-group-header">
                        <div>Emergency Shelter Assistance</div>
                        <div class="mfs-auto font-weight-bold mr-2">{{ $stock_level->emergency_shelter_assistance }}
                        </div>

                        <div class="font-weight-bold">(
                            {{ round(($stock_level->emergency_shelter_assistance/$capacity) * 100) }} %)
                        </div>

                    </div>
                    <div class="progress-group-bars">
                        <div class="progress progress-xs">
                            <div class="progress-bar bg-accent" role="progressbar"
                                style="width: {{ ($stock_level->emergency_shelter_assistance/$capacity) * 100 }}%"
                                aria-valuenow="{{ ($stock_level->emergency_shelter_assistance/$capacity) * 100 }}"
                                aria-valuemin="0" aria-valuemax="{{ $capacity }}"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- buttons -->
            <div class=" col-md-12 mx-auto">
                <div class="col-12 center mt-5 ">
                    <div class="col-md-6 p-0 ">
                        <a href="/camp-manager/request-supply">
                            <button class="btn btn-accent  px-4 ">Request Supply</button>
                        </a>
                    </div>
                </div>

                <div class="col-12 center mt-4">
                    <div class="col-md-6 mb-4 p-0">
                        <a href="/camp-manager/dispense-view">
                            <button class="btn btn-accent-outline  px-4 ">Dispense</button>
                        </a>
                    </div>
                </div>
            </div>




        </div>
    </div>
</div>
@endsection