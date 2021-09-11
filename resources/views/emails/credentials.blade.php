@component('mail::message')
# Hello {{$data['name']}},

<p>Your account was successfully verified!.
    Download the eLIKAS mobile appllication and
    login using your email address and the temporary password provided.</p>
<p>Here is your temporary password: <strong> {{$data['body']}}</strong></p>
<p>Please update your profile and provide a new password. Thank you and stay safe!</p>


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