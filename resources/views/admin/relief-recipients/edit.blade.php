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
                        <form method="POST" action="{{ route('relief-recipient.update', $relief_recipient->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="form-group row px-3">
                                <label class="lead">Name<a style="color:red"> *</a></label>
                                <input class="form-control" type="text" placeholder="{{ __('Enter Name') }}" name="name" value="{{ $relief_recipient->name }}" required autofocus>
                            </div>

                            <div class="form-group row px-3">
                                <label class="lead">Address<a style="color:red"> *</a></label>
                                <input class="form-control" type="text" placeholder="{{ __('Enter Address') }}" name="address" value="{{ $relief_recipient->address }}" required autofocus>
                            </div>

                            <div class="row justify-content-center">
                              <div class="col-sm-12 col-md-10 col-lg-8 col-xl-6">
                                <div class="form-group row px-3">
                                  <label class="lead">Birthdate</label>
                                  <input class="form-control" type="date" placeholder="{{ __('Enter Birthdate') }}" name="birthdate" value="{{ $relief_recipient->birthdate }}"required autofocus>
                                </div>
                              </div>
                              <div class="col-sm-12 col-md-10 col-lg-8 col-xl-6">
                                <div class="form-group row px-3">
                                  <label class="lead">Sectoral Classification</label>
                                  <select class="form-control" aria-label=".form-select-lg example" name="sectoral_classification"  required autofocus>
                                    <option value="" disabled>Select</option>
                                    @if($relief_recipient->sectoral_classification == 'Lactating')
                                    <option value="Lactating" selected>Lactating</option>
                                    @else
                                    <option value="Lactating">Lactating</option>
                                    @endif
                                    @if($relief_recipient->sectoral_classification == 'PWD')
                                    <option value="PWD" selected>PWD</option>
                                    @else
                                    <option value="PWD">PWD</option>
                                    @endif
                                    @if($relief_recipient->sectoral_classification == 'Senior Citizen')
                                    <option value="Senior Citizen" selected>Senior Citizen</option>
                                    @else
                                    <option value="Senior Citizen">Senior Citizen</option>
                                    @endif
                                    @if($relief_recipient->sectoral_classification == 'Children')
                                    <option value="Children" selected>Children</option>
                                    @else
                                    <option value="Children">Children</option>
                                    @endif
                                    @if($relief_recipient->sectoral_classification == 'Pregnant')
                                    <option value="Pregnant" selected>Pregnant</option>
                                    @else
                                    <option value="Pregnant">Pregnant</option>
                                    @endif
                                    @if($relief_recipient->sectoral_classification == 'Solo Parent')
                                    <option value="Solo Parent" selected>Solo Parent</option>
                                    @else
                                    <option value="Solo Parent">Solo Parent</option>
                                    @endif
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
                                    @if($relief_recipient->gender == 'Female')
                                      <input class="form-check-input" type="radio" name="gender" id="radio_female" value="Female" checked required autofocus>
                                    @else
                                    <input class="form-check-input" type="radio" name="gender" id="radio_female" value="Female" required autofocus>    
                                    @endif
                                      <label class="form-check-label" for="radio_female">
                                        Female
                                      </label>
                                    </div>
                                  </div>
                                  <div class="col-sm-12 col-md-10 col-lg-8 col-xl-6">
                                    <div class="form-group row px-3">
                                    @if($relief_recipient->gender == 'Male')
                                      <input class="form-check-input" type="radio" name="gender" id="radio_male" value="Male" checked required autofocus>
                                    @else
                                      <input class="form-check-input" type="radio" name="gender" id="radio_male" value="Male" required autofocus>
                                    @endif
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
                                    @if($relief_recipient->family_representative == 'Yes')
                                      <input class="form-check-input" type="radio" name="family_representative" id="radio_yes" value="Yes" checked required autofocus>
                                    @else
                                      <input class="form-check-input" type="radio" name="family_representative" id="radio_yes" value="Yes" required autofocus>
                                    @endif
                                      <label class="form-check-label" for="radio_yes">
                                        Yes
                                      </label>
                                    </div>
                                  </div>
                                  <div class="col-sm-12 col-md-10 col-lg-8 col-xl-6">
                                    <div class="form-group row px-3">
                                    @if($relief_recipient->family_representative == 'No')
                                      <input class="form-check-input" type="radio" name="family_representative" id="radio_no" value="No" checked required autofocus  >
                                    @else
                                        <input class="form-check-input" type="radio" name="family_representative" id="radio_no" value="No"  required autofocus  >
                                    @endif
                                    
                                      <label class="form-check-label" for="radio_no">
                                        No
                                      </label>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
         
                          
 
                            <button class="btn  btn-warning" type="submit">{{ __('Save') }}</button>
                            <a href="{{ route('relief-recipient.index') }}" class="btn btn-outline-secondary">{{ __('Back') }}</a> 
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