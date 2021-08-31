@extends('layouts.mobileBase')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Barangay Information  -->
            <div class="col-md-12 justify-content-between d-flex align-items-baseline p-0">
                <div class="col-7">
                    <h5 class="font-weight-bold">List of Residents </h5>
                </div>
                <!-- <div class="col-5 text-right ">
                    <a href="">
                        <button class="btn btn-secondary secondary-button px-4 ">Add new</button>
                    </a>
                </div> -->
            </div>


            <div class="col-md-6 ">
                <div class="input-group mt-4">
                    <!-- <span class="input-group-addon">Search</span> -->
                    <input type="text" name="search-text" id="search-text" placeholder="Search" class="form-control ">
                </div>
            </div>


            <form method="POST" action="/camp-manager/group-fam"  onsubmit="return validateForm()">
                <div>
                    @csrf
                    <div class="col-md-6 px-0 pt-4 ">
                        <ul class="list-group list-group-hover list-group-striped">
                            @foreach($family_members as $family_member)
                            <li class="list-group-item list-group-item-action ">
                                <div class="form-check">
                                    <input class="form-check-input  @error('name') is-invalid @enderror checkbox"
                                        type="checkbox" value='{{$family_member->id}}' id="name0" name="checkedResidents[]">
                                    <label class="form-check-label" for="name0">
                                        {{$family_member->name}}
                                    </label>
                                    <span class="float-right my-2">
                                        <div class="rounded-circle bg-secondary" style="height: 10px; width:10px;"></div>
                                    </span>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                               <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="col-12 center mt-5 ">
                        <div class="col-md-6 p-0 ">
                            <button class="btn  btn-accent  px-4" type="submit">{{ __('Next') }}</button>
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