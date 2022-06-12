@component('mail::message')
# Hello {{$user->name}},
<br>
Organisation "{{$organisation->name}}" has been created.

Subscription status: "{{ ($organisation->subscribed) ? 'Subscribed' : 'Trial ends on '.$trialEnds }}"

Thanks,<br>
{{ config('app.name') }}

@endcomponent
