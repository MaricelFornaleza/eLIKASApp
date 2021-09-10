<!DOCTYPE html>
<html lang="en">

<head>

    <title>eLIKAS</title>

    <link href="{{ asset('css/primary-style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <!-- Google Fonts Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

</head>

<body class="c-app center">
    <div class="c-body">
        <main class="c-main ">
            <div class="container-fluid">
                <div class="fade-in">

                    <div class="row center">
                        <div class="col-md-6  ">
                            <div class="card">

                                <img class="card-img-top " src="{{url('/assets/brand/Email-banner.png')}}"
                                    style="height: 150px; object-fit: cover; border-bottom: 3px solid #fb8500;">


                                <div class="card-body ">
                                    <h4 class="title">@yield('title')</h4>
                                    @yield('content')

                                    <p>Best regards,
                                        <br>
                                        @yield('admin')
                                        <br>eLIKAS
                                    </p>

                                </div>
                                <div class="card-footer">
                                    <small>
                                        Do not share this to anyone.
                                        Information contain herein is strictly confidential.
                                        It is intended solely for the use of the party whom it is addressed
                                        and to others authorized to receive it. If you are not the intended recipient,
                                        you are hereby notified that any disclosure, distribution,
                                        or taking action in reliance to the contents of this information is strictly
                                        prohibited.
                                    </small>

                                </div>

                            </div>
                        </div>

                    </div>
                    <div class="row center">
                        <small class="text-center text-muted">&copy eLIKAS 2021. All rights reserved.</small>

                    </div>

                </div>

            </div>


        </main>
    </div>
    <!-- CoreUI and necessary plugins-->
    <script src="{{ asset('js/coreui.bundle.min.js') }}"></script>
    <script src="{{ asset('js/coreui-utils.js') }}"></script>
    {{-- <script src="https://code.jquery.com/jquery-3.2.1.js"></script> --}}
    @yield('javascript')




</body>

</html>