@extends('master.layout.index' ,['title' => _i('Projects')])

@section('content')
    <!--breadcrumbs start -->
    <ul class="breadcrumb">
        <li><a href="{{ route('MasterHome') }}"><i class="fa fa-home"></i> {{ _i('Home') }}</a></li>
        <li><a href="{{ url('master/projects') }}"><i class="fa fa-home"></i> {{ _i('Projects') }}</a></li>

        <li class="active">{{ $project->title }}</li>
    </ul>

    <div class="row">
        <div class="col-lg-12">
            <section class="panel">

                <div class="">
                    <section class="panel">
                        @foreach ($bids as $item)
                            @include("master.projects.projects.show.bid",["bid"=>$item->Bid,"show"=>1])
                        @endforeach


                    </section>

                </div>
            </section>
        </div>
    </div>
@endsection
