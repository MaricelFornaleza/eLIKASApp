@extends('layouts.webBase')

@section('content')

<div class="container">
    <div class="row justify-content-center">

        <div class="col-md-6 ">

            <div class="col-12 center mt-2 mb-3">
                <img src="/assets/img/error/error-general.png" alt="error" height="250px">

            </div>
            <h2 class="pt-3 center">Hold on. Are you the Administrator?</h2>

            <p class="text-muted center">There is an existing administrator for this website. You are not allowed to
                register another account. If you think this is a mistake, kindly contact us at elikassupport@gmail.com.
            </p>
            <div class="row mt-5 center">
                <div class="col-6">
                    <a href="{{ url('login') }}">
                        <button class="btn btn-primary ">
                            Login
                        </button>
                    </a>

                </div>
                <div class="col-6">
                    <a href="#">
                        <button class="btn btn-border ">
                            Forgot Password
                        </button>
                    </a>
                </div>
            </div>



        </div>

    </div>
</div>

@endsection

@section('javascript')

@endsection