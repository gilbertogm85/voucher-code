@component('mail::message')
{{$user->name}}<br><br>

A voucher was generated to you and there is the information about it:<br><br>

Special Offer: "{{$special_offer->name}}".<br><br>
Discount: {{$special_offer->discount}}%<br>
Voucher Code: {{$voucher->code}}<br>


We hope you enjoy your discount!<br>
<a href="{{url('/')}}">{{url('/')}}</a><br><br>
Equipe {{ config('app.name', 'Laravel') }}
@endcomponent
