@extends('website.dashboard.index_inner',['title' => _i('Dashboard'),'header_title' => _i('Dashboard')])

@section('content')

    <!--Breadcrumb-->
    <section>
        <div class="bannerimg cover-image bg-background3" data-image-src="{{asset('website2/assets/images/banners/banner2.jpg')}}">
            <div class="header-text mb-0">
                <div class="container">
                    <div class="text-center text-white ">
                        <h1 class="">{{_i('Dashboard')}}</h1>
                        <ol class="breadcrumb text-center">
                            <li class="breadcrumb-item"><a href="{{ route('WebsiteHome') }}">{{_i('Home')}}</a></li>
                            <li class="breadcrumb-item active text-white" aria-current="page">{{_i('Dashboard')}}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Breadcrumb-->

    <!--User Dashboard-->
    <section class="sptb">
        <div class="container">
            <div class="row">

                <div class="col-xl-12 col-lg-12 col-md-12">
                    <div class="card mb-0">
                        <div class="card-header">
                            <h3 class="card-title">{{ _i('Welcome') }} !</h3>
                        </div>

                        <div class="card-body">
                            <section id="portfolio-details" class="portfolio-details">
                                <div class="container">
                                    <div class="row gy-4">

                                        <div class="col-md-12 portfolio-info">

                                            @if (session('status'))
                                                <div class="alert alert-success" role="alert">
                                                    {{ session('status') }}
                                                </div>
                                            @endif

{{--                                            {{ __('Welcome!') }}--}}

                                            <div class="row">
                                                <div class="card  col-md-2 text-center bg-primary text-white">
                                                    <div class="row no-gutters">
                                                        <div class="card-body">
                                                            <a class="text-white" href="{{url('dash/project/create')}}"><i class="fa fa-plus"></i> {{ _i('New Project') }}</a>
                                                        </div>

                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </section>


                        </div>


                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/User Dashboard-->


@endsection
