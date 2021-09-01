@extends('layouts.webBase')
@section('css')
<link href="{{ asset('css/disaster-response.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="row mb-4">
                <div class=" mr-auto ml-3">
                    <a href="/disaster-response/start">
                        <button class="btn btn-danger ">
                            Start Disaster Response
                        </button>
                    </a>
                </div>
                <div class=" ml-auto mr-3">
                    <a href="/disaster-response/archive">
                        Disaster Response Archive
                    </a>
                </div>
            </div>
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
                @else

                @foreach($disaster_responses as $disaster_response)

                <div class="col-md-4">
                    <div class="card img-fluid">

                        <img class="card-img-top" src="{{url('/assets/dr-cover/'.$disaster_response -> photo)}}"
                            alt="{{$disaster_response->disaster_type}}" style="width:100%">
                        <a href="/disaster-response/show/{{$disaster_response->id}}">
                            <div class="card-img-overlay" style="height: 100px;">
                                <h4 class="card-title mb-4 ">{{$disaster_response->disaster_type}}</h4>
                                <h6 class="card-text mb-0">{{$disaster_response->description}}</h6>
                                <small class="card-text ">
                                    {{ date('F j, Y', strtotime($disaster_response->date_started)) }}
                                    @empty($disaster_response->date_ended)
                                    @else
                                    - {{ date('F j, Y', strtotime($disaster_response->date_started)) }}
                                    @endempty
                                </small>
                            </div>
                        </a>
                        <a href="/disaster-response/stop/{{$disaster_response->id}}">
                            <div class="card-footer">
                                <svg class="c-icon">
                                    <use xlink:href="/assets/icons/coreui/free-symbol-defs.svg#cui-media-stop">
                                    </use>
                                </svg> Stop Disaster Response
                            </div>
                        </a>

                    </div>
                </div>


                @endforeach
                @endempty

            </div>
        </div>

    </div>
</div>
@endsection