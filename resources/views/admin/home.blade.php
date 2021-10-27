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
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
        </div>
        <div class="col-md-11">
            @if(Session::has('error'))
            <div class="alert alert-danger">{{ Session::get('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
        </div>

        <div class="col-md-11">
            <div class="row justify-content-start">
                @if($disaster_responses->count() == 0)
                <img class="" src="{{ url('/assets/brand/No-active-dr.svg') }}" style="width:100%">
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
                        <div class="card-footer ">
                            <button type="button" class="btn-borderless text-danger " id="button" data-toggle="modal"
                                data-target="#stop" data-type="{{$disaster_response->disaster_type}}">
                                <svg class="c-icon">
                                    <use xlink:href="/assets/icons/coreui/free-symbol-defs.svg#cui-media-stop">
                                    </use>
                                </svg> Stop Disaster Response
                            </button>

                        </div>
                        <div class="modal fade" id="stop" data-backdrop="static" data-keyboard="false" tabindex="-1"
                            aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-danger text-white">
                                        <h5 class="modal-title" id="staticBackdropLabel">Stop Disaster Response</h5>
                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <form method="POST" action="/disaster-response/stop/{{$disaster_response->id}}">
                                        @csrf
                                        <div class="modal-body">
                                            Are you sure to stop <strong id="dr"></strong> ?
                                            <br>
                                            <small class="text-danger"> This action cannot be undone.</small>
                                            <div class="mt-3">


                                                <label for="status" class="col-form-label small ">Password:</label>
                                                <div class="input-group ">

                                                    <input class="form-control @error('password') is-invalid @enderror"
                                                        type="password" placeholder="{{ __('Enter your password') }}"
                                                        name="password" required autofocus>
                                                    @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>


                                            </div>


                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-danger">Yes, proceed.</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- <a href="/disaster-response/stop/{{$disaster_response->id}}">
                            <div class="card-footer">
                                <svg class="c-icon">
                                    <use xlink:href="/assets/icons/coreui/free-symbol-defs.svg#cui-media-stop">
                                    </use>
                                </svg> Stop Disaster Response
                            </div>
                        </a> -->

                    </div>
                </div>


                @endforeach
                @endempty

            </div>
        </div>

    </div>
</div>
@endsection