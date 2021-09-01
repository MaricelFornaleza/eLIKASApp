@extends('layouts.mobileBase')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Select Disaster Response -->
            <div class="form-group col-sm-6">
                <label for="disaster_response">Disaster Response</label>
                <select name="disaster_response_id" class="form-control" id="disaster_response_id">
                        <option value="">Select</option>
                        @foreach($disaster_responses as $disaster_response)
                        <option value="{{ $disaster_response->id }}">Disaster Response {{ $disaster_response->id }}</option>
                        @endforeach
                </select>

            </div>
            <!-- Barangay Information  -->

            <div class="col-md-6">
                <h5 class="font-weight-bold">Choose Family Representative </h5>
                <small>The chosen family member is the one who will receive the relief goods. </small>
            </div>
            <form method="POST" action="/camp-manager/admit"  onsubmit="return validateForm()">
                <div>
                    @csrf
                    <div class="col-md-6 px-0 pt-4 ">
                        <ul class="list-group list-group-hover list-group-striped">
                            @foreach($family_members as $family_member)
                            <li class="list-group-item list-group-item-action ">
                                <div class="form-check">
                                    <input class="form-check-input  @error('name') is-invalid @enderror radio" type="radio"
                                        value="{{$family_member->id}}" id="name0" name="selectedRepresentative">
                                    <label class="form-check-label" for="name0">
                                    {{$family_member->name}}
                                    </label>
                                    <span class="float-right my-2">
                                        <div class="rounded-circle bg-secondary" style="height: 10px; width:10px;"></div>
                                    </span>
                                </div>
                            </li>
                            <input type='hidden' value='{{ $family_member->id }}' name='selectedResidents[]'>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-12 center mt-5 ">
                        <div class="col-md-6 p-0 ">
                            <button class="btn  btn-accent  px-4" type="submit">{{ __('Admit') }}</button>
                        </div>
                    </div>
                    <div class="col-12 center mt-4">
                        <div class="col-md-6 mb-4 p-0">
                            <a href="/camp-manager/evacuees"  class="btn btn-accent-outline  px-4">
                                {{ __('Cancel') }}
                            </a>
                        </div>
                    </div>
                </div>
            </form>


        </div>
    </div>
</div>
@endsection