@extends('layouts.webBase')

@section('content')

        <div class="container-fluid">
          <div class="animated fadeIn">
            <div class="row justify-content-center">
              <div class="col-sm-12 col-md-10 col-lg-8 col-xl-6">
                <div class="card">
                    <div class="card-header">
                    <i class="fa fa-align-justify"></i> <h4>Edit a Supply</h4></div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('supplies.update', $supply->id) }}">
                            @csrf
                            @method('PUT')
                            
                            <div class="row justify-content-center">
                              
                              <div class="col-sm-12 col-md-10 col-lg-8 col-xl-6">
                                <div class="form-group row px-3">
                                  <label class="lead">Supply Type</label>
                                  <select class="form-control" aria-label=".form-select-lg example" name="supply_type"  required autofocus>
                                    <option value="" disabled>Select</option>
                                    @if($supply->supply_type == 'Food Pack')
                                    <option value="Food Pack" selected>Food Pack</option>
                                    @else
                                    <option value="Food Pack">Food Pack</option>
                                    @endif
                                    @if($supply->supply_type == 'Water')
                                    <option value="Water" selected>Water</option>
                                    @else
                                    <option value="Water">Water</option>
                                    @endif
                                    @if($supply->supply_type == 'Hygiene Kit')
                                    <option value="Hygiene Kit" selected>Hygiene Kit</option>
                                    @else
                                    <option value="Hygiene Kit">Hygiene Kit</option>
                                    @endif
                                    @if($supply->supply_type == 'Clothes')
                                    <option value="Clothes" selected>Clothes</option>
                                    @else
                                    <option value="Clothes">Clothes</option>
                                    @endif
                                    @if($supply->supply_type == 'ESA')
                                    <option value="ESA" selected>ESA</option>
                                    @else
                                    <option value="ESA">ESA</option>
                                    @endif
                                  </select>
                                </div>
                              </div>
                              <div class="col-sm-12 col-md-10 col-lg-8 col-xl-6">
                                <div class="form-group row px-3">
                                  <label class="lead">Quantity</a></label>
                                  <input class="form-control" type="text" placeholder="{{ __('Enter Quantity') }}" name="quantity" value="{{ $supply->quantity }}" required autofocus>
                                </div>
                              </div>
                            </div>

                            <div class="form-group row px-3">
                                <label class="lead">Source</label>
                                <input class="form-control" type="text" placeholder="{{ __('Enter Source') }}" name="source" value="{{ $supply->source }}" required autofocus>
                            </div>
                          
         
                          
 
                            <button class="btn  btn-warning" type="submit">{{ __('Save') }}</button>
                            <a href="{{ route('inventory.index') }}" class="btn btn-outline-secondary">{{ __('Back') }}</a> 
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