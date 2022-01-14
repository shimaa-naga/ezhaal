@component('mail::message')
# {{config("app.name")}}

<h1>{{_i('Dear')}}, {{ $name}}</h1>

<p>{{_i('Click here to reset password')}} : <a href="{{route('master.reset.password.token', $token)}}">{{_i('Click')}}</a> </p>


{{--@component('mail::button', ['url' => ''])--}}
{{--Button Text--}}
{{--@endcomponent--}}

{{_i('Thanks')}},<br>
{{ config('app.name') }}
@endcomponent
