@extends('website.dashboard.index_inner', ['title' => $title,'header_title' => $title])

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
                            <li class="breadcrumb-item active text-white" aria-current="page">{{_i("Register complete")}}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Breadcrumb-->

    <section class="sptb">
        <div class="container">
            <div class="row">

                <div class="col-xl-12 col-lg-12 col-md-12">
                    <div class="card mb-0">
                        <div class="card-header">
                            <h3 class="card-title">{{ _i('Register complete') }} !</h3>
                        </div>

                        <div class="card-body">
                            <div class="support">
                                <div class="row text-white">
                                    <div class="col-xl-12 col-lg-12 col-md-12 border-right">

                                        <div class="support">
                                            <div class="row text-white">
                                                <div class="col-xl-12 col-lg-12 col-md-12">
                                                    <div class="support-service bg-primary br-2 mb-4 mb-xl-0 row">
                                                        <i class="fa fa-envelope"></i>
                                                        {{-- <h6>+68 872-627-9735</h6> --}}
                                                        {{ $msg }}
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>




@endsection
