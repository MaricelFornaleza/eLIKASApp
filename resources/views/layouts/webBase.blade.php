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
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <!-- Google Fonts Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

    @yield('css')

    <!-- JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <!-- Pusher -->
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <!-- Global site tag (gtag.js) - Google Analytics-->
    <script async="" src="https://www.googletagmanager.com/gtag/js?id=UA-118965717-3"></script>
    <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());
    // Shared ID
    gtag('config', 'UA-118965717-3');
    // Bootstrap ID
    gtag('config', 'UA-118965717-5');
    </script>

    <link href="{{ asset('css/coreui-chartjs.css') }}" rel="stylesheet">
</head>



<body class="c-app">
    <div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">

        @include('partials.nav-builder')

        @include('partials.header')

        <div class="c-body">

            <main class="c-main">

                @yield('content')

            </main>

        </div>
    </div>



    <!-- CoreUI and necessary plugins-->
    <script src="{{ asset('js/coreui.bundle.min.js') }}"></script>
    <script src="{{ asset('js/coreui-utils.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.js"></script>
    @yield('javascript')




</body>

</html>