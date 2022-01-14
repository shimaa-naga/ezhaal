<div class="tab-pane " id="tab-11">
    @forelse($projects as $project)
        <div class="card overflow-hidden">
            <div class="card-header pt-5 pb-5">
                <div class="d-flex">
                    <span class="avatar avatar-md  d-block brround cover-image mr-4"
                        data-image-src="{{ $project->owner()->image == '' ? asset('uploads/users/user-default2.jpg') : asset($project->owner()->image) }}"></span>
                    <div>
                        <a href="{{ url('project') }}/{{ $project->id }}/{{ $project->title }}"
                            class="font-weight-semibold fs-18 text-body">{{ $project->title }}</a>
                        @if ($project->type == 'project' || $project->type == 'service')
                            <span class="badge badge-info fs-12">
                                {{ $project->bids()->count() }} {{ _i('bids') }}</span>
                        @endif
                        <span class="badge badge-danger fs-12">
                            {{ $project->PriceTypeTitle }} </span>
                        <br>
                        <a href="{{ url('project') }}/{{ $project->id }}/{{ $project->title }}"><small>
                                <i class="fa fa-user"></i>
                                {{ $project->ByUser['name'] . ' ' . $project->ByUser['last_name'] }}
                            </small>
                            {{-- @include("website.dashboard.projects.partial.attr") --}}


                        </a>
                    </div>
                </div>
                <div class="card-options employers-details">

                    {{ \Carbon\Carbon::parse($project['created_at'])->diffforhumans() }}
                </div>
            </div>
            <div class="card-body pb-2 hide-details">
                {{ strip_tags($project->description) }}

                @php
              //  dd($project->category->first());
                    $bids = $project->bids()->paginate(10);
                    $disabled = false;
                    if (auth('web')->user() != null) {
                        if (
                            $project
                                ->bids()
                                ->where('freelancer_id', auth('web')->user()->id)
                                ->first() != null
                        ) {
                            $disabled = true;
                        }
                        if ($project->Owner()->id == auth('web')->user()->id) {
                            $disabled = true;
                        }
                    }
                    // if ($project->Status()->first()->title != ProjectStatus::PUBLISHED) {
                    //     $disabled = true;
                    // }
                @endphp
                @include("website.dashboard.project_bids.parial.apply2",["category" =>$project->category->first(),"bids"=>
                $bids,"disabled"=>$disabled])
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="product-filter-desc col">
                        <div class="product-filter-icons  float-left">
                            @include("website.dashboard.projects.partial.attr")

                        </div>
                    </div>

                </div>
            </div>


        </div>
    @empty
        <div class="card overflow-hidden">
            <a href="{{ route('website.projects.index') }}"
                class="alerts-title">{{ _i('There are no projects to display') }}.</a>
        </div>
    @endforelse



</div>
<div class="tab-pane" id="tab-12">
    <div class="row">
        @forelse($projects as $project)
            <div class="col-xl-4 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="team-section text-center">
                            <div class="team-img">
                                <img src="{{ $project->owner()->image == '' ? asset('uploads/users/user-default2.jpg') : asset($project->owner()->image) }}"
                                    class="img-thumbnail rounded-circle alt=" alt="">
                            </div>
                            <h4 class="font-weight-bold dark-grey-text mt-4">{{ $project->title }}
                                @if ($project->type == 'project' || $project->type == 'service')
                                    <span class="badge badge-info fs-12">
                                        {{ $project->bids()->count() }} {{ _i('bids') }}</span>
                                @endif
                                <span class="badge badge-danger fs-12">
                                    {{ $project->PriceTypeTitle }} </span>
                            </h4>
                            @include("website.dashboard.projects.partial.attr")

                            <h6 class="font-weight-bold blue-text ">
                                <small class="text-muted"><i class="fa fa-user"></i>
                                    {{ $project->ByUser['name'] . ' ' . $project->ByUser['last_name'] }}</small>
                                <small class="text-muted"><i class="fa fa-clock-o"></i>
                                    {{ \Carbon\Carbon::parse($project['created_at'])->diffforhumans() }}</small>
                            </h6>
                            <p class="font-weight-normal dark-grey-text">
                                <i class="fa fa-quote-left pr-2"></i>
                                {{ Illuminate\Support\Str::words(strip_tags($project->description), 30, '..') }}


                            </p>

                        </div>
                    </div>
                </div>
            </div>
        @empty
            <a href="{{ route('website.projects.index') }}"
                class="alerts-title">{{ _i('There are no projects to display') }}.</a>
        @endforelse
    </div>

</div>
