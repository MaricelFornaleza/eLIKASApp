@extends('layouts.mobileBase')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!--  Title  -->
            <div class="col-md-12 justify-content-between d-flex align-items-baseline p-0">
                <div class="col-md-6">
                    <h4 class="font-weight-bold">Supply</h4>
                </div>

            </div>
            <!-- Progress bars -->
            <div class="col-md-6 mb-5 mt-5">
                <div class="progress-group">
                    <div class="progress-group-header">
                        <div>Food Packs</div>
                        <div class="mfs-auto font-weight-bold mr-2">{{ $stock_level->food_packs }}</div>
                        @if($total_number_of_evacuees == 0)
                        <div class="font-weight-bold">( {{ round(($stock_level->food_packs/$capacity) * 100) }} %)</div>
                        @elseif($total_number_of_evacuees < $stock_level->food_packs)
                        <div class="font-weight-bold">(100%)
                        </div>
                        @else
                        <div class="font-weight-bold">(
                            {{ round(($stock_level->food_packs/$total_number_of_evacuees) * 100) }} %)
                        </div>
                        @endif
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
                        @if($total_number_of_evacuees == 0)
                        <div class="font-weight-bold">( {{ round(($stock_level->water/$capacity) * 100) }} %)</div>
                        @elseif($total_number_of_evacuees < $stock_level->water)
                        <div class="font-weight-bold">(100%)
                        </div>
                        @else
                        <div class="font-weight-bold">(
                            {{ round(($stock_level->water/$total_number_of_evacuees) * 100) }} %)
                        </div>
                        @endif
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
                        @if($total_number_of_evacuees == 0)
                        <div class="font-weight-bold">( {{ round(($stock_level->clothes/$capacity) * 100) }} %)</div>
                        @elseif($total_number_of_evacuees < $stock_level->clothes)
                        <div class="font-weight-bold">(100%)
                        </div>
                        @else
                        <div class="font-weight-bold">(
                            {{ round(($stock_level->clothes/$total_number_of_evacuees) * 100) }} %)
                        </div>
                        @endif
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
                        @if($total_number_of_evacuees == 0)
                        <div class="font-weight-bold">( {{ round(($stock_level->hygiene_kit/$capacity) * 100) }} %)</div>
                        @elseif($total_number_of_evacuees < $stock_level->hygiene_kit)
                        <div class="font-weight-bold">(100%)
                        </div>
                        @else
                        <div class="font-weight-bold">(
                            {{ round(($stock_level->hygiene_kit/$total_number_of_evacuees) * 100) }} %)
                        </div>
                        @endif
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
                        @if($total_number_of_evacuees == 0)
                        <div class="font-weight-bold">( {{ round(($stock_level->medicine/$capacity) * 100) }} %)</div>
                        @elseif($total_number_of_evacuees < $stock_level->medicine)
                        <div class="font-weight-bold">(100%)
                        </div>
                        @else
                        <div class="font-weight-bold">(
                            {{ round(($stock_level->medicine/$total_number_of_evacuees) * 100) }} %)
                        </div>
                        @endif
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
                        @if($total_number_of_evacuees == 0)
                        <div class="font-weight-bold">( {{ round(($stock_level->emergency_shelter_assistance/$capacity) * 100) }} %)</div>
                        @elseif($total_number_of_evacuees < $stock_level->emergency_shelter_assistance)
                        <div class="font-weight-bold">(100%)
                        </div>
                        @else
                        <div class="font-weight-bold">(
                            {{ round(($stock_level->emergency_shelter_assistance/$total_number_of_evacuees) * 100) }} %)
                        </div>
                        @endif
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
            <div class="fixed-bottom col-md-6">
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