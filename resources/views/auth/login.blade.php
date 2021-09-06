@extends('layouts.authBase')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4 ">
            <div class="card-group">
                <div class="card p-4">
                    <div class="card-body">

                        <h2 class="title">Welcome Back!</h2>
                        <p class="text-muted ">Log In to your account</p>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="input-group mb-3 mt-5">
                                <input class="form-control @error('email') is-invalid @enderror" type="text"
                                    placeholder="{{ __('E-Mail Address') }}" name="email" value="{{ old('email') }}"
                                    required autofocus>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="input-group mb-4">
                                <input class="form-control @error('password') is-invalid @enderror" type="password"
                                    placeholder="{{ __('Password') }}" name="password" required>
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="row mt-5">
                                <div class="col-12 center">
                                    <button class="btn btn-primary px-4 " type="submit">{{ __('Login') }}</button>
                                </div>
                            </div>
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