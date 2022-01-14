
@forelse($projects as $project)
    @php
        $bid = $project->Bid()->first();
        $href = url('project') . '/' . $project->id . '/' . $project->title;
        if ($bid->status == \App\Help\Constants\BidStatus::ACCEPTED) {
            $href = url('dash/bid/my') . '/' . $project->bid_id;
        }
    @endphp
    <div class="row " id="project_filter">
        <div class="col-md-9">
            <h6>
                <i class="badge badge-{{ $bid->statusCode }}">{{ $bid->status }}</i>
                <a class="card-title" href="{{ $href }}">{{ $project->title }}
                </a>
                @if ($project->type == 'project')
                    <span class="badge badge-info">
                        {{ $project->bids()->count() }} {{ _i('bids') }}</span>
                @endif
            </h6>
            <p>
                <small class="text-muted"><i class="fa fa-user"></i>
                    {{ $project->ByUser['name'] . ' ' . $project->ByUser['last_name'] }}</small>
                <small class="text-muted"><i class="fa fa-clock-o" title="{{ _i('Duration') }}"></i>
                    {{ $bid->duration }} {{ _i('Days') }}
                </small>

                <small class="text-muted"><i class="fa fa-money" title="{{ _i('Budget') }}"></i>
                    {{ $bid->priceAfter }}
                </small>

            </p>
            <p class="card-text">

                {{ strip_tags($bid->description) }}</p>

        </div>
    </div>
    <hr>

@empty
    <a href="{{ route('website.projects.index') }}"
        class="alerts-title">{{ _i('There are no projects to display') }}.</a>
@endforelse
{{ $projects->appends(Request::except('page'))->links() }}
