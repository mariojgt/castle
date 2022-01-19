@component('mail::message')
# Verification Required

Please enter the code bellow to verify your email address.

<strong>{!! $code !!}</strong>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
