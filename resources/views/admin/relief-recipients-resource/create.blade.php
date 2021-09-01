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
                        Add Resident

                    </div>
                    <div class="card-body ">
                        <form method="POST" action="{{ route('residents.store') }}">
                            @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="name">Name<a style="color:red"> *</a></label>
                                        <input class="form-control @error('name') is-invalid @enderror" type="text"
                                            placeholder="{{ __('Enter Name') }}" name="name" required autofocus>
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="family_code">Family Code</label>
                                        <input class="form-control @error('family_code') is-invalid @enderror"
                                            type="text" placeholder="{{ __('Enter Family Code') }}" name="family_code"
                                            autofocus>
                                        @error('family_code')
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
                                        <label for="address">Address<a style="color:red"> *</a></label>
                                        <input class="form-control @error('address') is-invalid @enderror" type="text"
                                            placeholder="{{ __('Enter Address') }}" name="address" required autofocus>
                                        @error('address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="birthdate">Birthdate</label>
                                        <input class="form-control @error('birthdate') is-invalid @enderror" type="date"
                                            placeholder="{{ __('Enter Birthdate') }}" name="birthdate" required
                                            autofocus>
                                        @error('birthdate')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="sectoral_classification">Sectoral Classification</label>
                                        <select
                                            class="form-control @error('sectoral_classification') is-invalid @enderror"
                                            aria-label=".form-select-lg example" name="sectoral_classification" required
                                            autofocus>
                                            <option value="" selected disabled>Select</option>
                                            <option value="None">None</option>
                                            <option value="Lactating">Lactating</option>
                                            <option value="PWD">PWD</option>
                                            <option value="Senior Citizen">Senior Citizen</option>
                                            <option value="Children">Children</option>
                                            <option value="Pregnant">Pregnant</option>
                                            <option value="Solo Parent">Solo Parent</option>
                                        </select>
                                        @error('sectoral_classification')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="gender">Gender</label>
                                    </div>

                                    <div class="px-3 row justify-content-start">
                                        <div class="col-sm-4">
                                            <div class="form-group row px-3">
                                                <input class="form-check-input @error('gender') is-invalid @enderror"
                                                    type="radio" name="gender" id="radio_female" value="Female" required
                                                    autofocus>
                                                <label class="form-check-label" for="radio_female">
                                                    Female
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group row px-3">
                                                <input class="form-check-input @error('gender') is-invalid @enderror"
                                                    type="radio" name="gender" id="radio_male" value="Male" checked>
                                                <label class="form-check-label" for="radio_male">
                                                    Male
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    @error('gender')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="is_family_head">Family Head</label>
                                    </div>

                                    <div class="px-3 row justify-content-start">
                                        <div class="col-sm-4">
                                            <div class="form-group row px-3">
                                                <input
                                                    class="form-check-input @error('is_family_head') is-invalid @enderror"
                                                    type="radio" name="is_family_head" id="radio_yes" value="Yes"
                                                    required autofocus>
                                                <label class="form-check-label" for="radio_yes">
                                                    Yes
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group row px-3">
                                                <input
                                                    class="form-check-input @error('is_family_head') is-invalid @enderror"
                                                    type="radio" name="is_family_head" id="radio_no" value="No" checked>
                                                <label class="form-check-label" for="radio_no">
                                                    No
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    @error('is_family_head')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mt-5 center">
                                <div class="col-4 ">
                                    <button class="btn btn-primary px-4 " type="submit">{{ __('Add') }}</button>
                                </div>
                                <div class="col-4 ">
                                    <a href="{{ route('residents.index') }}"
                                        class="btn btn-outline-primary px-4 ">{{ __('Cancel') }}</a>
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