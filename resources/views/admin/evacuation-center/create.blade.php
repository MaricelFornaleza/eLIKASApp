@extends('layouts.webBase')

@section('css')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="crossorigin=""></script>

<style>
#mapid {
    height: 75vh;
}
</style>

@endsection('css')

@section('content')

        <div class="container-fluid">
          <div class="animated fadeIn">
            <div class="row justify-content-center">
              <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="card">
                    <div class="card-header">
                    <i class="fa fa-align-justify"></i> <h4>Add an Evacuation Center</h4></div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('evac.store') }}">
                            @csrf
                           
                            <div class="form-group row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group row px-3">
                                        <label class="lead">Name of the Evacuation Center</label>
                                        <input class="form-control" type="text" placeholder="{{ __('Enter evacuation center name') }}" name="name" required autofocus>
                                    </div>

                                    <div class="form-group row px-3">
                                        <label class="lead">Address</label>
                                        <input class="form-control" type="text" placeholder="{{ __('Enter evacuation center address') }}" name="address" required autofocus>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-12">
                                            <div class="form-group row px-3">
                                                <label class="lead">Camp Manager</label>
                                                <input class="form-control" type="text" placeholder="{{ __('Enter name') }}" name="camp_manager" required autofocus>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-6 col-lg-8 col-xl-12">
                                            <div class="form-group row px-3">
                                                <label class="lead">Capacity</label>
                                                <input class="form-control" type="number" placeholder="{{ __('Enter Capacity') }}" value=0 name="capacity" required autofocus>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row px-3">
                                        <label class="lead" for="characteristics">Other Characteristics</label>
                                        <textarea class="form-control" id="characteristics" name="characteristics" rows="5" placeholder="Enter evacuation center characteristics" required autofocus></textarea>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-6">
                                    <div class="w-100 " id="mapid" name="coordinates"></div>
                                </div>
                            </div>
 
                            <button class="btn  btn-warning" type="submit">{{ __('Submit') }}</button>
                            <a href="{{ route('evac.create') }}" class="btn btn-outline-secondary">{{ __('Reset') }}</a> 
                        </form>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>

@endsection

@section('javascript')
<script src="{{ asset('js/map-js/maps-functions.js') }}"></script>
<script src="{{ asset('js/map-js/leaflet-maps-simplified.js') }}"></script>
@endsection