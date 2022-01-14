<div class="media mb-3">
    @php
        $from_user = $message->from;
    @endphp
    <img class="rounded-circle mr-3 mail-img shadow" alt="media image" width="50" height="50" src="@if ($from_user->image != null && file_exists(public_path($from_user->image))) {{ asset($from_user->image) }} @else {{ asset('uploads/users/user-default2.jpg') }} @endif">
    <div class="media-body">

        <h5 class="text-primary m-0">{{ $from_user->name . ' ' . $from_user->last_name }}</h5>
        <small class="text-muted">{{ _i('From') }} : {{ $from_user->email }}</small>
        <div class="media-meta">{{ date('d M Y, h:i A ', strtotime($message->created_at)) }}</div>
        <p><b>{{ $message->subject }}</b></p>
        <p>{{ $message->body }}</p>
    </div>
</div> <!-- media -->
