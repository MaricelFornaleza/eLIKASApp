<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>@yield('title')</title>
    <link rel="icon" sizes="57x57" href="/assets/brand/Logo-icon-blue.svg">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/primary-style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/error.css') }}" rel="stylesheet">

</head>

<body class="antialiased font-sans">
    <div class="container">
        <div class="row justify-content-center mt-5 mb-auto">

            <div class="col-md-6 ">

                <div class="col-12 center mt-2 mb-3">
                    <img src="@yield('image')" alt="error" height="250px">

                </div>
                <h2 class="pt-3 text-center">@yield('heading')</h2>

                <p class="text-muted center">@yield('message') If you think this is a mistake, kindly contact us at
                    elikasph@gmail.com.
                </p>
                <div class="row mt-5 center">
                    <a href="{{ app('router')->has('home') ? route('home') : url('/') }}">
                        <button class="btn btn-primary">
                            {{ __('Go Home') }}
                        </button>
                    </a>
                </div>



            </div>

        </div>
    </div>
</body>

</html>