<ul class="list-group list-group-flush">
    @forelse($notifications as $notification)
        @if ($loop->first)
            <li class="list-group-item">
                <form class="readform" style="display: inline" action="notifications/read" method="post">
                    @csrf
                    <button type="submit" class="btn btn-success btn-xs">{{ _i('Mark All') }}</button>
                </form>
                <form class="delform" style="display: inline" action="notifications/delete" method="DELETE">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-xs">{{ _i('Delete All') }}
                    </button>
                </form>


            </li>
        @endif
        <li class="list-group-item "> [{{ $notification->created_at }}]
            <span class="spn {{ $notification->read_at == null ? 'font-weight-bold' : '' }}">
                {!! App\Help\Notification::Get($notification) !!}
            </span>
            <div class="pull-right ">
                @if ($notification->read_at == null)
                    <form class="readform" style="display: inline" action="notifications/{{ $notification->id }}/read"
                        method="post">
                        @csrf
                        <button type="submit" class="btn btn-success btn-xs"><i class=" fa fa-check"></i></button>
                    </form>
                @endif
                <form class="delform" style="display: inline" action="notifications/{{ $notification->id }}/delete"
                    method="DELETE">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-xs"><i class=" fa fa-trash-o"></i>
                    </button>
                </form>

            </div>
        </li>


    @empty
        <li class="list-group-item">{{ _i('There are no new notifications') }} </li>
    @endforelse
</ul>
