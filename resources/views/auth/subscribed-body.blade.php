@extends('layouts.verified')

@section('css')

@endsection

@section('content')

<div class="container-fluid">
    <div class="fade-in">

        <div class="row center">
            <div class="col-lg-6  ">
                <div class="col-12 px-auto">
                    <lottie-player src="https://assets6.lottiefiles.com/packages/lf20_wkebwzpz.json"
                        background="#f4f7fc" speed="1" style="width: 200px; height: 200px;" loop autoplay>
                    </lottie-player>
                </div>
                <div class="col-12 card">
                    <div class="card-header">
                        <h4 class="title">Your are now subscribed to eLIKAS!</h4>

                    </div>
                    <div class="card-body ">
                        <p>We sent you an email regarding your account details. Download the eLIKAS mobile appllication
                            and login using your credentials provided.</p>
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