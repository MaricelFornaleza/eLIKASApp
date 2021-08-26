@extends('layouts.mobileBase')

@section('css')

@endsection

@section('content')

<div class="container-fluid">
    <div class="fade-in">

        <div class="row center">
            <div class="col-lg-8  ">

                <!-- Title  -->
                <div class="col-md-12 justify-content-between d-flex align-items-baseline p-0 mb-4">
                    <div class="col-7">
                        <h5 class="font-weight-bold">Add Supply</h5>
                    </div>

                </div>

                <div class="col-md-6">
                    <form method="POST" action="{{ route('supplies.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Supply Type</label>
                                    <select class="form-control @error('supply_type') is-invalid @enderror"
                                        aria-label=".form-select-lg example" name="supply_type" required autofocus>
                                        <option value="" selected disabled>Select</option>
                                        <option value="Food Pack">Food Pack</option>
                                        <option value="Water">Water</option>
                                        <option value="Hygiene Kit">Hygiene Kit</option>
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
                                    <label>Quantity</label>
                                    <input class="form-control @error('quantity') is-invalid @enderror" type="number"
                                        placeholder="{{ __('Enter Quantity') }}" value=0 name="quantity" required
                                        autofocus>
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
                                    <label>Source</label>
                                    <input class="form-control @error('source') is-invalid @enderror" type="text"
                                        placeholder="{{ __('Enter Source') }}" name="source" required autofocus>
                                    @error('source')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mt-5 center">
                            <div class="col-md-12 mt-4">
                                <button class="btn btn-primary px-4 " type="submit">{{ __('Add') }}</button>
                            </div>
                            <div class="col-md-12 mt-4 ">
                                <a href="{{ route('inventory.index') }}"
                                    class="btn btn-outline-primary px-4 ">{{ __('Cancel') }}</a>
                            </div>
                        </div>
                    </form>

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