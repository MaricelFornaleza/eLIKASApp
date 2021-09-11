@extends('layouts.email')
@section('title', 'Account Credentials')
@section('content')
Hello <strong>{{ $name }}</strong>,
<p>Your account was successfully verified!.
    Download the eLIKAS mobile appllication and
    login using your email address and the temporary password provided.</p>
<p>Here is your temporary password: <strong> {{$body}}</strong></p>
<p>Please update your profile and provide a new password. Thank you and stay safe!</p>

@endsection