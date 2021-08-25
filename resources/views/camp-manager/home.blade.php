@extends('layouts.mobileBase')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h4>Active Disaster Response</h4>
            <div class="row justify-content-start">
                @foreach($disaster_responses as $disaster_response)
                <div class="col-md-4">
                    <div class="card img-fluid">
                        <img class="card-img-top" src="{{url('/assets/dr-cover/'.$disaster_response -> photo)}}"
                            alt="{{$disaster_response->disaster_type}}" style="height:100px; object-fit: cover;">
                        <a href="/camp-manager/evacuation-center">
                            <div class="card-img-overlay text-white" style="height: 75px; ">
                                <h4 class=" card-title mb-4 ">{{$disaster_response->disaster_type}}</h4>
                                <h6 class=" card-text mb-0">{{$disaster_response->description}}</h6>
                                <h6 class="card-text ">
                                    {{ date('F j, Y', strtotime($disaster_response->date_started)) }}
                                </h6>
                            </div>
                        </a>


                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </div>
</div>
@endsection