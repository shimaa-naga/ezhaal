<div class="table-responsive" >
    <table class="table">
        <tbody>
        @forelse($messages as $message)
            <tr @if($message->read_at==null) class="read"@endif >
                {{-- <td class="action">
                    <a class="delmessage" href="{{route('website.message.destroy', $message->id)}}" title="{{_i('Delete message')}}"><i class="fa fa-trash-o"></i></a>
                </td> --}}
                <td class="action">
                    <a href="{{route('website.message.read', $message->id)}}" title="{{_i('Show message')}}">
                        <i class="fa @if($message->read_at==null) fa-eye-slash @else fa-eye @endif"></i>
                    </a>
                </td>
                <td class="name"><a href="{{route('website.message.read', $message->id)}}">{{$message->from->name." ".$message->from->last_name}}</a></td>
                <td class="subject"><a href="{{route('website.message.read', $message->id)}}">{{$message->subject}} </a></td>
                <td class="time">{{date("d M Y, h:i A ", strtotime($message->created_at)) }}</td>
            </tr>
        @empty
            <tr>
                <td class="action">{{ _i('There are no new messages') }}</td>
            </tr>
        @endforelse

        </tbody>
    </table>
</div>
{{ $messages->appends(Request::except('page'))->links() }}

