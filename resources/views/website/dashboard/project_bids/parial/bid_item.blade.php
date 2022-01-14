<div class="media border-bottom mt-0 mb-3">
    <div class="d-flex mr-3">
        <a href="#"> <img class="media-object brround" alt="64x64"
                src="{{ $item->freelancer()->image == '' ? asset('uploads/users/user-default2.jpg') : asset($item->freelancer()->image) }}">
        </a>
    </div>
    <div class="media-body">
        <h5 class="mt-0 mb-1 font-weight-semibold"> {{ $item->Freelancer()->name }}

            <span class="fs-14 ml-0" data-toggle="tooltip" data-placement="top" title="verified"><i
                    class="fa fa-check-circle-o text-success"></i></span>

        </h5>
        <small class="text-muted"><i class="fa fa-hourglass"></i> {{ $item->duration }}
            {{ _i('days') }}<i class=" ml-3 fa fa-clock-o"></i>
            {{ Carbon\Carbon::parse($item->created_at)->diffforhumans() }}
            <i class=" ml-3 fa fa-money"></i> {{ $item->price }} {{ \App\Help\Settings::getCurrency() }}</small>
        <p class="font-13  mb-2 mt-2">
            {{ Illuminate\Support\Str::words(strip_tags($item->description), 100, '..') }}
        </p>

@auth
        @if ( $project->owner_id==Auth::user()->id && $project->Status()->first()->title != App\Help\Constants\ProjectStatus::CLOSED)
            <a class="mr-2" href="#" data-user_id="{{ $item->freelancer()->id }}" data-toggle='modal'
                data-target='#exampleModal' class="msg" title="{{ _i('Message') }}"><i
                    class="fa fa-envelope"></i></a>
            <a href="../bid/{{ $item->id }}" title="{{ _i('View') }}"><i class="fa fa-eye"></i></a>
            @php
                $state = $item->Status();
                if ($state != null) {
                    $state = $state->title;
                }

            @endphp

            &nbsp;
            <form method="POST" action="{{ url('dash/bid/' . $item->id . '/accept') }}" style="display: inline">
                @csrf
                @if ($state == App\Help\Constants\BidStatus::ACCEPTED)
                    <a class="btn btn-default btn-success btn-sm active " title="{{ _i('Accept') }}"><i class="fa fa-check"></i>
                    </a>
                @else
                    <button class="btn btn-default btn-success btn-sm" title="{{ _i('Accept') }}"><i class="fa fa-check"></i>
                    </button>
                @endif

            </form>

            &nbsp;
            <form method="POST" action="{{ url('dash/bid/' . $item->id . '/reject') }}" style="display: inline">
                @csrf
                @if ($state == App\Help\Constants\BidStatus::REJECTED)
                    <a class="btn btn-default active  btn-warning btn-sm " title="{{ _i('Reject') }}"><i
                            class="fa fa-ban"></i></a>

                @else
                    <button class="btn btn-default  btn-warning btn-sm " title="{{ _i('Reject') }}"><i
                            class="fa fa-ban"></i></button>

                @endif
            </form>
        @endif
@endauth
    </div>
</div>
