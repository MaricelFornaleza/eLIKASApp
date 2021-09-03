@extends('layouts.mobileBase')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="col-md-12 justify-content-center d-flex align-items-baseline p-0">
                    <div class="col-md-6 p-0 m-0">
                        <h5 class="font-weight-bold">List of Evacuees </h5>
                    </div>
            </div>

            <div class="col-md-12 center p-0">
                    <div class="input-group mt-4 col-md-6 p-0 m-0">
                        <!-- <span class="input-group-addon">Search</span> -->
                        <input type="text" name="search-text" id="search-text" placeholder="Search" class="form-control ">
                    </div>
            </div>

            <form method="POST" action="/camp-manager/discharge" onsubmit="return validateForm()">
            @csrf
                <div class="col-md-6 px-0 pt-4 mx-auto">
                    <ul class="list-group list-group-hover list-group-striped">
                    @foreach($family_members as $family_member)
                            <li class="list-group-item list-group-item-action ">
                                <div class="form-check">
                                    <input class="form-check-input  @error('name') is-invalid @enderror checkbox"
                                        type="checkbox" value='{{$family_member->family_code}}' id="name0"
                                        name="checkedEvacuees[]">
                                    <label class="form-check-label" for="name0">
                                        {{$family_member->name}}
                                    </label>
                                    <span class="float-right my-2">
                                        <div class="rounded-circle bg-secondary" style="height: 10px; width:10px;">
                                        </div>
                                    </span>
                                </div>
                            </li>
                    @endforeach
                    </ul>
                </div>
                <div class="col-12 center mt-5 ">
                    <div class="col-md-6 p-0 ">
                        <button class="btn  btn-accent  px-4" type="submit">{{ __('Discharge') }}</button>
                    </div>
                </div>
                <div class="col-12 center mt-4">
                    <div class="col-md-6 mb-4 p-0">
                        <a href="/camp-manager/evacuees" class="btn btn-accent-outline  px-4">
                            {{ __('Cancel') }}
                        </a>
                    </div>
                </div>
            </form>


        </div>
    </div>
</div>
@endsection