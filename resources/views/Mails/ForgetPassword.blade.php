@component('mail::message')
# Introduction
{{-- Hello  : {{$name}} --}}

Copy This Code And paste It In  Fastworld To Reset Your Password

{{$token}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent