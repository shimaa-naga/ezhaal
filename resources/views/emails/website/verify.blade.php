@component('mail::message')


<h1>{{_i('Dear')}} {{$name}}, </h1>
<p>
{{_i("Thanks for joining us.")}}
</p>
<p>{{_i('Click here to verify password')}} :
    <a href="{{route('virifyLink',["token" => $token])}}">{{_i('Click here')}}</a> </p>


{{_i('Thanks')}},<br>
{{ config('app.name') }}
@endcomponent
