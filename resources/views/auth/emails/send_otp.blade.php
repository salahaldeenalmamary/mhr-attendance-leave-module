<x-mail::message>


Hello {{ $userName }},

You requested a password reset. Use the One-Time Password (OTP) below to reset your password. This OTP is valid for 10 minutes.

<x-mail::panel>
**{{ $otp }}**
</x-mail::panel>

If you did not request a password reset, no further action is required.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>