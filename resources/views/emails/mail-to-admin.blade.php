@component('mail::message')
# Introduction
Dear Admin,
<h3>Order No: {{ $order_info->order_number }}</h3>
<h3>Customer email: {{ $order_info->customer_email }}</h3>
<p>Text:</p>
<p>
    {{ $order_info->message_to_admin }}
</p>


Thanks,<br>
{{ config('app.name') }}
@endcomponent
