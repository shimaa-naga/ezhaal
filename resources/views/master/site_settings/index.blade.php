@extends('master.layout.index' ,['title' => _i('Site Settings')])

@section('content')
    <!--breadcrumbs start -->
    <div class="page-header">
        <h4 class="page-title">{{ _i('Site Settings') }}</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('MasterHome') }}">{{ _i('Home') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ _i('Site Settings') }}</li>
        </ol>
    </div>
    <!--breadcrumbs end -->

    <!-- page start-->
    <div class="row row-cards">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">{{ _i('Site Settings') }}</div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('master.settings.store') }}" class="form-horizontal"
                          id="demo-form" data-parsley-validate="" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body card-block">
                            @foreach ($settings as $item)
                                <div class="form-group row">
                                    <label for="name" class="col-sm-4 col-form-label">{{ $item->title }}</label>
                                    <div class="col-sm-8">
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
{{--                <div class="card-footer">--}}
{{--                    <button type="submit" class="btn btn-primary waves-effect waves-light">Publish</button>--}}
{{--                </div>--}}
            </div>
        </div>
        <div class="col-md-6">
            @include("master.site_settings.logo")
            @include("master.site_settings.trusted")
            @include("master.site_settings.onrequest")

        </div>
        <div class="col-md-12">
            @include("master.site_settings.new_project")
        </div>

    </div>
    <!-- page end-->

@endsection
