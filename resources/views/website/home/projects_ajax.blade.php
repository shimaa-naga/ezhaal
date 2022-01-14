@forelse($projects as $project)

<div class="col-lg-6">
    <div class="member d-flex align-items-start">
        <div class="pic"><img
                src="{{ $project->owner()->image == '' ? asset('uploads/users/user-default2.jpg') : asset($project->owner()->image) }}"
                class="img-fluid" alt=""></div>
        <div class="member-info">
            <a href="{{url('project')}}/{{$project->id}}/{{$project->title}}}">
            <h4>{{ $project->title }}</h4>
            </a>
            <span>
                <small class="text-muted"><i class="fa fa-user"></i>
                    {{ $project->ByUser['name'] . ' ' . $project->ByUser['last_name'] }}</small>
                <small class="text-muted"><i class="fa fa-clock-o"></i>
                    {{ \Carbon\Carbon::parse($project['created_at'])->diffforhumans() }}</small>
            </span>
            <p class="card-text">
                {{ Illuminate\Support\Str::words(strip_tags($project->description), 30, '..') }}</p>

        </div>
    </div>
</div>
@empty
<a href="{{ route('website.projects.index') }}"
    class="alerts-title">{{ _i('There are no projects to display') }}.</a>
@endforelse
<div class="col-md-6 offset-6">
{{ $projects->appends(Request::except('page'))->links() }}
</div>
