@extends('layouts.webBase')
@section('css')
<link href="{{ asset('css/disaster-response.css') }}" rel="stylesheet">

@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11 mb-2">
            <h4 class="title">
                Disaster Response Archive
            </h4>
        </div>

        <div class="col-md-11">
            @if(Session::has('message'))
            <div class="alert alert-success">{{ Session::get('message') }}
            </div>
            @endif
        </div>

        <div class="col-md-11">
            <div class="row justify-content-start">
                @empty($disaster_responses)
                No active Disaster Response
                @endempty
                @foreach($disaster_responses as $disaster_response)

                <div class="col-md-4">
                    <div class="card img-fluid">

                        <img class="card-img-top" src="{{url('/assets/dr-cover/'.$disaster_response -> photo)}}"
                            alt="{{$disaster_response->disaster_type}}" style="width:100%">
                        <a href="/disaster-response/show/{{$disaster_response->id}}">
                            <div class="card-img-overlay" style="height: 100px;">
                                <h4 class="card-title mb-4 ">{{$disaster_response->disaster_type}}</h4>
                                <h6 class="card-text mb-0">{{$disaster_response->description}}</h6>
                                <h6 class="card-text ">
                                    {{ date('F j, Y', strtotime($disaster_response->date_started)) }}
                                </h6>
                            </div>
                        </a>
                        <div class="card-footer">
                            Ended: {{ date('F j, Y', strtotime($disaster_response->date_ended)) }}
                        </div>
                    </div>
                </div>


                @endforeach

            </div>
        </div>

    </div>
</div>
@endsection