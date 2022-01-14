@extends('master.layout.index' ,['title' => _i('Discounts')])

@section('content')
@php
    $selected_users = '';
    $action = route('discounts.store');
@endphp

<!--breadcrumbs start -->
<div class="page-header">
    <h4 class="page-title">{{ _i('Discounts') }}</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('MasterHome') }}"><i class="fa fa-home"></i> {{ _i('Home') }}</a></li>
        <li class="breadcrumb-item"><a href="{{  url('master/discounts')  }}"> {{ _i('Discounts') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ _i('Create') }}</li>
    </ol>
</div>
<!--breadcrumbs end -->
<div class="row">
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    {{_i('Create Discount')}}
                </div>
            </div>
            <div class="card-body">

                <div class="panel panel-primary">
                    <div class="tab-menu-heading">
                        <div class="tabs-menu ">
                            <!-- Tabs -->
                            <ul class="nav panel-tabs">
                                <li class="active">
                                    <a class=" active" data-toggle="tab" href="#duration">{{ _i('Duration Discount') }}</a>
                                </li>
                                <li class="">
                                    <a data-toggle="tab" href="#counter">{{ _i('Counter discount') }}</a>
                                </li>
                                <li class="">
                                    <a data-toggle="tab" href="#user">{{ _i('User discount') }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="panel-body tabs-menu-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="duration">
                                @include("master.discount.partial.tab_duration")
                            </div>
                            <div id="counter" class="tab-pane">
                                @include("master.discount.partial.tab_counter")

                            </div>
                            <div id="user" class="tab-pane">
                                @include("master.discount.partial.tab_users")

                            </div>                        </div>
                    </div>
                </div>
            </div>

            </div>
        </div>
    </div>
</div>





@endsection
