@component('mail::message')

<img src="{{$by->profilePhoto}}" width="50px" class="pull_left"> {{$by->name}}

<h1>{{_i('Dear')}} {{$ticket->authorDetails->first()->name}}, </h1>
<p>
{{_i("Regarding to your ticket")}} : {{$ticket->title}}
</p>

{{$reply}}


{{_i('Thanks')}},<br>
{{ config('app.name') }}
@endcomponent
