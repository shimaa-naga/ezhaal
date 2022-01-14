@extends('website.layout.index', ['title' => _i("Thanks for your transaction"),'header_title' => _i("Thanks for your
transaction")])

@section('content')
    <div class="row">
        <div class="card">
            <div class="card-body row">
                <div class="col-md-2">
                    {{ _i('Transaction ID') }} :
                </div>
                <div class="col-md-10">
                    {{ $transaction->id }}
                </div>
                <div class="col-md-2">
                    {{ _i('Date') }} :
                </div>
                <div class="col-md-10">
                    {{date("d M Y, h:i A ", strtotime($transaction->created_at)) }}
                </div>
                <div class="col-md-2">
                    {{ _i('Total') }} :
                </div>
                <div class="col-md-10">
                    {{ $transaction->total }}   {{ $transaction->currency }}
                </div>
                <div class="col-md-12">
                    <h5>{{_i("Project Information")}}</h5>
                    <p>{{$transaction->Project()->first()->title}}</p>
                </div>
                <div class="col-md-2">
                    {{ _i('Due Date') }} :
                </div>
                <div class="col-md-10">
                    {{ $date }}
                </div>
                <div class="col-md-2">

                </div>
                <div class="col-md-10">
                   <button onclick="window.print()" class="btn btn-primary">
                   <i class="fa fa-print"> {{_i("Print")}} </i>
                </button>
                </div>



            </div>
        </div>

    </div>

@endsection
