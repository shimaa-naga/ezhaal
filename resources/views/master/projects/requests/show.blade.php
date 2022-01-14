@extends('master.layout.index' ,['title' => _i('Projects')])

@section('content')
    <!--breadcrumbs start -->
    <div class="page-header">
        <h4 class="page-title">{{ _i('Requests') }}</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('MasterHome') }}"><i class="fa fa-home"></i> {{ _i('Home') }}</a></li>
            <li class="breadcrumb-item "><a href="{{ url('master/requests') }}">{{ _i('Projects Requests') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ _i('Request details') }}</li>
        </ol>
    </div>
    <!--breadcrumbs end -->

    <div class="row">

        @if ($bid->payment_status != App\Help\Constants\PaymentStatus::PAID)
            <div class="col-lg-12">
                <section class="card">
                    <div class="card-body">

                        @include("master.projects.requests.partial.form")
                    </div>
                </section>
            </div>

        @else
            @include("master.projects.requests.partial.paid")

        @endif
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
        <div class="col-lg-12">
            @include("master.projects.projects.show.index")

        </div>
    </div>
@endsection
