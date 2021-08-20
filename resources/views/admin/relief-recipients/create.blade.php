@extends('layouts.webBase')

@section('content')

        <div class="container-fluid">
          <div class="animated fadeIn">
            <div class="row justify-content-center">
              <div class="col-sm-12 col-md-10 col-lg-8 col-xl-6">
                <div class="card">
                    <div class="card-header">
                    <i class="fa fa-align-justify"></i> <h4>Add a Resident</h4></div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('relief-recipient.store') }}">
                            @csrf
                            <div class="form-group row px-3">
                                <label class="lead">Name<a style="color:red"> *</a></label>
                                <input class="form-control" type="text" placeholder="{{ __('Enter Name') }}" name="name" required autofocus>
                            </div>

                            <div class="form-group row px-3">
                                <label class="lead">Address<a style="color:red"> *</a></label>
                                <input class="form-control" type="text" placeholder="{{ __('Enter Address') }}" name="address" required autofocus>
                            </div>

                            <div class="row justify-content-center">
                              <div class="col-sm-12 col-md-10 col-lg-8 col-xl-6">
                                <div class="form-group row px-3">
                                  <label class="lead">Birthdate</label>
                                  <input class="form-control" type="date" placeholder="{{ __('Enter Birthdate') }}" name="birthdate" required autofocus>
                                </div>
                              </div>
                              <div class="col-sm-12 col-md-10 col-lg-8 col-xl-6">
                                <div class="form-group row px-3">
                                  <label class="lead">Sectoral Classification</label>
                                  <select class="form-control" aria-label=".form-select-lg example" name="sectoral_classification" required autofocus>
                                    <option value="" selected disabled>Select</option>
                                    <option value="Lactating">Lactating</option>
                                    <option value="PWD">PWD</option>
                                    <option value="Senior Citizen">Senior Citizen</option>
                                    <option value="Children">Children</option>
                                    <option value="Pregnant">Pregnant</option>
                                    <option value="Solo Parent">Solo Parent</option>
                                  </select>
                                </div>
                              </div>
                            </div>

                            <div class="row justify-content-center">
                              <div class="col-sm-12 col-md-10 col-lg-8 col-xl-6">
                                <div class="form-group row px-3">
                                  <label class="lead">Gender</label>
                                </div>
                                <div class="px-3 row justify-content-center">
                                  <div class="col-sm-12 col-md-10 col-lg-8 col-xl-6">
                                    <div class="form-group row px-3">
                                      <input class="form-check-input" type="radio" name="gender" id="radio_female" value="Female" required autofocus>
                                      <label class="form-check-label" for="radio_female">
                                        Female
                                      </label>
                                    </div>
                                  </div>
                                  <div class="col-sm-12 col-md-10 col-lg-8 col-xl-6">
                                    <div class="form-group row px-3">
                                      <input class="form-check-input" type="radio" name="gender" id="radio_male" value="Male" checked>
                                      <label class="form-check-label" for="radio_male">
                                        Male
                                      </label>
                                    </div>
                                  </div>
                                </div>
                              </div>

                              <div class="col-sm-12 col-md-10 col-lg-8 col-xl-6">
                                <div class="form-group row px-3">
                                  <label class="lead">Family Representative</label>
                                </div>
                                <div class="px-3 row justify-content-center">
                                  <div class="col-sm-12 col-md-10 col-lg-8 col-xl-6">
                                    <div class="form-group row px-3">
                                      <input class="form-check-input" type="radio" name="family_representative" id="radio_yes" value="Yes" required autofocus>
                                      <label class="form-check-label" for="radio_yes">
                                        Yes
                                      </label>
                                    </div>
                                  </div>
                                  <div class="col-sm-12 col-md-10 col-lg-8 col-xl-6">
                                    <div class="form-group row px-3">
                                      <input class="form-check-input" type="radio" name="family_representative" id="radio_no" value="No" checked  >
                                      <label class="form-check-label" for="radio_no">
                                        No
                                      </label>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
         
                          
 
                            <button class="btn  btn-warning" type="submit">{{ __('Submit') }}</button>
                            <a href="{{ route('relief-recipient.create') }}" class="btn btn-outline-secondary">{{ __('Reset') }}</a> 
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