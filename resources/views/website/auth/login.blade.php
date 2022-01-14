@extends('website.dashboard.index_inner', ['title' => _i('Login')])

@section('content')
    <!--Sliders Section-->
    <section>
        <div class="bannerimg cover-image bg-background3"
            data-image-src="{{ asset('website2/assets/images/banners/banner2.jpg') }}">
            <div class="header-text mb-0">
                <div class="container">
                    <div class="text-center text-white ">
                        <h1 class="">{{ _i('Login') }}</h1>
                        <ol class=" breadcrumb text-center">
                            <li class="breadcrumb-item"><a href="{{ route('WebsiteHome') }}">{{ _i('Home') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('WebsiteRegister') }}">{{ _i('Register') }}</a>
                            </li>
                            <li class="breadcrumb-item active text-white" aria-current="page">{{ _i('Login') }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/Sliders Section-->

    <!--Login-Section-->
    <section class="sptb">
        <div class="container customerpage">
            <div class="row">


                @if (session('success'))
                    <div class="row form-group col-md-12">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>{{ _i('Success') }}!</strong> {{ session('success') }}.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                @endif
                @if (session('error'))
                    <div class="row form-group col-md-12">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>{{ _i('Error') }}!</strong> {{ session('error') }}.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                @endif
                @if ($errors->all())
                    <div class="row form-group col-md-12">
                        <div class="alert alert-danger alert-dismissible fade show">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{!! $error !!}
                                        <button type="button" class="close" data-dismiss="alert"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
                <div class="col-lg-8 d-block mx-auto">
                    <div class="row">
                        @include("website.auth.otp")
                        <div class="col-xl-6 col-md-6 col-md-6 register-right">
                            <div class="tab-pane fade show active" id="personal" role="tabpanel" aria-labelledby="home-tab">
                                <form class="login-form php-email-form" method="post" action="" data-parsley-validate="">
                                    @csrf
                                @include("website.dashboard.project.partial.login.form",["buttons"=>1])
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <!--/Login-Section-->


@endsection
