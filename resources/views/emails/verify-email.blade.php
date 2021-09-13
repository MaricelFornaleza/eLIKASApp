@component('mail::message')
# Hello {{$data['name']}},

Your registered email is {{$data['email']}} , Please click on the button below to verify
your email account

@component('mail::button', ['url' => url('user/verify', $data['remember_token'])])
Verify Email Address
@endcomponent

Thanks,<br>
{{ config('app.name') }}

@component('mail::subcopy')
Do not share this to anyone.
Information contain herein is strictly confidential.
It is intended solely for the use of the party whom it is addressed
and to others authorized to receive it. If you are not the intended recipient,
you are hereby notified that any disclosure, distribution,
or taking action in reliance to the contents of this information is strictly
prohibited.
@endcomponent
@endcomponent