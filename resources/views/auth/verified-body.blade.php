@extends('layouts.verified')

@section('css')

@endsection

@section('content')

<div class="container-fluid">
    <div class="fade-in">

        <div class="row center">


            <div class="col-lg-12  ">
                <div class="col-12">
                    <lottie-player class="mx-auto" src="https://assets6.lottiefiles.com/packages/lf20_wkebwzpz.json"
                        background="#f4f7fc" speed="1" style="width: 200px; height: 200px;" loop autoplay>
                    </lottie-player>
                </div>
                <div class="col-12 card">
                    <div class="card-header mt-2">
                        <h4 class="title">Your account was successfully verified!</h4>

                    </div>
                    <div class="card-body ">
                        <p>Subscribe to eLIKAS by providing your contact number.</p>
                        <div class="col-md-4 mx-auto">
                            <a href="http://developer.globelabs.com.ph/dialog/oauth/9yk8u8xRyeHzacXandTR65HnqyEburE4">
                                <button class="btn btn-primary">SUBSCRIBE</button>
                            </a>
                        </div>

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