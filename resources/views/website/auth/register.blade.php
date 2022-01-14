@extends('website.dashboard.index_inner', ['title' => _i('Register'),'header_title' => _i('Create Your account')])
@section('content')
    <!--Sliders Section-->
    <section>
        <div class="bannerimg cover-image bg-background3" data-image-src="{{asset('website2/assets/images/banners/banner2.jpg')}}">
            <div class="header-text mb-0">
                <div class="container">
                    <div class="text-center text-white ">
                        <h1 class="">{{_i('Register')}}</h1>
                        <ol class="breadcrumb text-center">
                            <li class="breadcrumb-item"><a href="{{ route('WebsiteHome') }}">{{_i('Home')}}</a></li>
                            <li class="breadcrumb-item"><a href="{{route('WebsiteLogin')}}">{{_i('Login')}}</a></li>
                            <li class="breadcrumb-item active text-white" aria-current="page">{{_i('Register')}}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/Sliders Section-->
    <!--Register-section-->
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
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <div class="col-lg-4 d-block mx-auto">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-md-12 register-right">

                            <div class="card mb-0">
                                <div class="card-header">
                                    <h3 class="card-title">{{_i('Create Personal Account')}}</h3>
                                </div>
                                <div class="card-body">

                                    <form class="login-form php-email-form" method="post" action="{{route('WebsitePostRegister')}}" data-parsley-validate="">
                                        @csrf

                                        <div class="form-group">
                                            <label class="form-label text-dark">{{ _i('First Name') }}</label>
                                            <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                                                   required="" placeholder="{{ _i('First Name') }}">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label text-dark">{{ _i('Last Name') }}</label>
                                            <input type="text" class="form-control" name="last_name"
                                                   value="{{ old('last_name') }}" placeholder="{{ _i('Last Name') }}">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label text-dark">{{_i('Email address')}}</label>
                                            <input type="email" id="sender-email" class="form-control" name="email" required=""
                                                   value="{{ old('email') }}" placeholder="{{ _i('User Email') }}">                                            </div>
                                        <div class="form-group">
                                            <label class="form-label text-dark">{{_i('Password')}}</label>
                                            <input type="password" class="form-control" id="password" name="password" required=""
                                                   placeholder="{{ _i('Password') }}">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label text-dark">{{_i('Retype Password')}}</label>
                                            <input type="password" class="form-control" required="" name="password_confirmation"
                                                   data-parsley-equalto="#password" placeholder="{{ _i('Retype Password') }}">
                                        </div>
                                        <div class="form-group">
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input">
                                                <span class="custom-control-label text-dark"> <a href="terms.html">terms and policy</a></span>
                                            </label>
                                        </div>
                                        <div class="form-footer mt-2">
                                            <button type="submit" class="btn btn-primary btn-block">{{_i('Create New Account')}}</button>
                                        </div>
                                    </form>
                                    <div class="text-center  mt-3 text-dark">
                                        {{_i('Already have account')}}?<a href="{{ route('WebsiteLogin') }}">{{_i('SignIn')}}</a>
                                    </div>

                                    <hr class="divider">
                                    <div class="text-center">
                                        <div class="btn-group btn-block mt-2 mb-2">
                                            <a href="{{ url('/auth/redirect/facebook') }}" class="btn btn-facebook active">
                                                <span class="fa fa-facebook"></span>
                                            </a>
                                            <a href="{{ url('/auth/redirect/facebook') }}" class="btn btn-block btn-facebook">{{_i('Facebook')}}</a>
                                        </div>
                                        <div class="btn-group btn-block mt-2 mb-2">
                                            <a href="{{ url('/auth/redirect/google') }}" class="btn btn-google active">
                                                <span class="fa fa-google"></span>
                                            </a>
                                            <a href="{{ url('/auth/redirect/google') }}" class="btn btn-block btn-google">{{_i('Google')}}</a>
                                        </div>
                                        <div class="btn-group btn-block mt-2 mb-2">
                                            <a href="{{ url('/auth/redirect/linkedin') }}" class="btn btn-info active">
                                                <span class="fa fa-linkedin"></span>
                                            </a>
                                            <a href="{{ url('/auth/redirect/linkedin') }}" class="btn btn-block btn-info">{{_i('Linkedin')}}</a>
                                        </div>
                                        <div class="btn-group btn-block mt-2 mb-2">
                                            <a href="{{ url('/auth/redirect/twitter') }}" class="btn btn-success active">
                                                <span class="fa fa-twitter"></span>
                                            </a>
                                            <a href="{{ url('/auth/redirect/twitter') }}" class="btn btn-block btn-success">{{_i('Twitter')}}</a>
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
    <!--/Login-Section-->
    <!--Register-section-->

@endsection
