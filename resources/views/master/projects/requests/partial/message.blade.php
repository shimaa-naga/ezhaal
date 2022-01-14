@php
        $from_user = $message->from;
    @endphp
<div class="media">
    <a class="pull-{{ \App\Help\Utility::getLangCode() == 'ar' ? 'right' : 'left' }} " href="#">
        <img width="50px" class="thumb media-object" src="@if ($from_user->image != null && file_exists(public_path($from_user->image))) {{ asset($from_user->image) }} @else {{ asset('uploads/users/user-default2.jpg') }} @endif" alt="">
    </a>
    <div class="media-body">
        <h4>{{ $from_user->name . ' ' . $from_user->last_name }} <span class="text-muted small"> - {{date("d M Y, h:i A ", strtotime($message->created_at)) }}</span></h4>
        <p>{{ $message->body }}</p>


    </div>
</div>
