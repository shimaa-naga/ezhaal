@extends('master.layout.index' ,['title' => _i('Edit Discount')])

@section('content')
    <?php
    $selected_users = '';
    $action = route('discounts.store');
    if (isset($discount)) {
    $selected_users = $discount
    ->Users()
    ->get()
    ->pluck('id');
    $action = route('discounts.update', $id);
    }
    ?>

    <!--breadcrumbs start -->
    <div class="page-header">
        <h4 class="page-title">{{ _i('Edit') }} {{ $discount->title }}</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('MasterHome') }}"><i class="fa fa-home"></i> {{ _i('Home') }}</a></li>
            <li class="breadcrumb-item"><a href="{{  url('master/discounts') }}"> {{ _i('Discounts') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ _i('Edit') }} {{ $discount->title }}</li>
        </ol>
    </div>
    <!--breadcrumbs end -->

    @if(count($discount->Transaction()->get())>0)
    <div class="alert alert-danger">
        {{_i("Update is disabled because there is related transactions")}}
    </div>
    @endif

    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        {{ _i('Edit') }} {{ $discount->title }}
                    </div>
                </div>
                <div class="card-body">


                    <div class="panel panel-primary">
                        <div class="tab-menu-heading">
                            <div class="tabs-menu ">
                                <!-- Tabs -->
                                <ul class="nav nav-tabs nav-justified  panel-tabs">
                                    @if ($discount->module == \App\Help\Constants\DiscountModule::PER_DATE)
                                        <li class="">
                                            <a data-toggle="tab" href="#duration">{{ _i('Duration Discount') }}</a>
                                        </li>
                                    @elseif($discount->module == \App\Help\Constants\DiscountModule::PER_USERS || $discount->module ==
                                    \App\Help\Constants\DiscountModule::PER_USER_OPERATIONS )

                                        <li class="">
                                            <a data-toggle="tab" href="#counter">{{ _i('Counter discount') }}</a>
                                        </li>
                                    @elseif ($discount->module==\App\Help\Constants\DiscountModule::SPECIFIC_USER)
                                        <li class="">
                                            <a data-toggle="tab" href="#user">{{ _i('User discount') }}</a>
                                        </li>
                                    @endif
                                </ul>

                            </div>
                        </div>

                        <div class="panel-body tabs-menu-body">
                            <div class="tab-content">
                                @if ($discount->module == \App\Help\Constants\DiscountModule::PER_DATE)
                                    <div class="tab-pane active" id="duration">
                                        @include("master.discount.partial.tab_duration",["discount"=>$discount])
                                    </div>
                                @elseif($discount->module == \App\Help\Constants\DiscountModule::PER_USERS || $discount->module ==
                                    \App\Help\Constants\DiscountModule::PER_USER_OPERATIONS )
                                    <div id="counter" class="tab-pane active">
                                        @include("master.discount.partial.tab_counter",["discount"=>$discount])

                                    </div>
                                @elseif( $discount->module == \App\Help\Constants\DiscountModule::SPECIFIC_USER )
                                    <div id="user" class="tab-pane active">
                                        @include("master.discount.partial.tab_users",["discount"=>$discount])

                                    </div>
                                @endif
                            </div>
                        </div>


                    </div>


                </div>
            </div>
        </div>
    </div>





@endsection
