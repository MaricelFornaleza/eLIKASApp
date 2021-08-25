<!DOCTYPE html>

<html lang="en">

<head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="eLIKAS: An Emergency Resource Management System">
    <meta name="author" content="Maricel Fornaleza, Renier Jay Managaoang, Severino Sarate III">
    <meta name="keyword" content="elikas,Disaster Response,Emergency Resource,Emergency Resource Management System">
    <title>eLIKAS</title>
    <link rel="icon" sizes="57x57" href="assets/favicon/Logo-icon-blue.svg">
    <!-- Icons-->
    <link href="{{ asset('css/free.min.css') }}" rel="stylesheet"> <!-- icons -->
    <link href="{{ asset('css/flag-icon.min.css') }}" rel="stylesheet"> <!-- icons -->
    <!-- Main styles for this application-->
    <link href="{{ asset('css/primary-style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/mobile.css') }}" rel="stylesheet">
    <!-- JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <!-- Pusher -->
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>


    @yield('css')

    <link href="{{ asset('css/coreui-chartjs.css') }}" rel="stylesheet">
</head>

<body class="c-app">
    @include('partials.mobileHeader')
    <div class="c-body mobile">
        <main class="c-main">
            @yield('content')
        </main>
    </div>
    <!-- CoreUI and necessary plugins-->
    <script src="{{ asset('js/coreui.bundle.min.js') }}"></script>
    <script src="{{ asset('js/coreui-utils.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.js"></script>

    @yield('javascript')
</body>

</html>