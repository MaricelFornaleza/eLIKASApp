@extends('layouts.verified')

@section('css')

@endsection

@section('content')

<div class="container-fluid">
    <div class="fade-in">

        <div class="row center">
            <lottie-player src="https://assets6.lottiefiles.com/packages/lf20_4qldwfx4.json" background="transparent"
                speed="1" style="width: 300px; height: 300px;" loop controls autoplay></lottie-player>

            <div class="col-lg-6  ">
                <div class="card">
                    <div class="card-header">
                        <h4 class="title">Your account was successfully verified!</h4>

                    </div>
                    <div class="card-body ">
                        <p>Subscribe to eLIKAS by providing your contact number.</p>
                        <a href="http://developer.globelabs.com.ph/dialog/oauth/LaGMsA8yBqf4RiLE4kcyzefLna59sjxK">
                            <button class="primary-btn">SUBSCRIBE</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.col-->
    </div>
    <!-- /.row-->
</div>
</div>

@endsection

@section('javascript')
<script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
@endsection