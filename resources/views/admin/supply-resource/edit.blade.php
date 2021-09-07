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
                        Edit Supply

                    </div>
                    <div class="card-body ">
                        <form method="POST" action="{{ route('supplies.update', $supply->id) }}">
                            @csrf
                            @method('PUT')
                            
                            <!-- /.row-->
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                      <label class="lead">Supply Type</label>
                                      <select class="form-control" aria-label=".form-select-lg example" name="supply_type"  required autofocus>
                                        <option value="" disabled>Select</option>
                                        @if($supply->supply_type == 'Food Pack')
                                        <option value="Food Packs" selected>Food Packs</option>
                                        @else
                                        <option value="Food Packs">Food Packs</option>
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
                                        @if($supply->supply_type == 'Medicine')
                                        <option value="Medicine" selected>Medicine</option>
                                        @else
                                        <option value="Medicine">Medicine</option>
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
                                <div class="form-group col-sm-6">
                                  <label class="lead">Quantity</a></label>
                                  <input class="form-control" type="number" placeholder="{{ __('Enter Quantity') }}" name="quantity" value="{{ $supply->quantity }}" required autofocus>
                                </div>
                            </div>
                            <!-- /.row-->
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                      <label class="lead">Source</label>
                                      <input class="form-control" type="text" placeholder="{{ __('Enter Source') }}" name="source" value="{{ $supply->source }}" required autofocus>
                                  </div>
                                </div>
                            </div>
                            
                            <div class="row mt-5 center">
                                <div class="col-4 ">
                                    <button class="btn btn-primary px-4 " type="submit">{{ __('Update') }}</button>
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

