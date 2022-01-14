@extends('master.layout.index' ,['title' => _i('Project Details')])

@section('content')
    <!--breadcrumbs start -->
    <div class="page-header">
        <h4 class="page-title">{{ _i('Projects') }}</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('MasterHome') }}"><i class="fa fa-home"></i>
                    {{ _i('Home') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ url('master/projects') }}">{{ _i('Projects') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ _i('Project Details') }}</li>
        </ol>
    </div>
    <!--breadcrumbs end -->

    <!-- page start-->
    <div class="row">
        <div class="col-lg-12">
            <section class="card">
                <header class="card-header">
                    <h5> {{ _i('Project Details') }} </h5>
                </header>
                <div class="card-body">
                    <form method="post" action="" class="form-horizontal" enctype="multipart/form-data"
                        data-parsley-validate="">

                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">{{ _i('Status') }}</label>
                            <label class="col-sm-6 col-form-label">
                                @php
                                    $status = \App\Models\Projects\ProjStatus::where('id', $project->status_id)->first();
                                @endphp
                                <div class="badge badge-warning btn btn-info"> {{ $status->title }} </div>
                            </label>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-sm-2 col-form-label">{{ _i('Created Date') }}</label>
                            {{-- <label class="col-sm-6 col-form-label" > --}}
                            {{-- <div class="text-muted"> {{\Carbon\Carbon::parse($project->created)->diffforhumans()}} </div> --}}
                            {{-- </label> --}}
                            <label class="col-sm-6 col-form-label">
                                <div> {{ date('d M Y, h:i A ', strtotime($project->created)) }} </div>
                            </label>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-sm-2 col-form-label">{{ _i('Owner') }}</label>
                            <label class="col-sm-6 col-form-label">
                                {{-- <a href="{{route('master.buyers.edit', $project->owner_id)}}" > --}}
                                <a href="{{ url('master/users/' . $project->owner_id . '/edit') }}">
                                    @php
                                        $user = \App\User::where('id', $project->owner_id)->first();
                                    @endphp
                                    {{ $user->name . ' ' . $user->last_name }} </a>
                            </label>
                        </div>

                        @php
                            $items = [];

                            $items = App\Models\Projects\ProjcategoryAttributes::whereIn(
                                'category_id',
                                $project
                                    ->Category()
                                    ->get()
                                    ->pluck('id'),
                            )
                                ->where('module', $project->type)
                                ->orderBy('sort')
                                ->get();

                        @endphp
                        <div class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap">
                                @include('website.dashboard.project.partial.attributes_shw',["items"=>
                                $items,"project"=>$project])
                            </table>
                        </div>

                        @include("website.dashboard.project.partial.basic",["type"=>$project->type])




                        @if ($project->bid_id != null)
                            @php
                                $bid = \App\Models\Projects\ProjectBids::where('id', $project->bid_id)->first();
                            @endphp
                            <hr>
                            <div class="form-group row">
                                <label for="name" class="col-sm-2 col-form-label">{{ _i('Bid Price') }}</label>
                                <label class="col-sm-6 col-form-label">
                                    {{ $bid->price }}
                                </label>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-sm-2 col-form-label">{{ _i('Bid Duration') }}</label>
                                <label class="col-sm-6 col-form-label">
                                    {{ $bid->duration }}
                                </label>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-sm-2 col-form-label">{{ _i('Bid Description') }}</label>
                                <div class="col-sm-6">
                                    <textarea class="form-control" disabled
                                        rows="10">{{ $bid->description }}</textarea>
                                </div>
                            </div>
                        @endif

                        <div class="box-footer">
                            <a href="{{ route('master.projects.index') }}">
                                <button type="button" class="btn btn-gray col-sm-3">{{ _i('Back') }}</button>
                            </a>
                            {{-- <button type="submit" class="btn btn-primary col-sm-3 "> {{ _i('Save')}}</button> --}}
                        </div>
                    </form>

                </div>
            </section>
        </div>
    </div>
    <!-- page end-->


@endsection
