@component('mail::message')
# successfully activated your account
Hello {{$name}}

Your certificates have been checked and we have successfully activated your account


Thanks,<br>
{{ config('app.name') }}
@endcomponent