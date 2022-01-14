@extends('master.layout.index' ,['title' => _i('Projects')])

@section('content')
    <!--breadcrumbs start -->
    <div class="page-header">
        <h4 class="page-title">{{ _i('Projects') }}</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('MasterHome') }}"><i class="fa fa-home"></i> {{ _i('Home') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ url('master/projects') }}">{{ _i('Projects') }}</a></li>

            <li class="breadcrumb-item active">{{ $project->title }}</li>
        </ol>
    </div>



    <div class="row">

        <div class="col-lg-12">
            <section class="panel">
                @if ($bid != null)
                @php

                    $trans = App\Models\Transactions\Transaction::where('id', function ($q) use ($bid) {
                        $q->from('project_history')
                            ->where('bid_id', $bid->id)
                            ->whereNotNull('transaction_id')
                            ->select('transaction_id');
                    })->first();

                @endphp
                @if ($trans != null)
                    @include("master.projects.requests.partial.trans")
                @endif
            @endif

                @include("master.projects.projects.show.index")
            </section>
        </div>
    </div>

@endsection
