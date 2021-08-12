@extends('layouts.webBase')

@section('css')
<link href="{{ asset('css/chat.css') }}" rel="stylesheet">
@endsection

@section('content')

<div class="container-fluid">
    <div class="fade-in">
        <div class="row">
            <div class="col-md-8" id="messages">


            </div>
            <div class="col-md-4">
                <div class="user-wrapper">
                    <ul class="users">
                        @foreach($users as $user)
                        <li class="user" id="{{ $user->id }}">
                            <span class="pending">1</span>
                            <div class="media">
                                <div class="media-left">
                                    <img src="public/images/{{$user->photo}}" alt="user-avatar" class="media-object">
                                </div>
                                <div class="media-body">
                                    <p class="name">{{$user->name}}</p>
                                    <p class="email"> {{$user->email}}</p>

                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>

                </div>
            </div>

        </div>


    </div>
</div>

@endsection

@section('javascript')
<script>
var recipient_id = '';
var my_id = "{{ Auth::id() }}";
$(document).ready(function() {
    $('.user').click(function() {
        $('.user').removeClass('active');
        $(this).addClass('active');
        recipient_id = $(this).attr('id');

        $.ajax({
            type: "get",
            url: "chat/" + recipient_id,
            data: "",
            cache: false,
            success: function(data) {
                $('#messages').html(data);
            }

        });
    });
    $(document).on('keyup', '.input-text input', function(e) {
        var message = $(this).val();
        //check of enter key is pressed and message is not empty and recipient is selected
        if (e.keyCode == 13 && message != '' && recipient_id != '') {
            $(this).val('');
            var datastr = "recipient_id=" + recipient_id + "messages=" + message;
            $.ajax({
                type: "post",
                url: "chat",
                data: datastr,
                cache: false,
                success: function(data) {

                },
                error: function(jqXHR, status, err) {

                },
                complete: function() {

                }
            })
        }
    });

});
</script>
@endsection