<?php
$states = $project
->StatusLog()
->orderBy('id', 'desc')
->get();
$states = \App\Models\Projects\ProjectHistory::where('bid_id', $bid->id)
->orderBy('id')
->get();
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <h4 class="card-title mb-5">{{ _i('Project Status') }} </h4>
            <div class="hori-timeline" dir="ltr">
                <ul class="list-inline events">
                    @php
                        $colors = ['primary', 'warning', 'success', 'danger'];
                        $i = -1;
                    @endphp
                    @foreach ($states as $state)
                        @php
                            $i++;
                            if ($i >= count($colors)) {
                                $i = 0;
                            }
                        @endphp
                        <li class="list-inline-item event-list">
                            <div class="px-4">
                                <div class="event-date bg-soft-{{ $colors[$i] }} text-{{ $colors[$i] }}">
                                    {{ $state->title }}
                                </div>

                                {{ date('d M Y h:i:s A', strtotime($state->created_at)) }}
                                <h5 class="font-size-16"></h5>

                                <img class="rounded-circle " width="50" height="50"
                                    src="{{ $state->title == \App\Help\Constants\ProjectStatus::ASSIGNED ? $bid->freelancerImage : $state->byUserImage }}">
                                <p>
                                    {{ $state->title == \App\Help\Constants\ProjectStatus::ASSIGNED ? $bid->Freelancer()->name : $state->byUserName  }}
                                </p>

                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
            @if ($bid != null)
                @include("website.dashboard.project_bids.my.single.attachments")
            @endif
            <!-- end card -->
        </div>
    </div>
</div>

@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('custom/timeline.css') }}" />
@endpush
