@component('mail::message')
# Introduction
Dear Customer,
<p>Here you can find Preview of your Product.</p>
<h3 style="text-align: center;">Please Visit</h3>
The body of your message.

@component('mail::button', ['url' => $url])
{{ $url }}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
