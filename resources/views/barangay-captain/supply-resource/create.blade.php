@extends('layouts.webBase')

@section('content')

        <div class="container-fluid">
          <div class="animated fadeIn">
            <div class="row justify-content-center">
              <div class="col-sm-12 col-md-10 col-lg-8 col-xl-6">
                <div class="card">
                    <div class="card-header">
                    <i class="fa fa-align-justify"></i> <h4>Add a Supply</h4></div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('supplies.store') }}">
                            @csrf
                           

                            <div class="row justify-content-center">
                              <div class="col-sm-12 col-md-10 col-lg-8 col-xl-6">
                                <div class="form-group row px-3">
                                  <label class="lead">Supply Type</label>
                                  <select class="form-control" aria-label=".form-select-lg example" name="supply_type" required autofocus>
                                    <option value="" selected disabled>Select</option>
                                    <option value="Food Pack">Food Pack</option>
                                    <option value="Water">Water</option>
                                    <option value="Hygiene Kit">Hygiene Kit</option>
                                    <option value="Clothes">Clothes</option>
                                    <option value="ESA">ESA</option>
                                  </select>
                                </div>
                              </div>
                              <div class="col-sm-12 col-md-10 col-lg-8 col-xl-6">
                                <div class="form-group row px-3">
                                  <label class="lead">Quantity</label>
                                  <input class="form-control" type="number" placeholder="{{ __('Enter Quantity') }}" value=0 name="quantity" required autofocus>
                                </div>
                              </div>
                            </div>

                            <div class="form-group row px-3">
                                <label class="lead">Source</label>
                                <input class="form-control" type="text" placeholder="{{ __('Enter Source') }}" name="source" required autofocus>
                            </div>
                          
 
                            <button class="btn  btn-warning" type="submit">{{ __('Submit') }}</button>
                            <a href="{{ route('supplies.create') }}" class="btn btn-outline-secondary">{{ __('Reset') }}</a> 
                        </form>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>

@endsection

@section('javascript')

@endsection