@extends('layouts.webBase')

@section('css')

@endsection

@section('content')

<div class="container-fluid">
    <div class="fade-in">

        <div class="row center">
            <div class="col-lg-8 ">
                <div class="card">
                    <div class="card-header">
                        Add Supply

                    </div>
                    <div class="card-body ">
                        <form method="POST" action="{{ route('supplies.store') }}">
                            @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                      <label class="lead">Supply Type</label>
                                      <select class="form-control @error('supply_type') is-invalid @enderror" aria-label=".form-select-lg example" name="supply_type" required autofocus>
                                        <option value="" selected disabled>Select</option>
                                        <option value="Food Packs">Food Packs</option>
                                        <option value="Water">Water</option>
                                        <option value="Hygiene Kit">Hygiene Kit</option>
                                        <option value="Medicine">Medicine</option>
                                        <option value="Clothes">Clothes</option>
                                        <option value="ESA">ESA</option>
                                      </select>
                                        @error('supply_type')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                           
                                <div class="col-sm-6">
                                    <div class="form-group">
                                      <label class="lead">Quantity</label>
                                      <input class="form-control @error('quantity') is-invalid @enderror" type="number" placeholder="{{ __('Enter Quantity') }}" value=0 name="quantity" required autofocus>
                                        @error('quantity')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                           
                            <!-- /.row-->
                            <div class="row">
                                
                                <div class="col-sm-12">
                                    <div class="form-group">
                                      <label class="lead">Source</label>
                                      <input class="form-control @error('source') is-invalid @enderror" type="text" placeholder="{{ __('Enter Source') }}" name="source" required autofocus>
                                        @error('source')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-5 center">
                                <div class="col-4 ">
                                    <button class="btn btn-primary px-4 " type="submit">{{ __('Add') }}</button>
                                </div>
                                <div class="col-4 ">
                                    <a href="{{ route('inventory.index') }}" class="btn btn-outline-primary px-4 "
                                        >{{ __('Cancel') }}</a>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
            <!-- /.col-->
        </div>
        <!-- /.row-->
    </div>
</div>

@endsection

@section('javascript')

@endsection