@component('mail::message')
# Verification Required

Please enter the code bellow to verify your email address.

<h1><strong>{!! $code !!}</strong></h1>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
