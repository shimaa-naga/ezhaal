@extends('master.layout.index' ,['title' => _i('Financial Settings')])

@section('content')
    <!--breadcrumbs start -->
    <div class="page-header">
        <h4 class="page-title">{{ _i('Financial Settings') }}</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('MasterHome') }}"><i class="fa fa-home"></i> {{ _i('Home') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ _i('Financial Settings') }}</li>
        </ol>
    </div>
    <!--breadcrumbs end -->

    <!-- page start-->
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        {{ _i('Settings') }}
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="" class="form-horizontal" data-parsley-validate="">
                        @csrf
                        <div class="card-body card-block">

                            <div class="form-group row">
                                <label for="name"
                                       class="col-sm-3 col-form-label">{{ _i('Transfer Minimum Holding Amount') }}</label>
                                <div class="col-sm-9">
                                    <div class="input-group m-bot15">
                                        <input type="number" class="form-control" name="transfer"
                                               value="{{ $settings->transfer_minimum_amount }}" placeholder="">
                                        <span class="input-group-addon"> {{ _i('USD') }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-sm-3 col-form-label">{{ _i('Holding Duartion') }}</label>


                                <div class="col-sm-9">
                                    <div class="input-group m-bot15">
                                        <input type="number" class="form-control" name="holding"
                                               value="{{ $settings->holding_days }}" placeholder="">
                                        <span class="input-group-addon"> {{ _i('Days') }}</span>
                                    </div>

                                </div>
                            </div>
                            @foreach ($globalsettings as $item)
                                <div class="form-group row">
                                    <label for="name" class="col-sm-3 col-form-label">{{ $item->title }}</label>
                                    <div class="col-sm-9">
                                        <input type="{{ $item->type }}" class="form-control"
                                               name="setting[{{ $item->key }}]" value="{{ $item->value }}" placeholder=""
                                               data-parsley-maxlength="255">
                                    </div>
                                </div>
                            @endforeach

                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary col-sm-12">{{ _i('Save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- page end-->

@endsection
