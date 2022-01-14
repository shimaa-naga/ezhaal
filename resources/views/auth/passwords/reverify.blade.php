@extends('website.dashboard.index_inner',['title' => _i('Resend verification link'),'header_title' => _i('Resend verification link')])

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
                            <li class="breadcrumb-item active text-white" aria-current="page">{{_i('Resend verification link')}}</li>
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
                            <h3 class="card-title">{{_i('Resend verification link')}}</h3>
                        </div>

                        <div class="card-body">


                            <div class="col">
                                <div class="row">
                                    <div class="col mb-3">
                                        <div class="card col-xl-9">
                                            <div class="card-body">
                                                <div class="e-profile">


                                                    <div class="tab-content pt-3">
                                                        <div class="tab-pane active">
                                                            <form method="POST" action="{{ route('reverify.post') }}" class="php-email-form" data-parsley-validate="">
                                                                @csrf

                                                                <div class="row">
                                                                    <div class="col">

                                                                        <div class="row">
                                                                            <div class="col">
                                                                                <div class="form-group">
                                                                                    <label>{{_i('E-Mail Address')}} <span class="text-danger">*</span></label>
                                                                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                                                                           name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                                                                    @error('email')
                                                                                    <span class="invalid-feedback" role="alert">
                                                                                        <strong>{{ $message }}</strong>
                                                                                    </span>
                                                                                    @enderror
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col text-center justify-content-end">
                                                                        <button class="btn btn-primary" type="submit"><i class="fa fa-send"></i> {{_i('Send')}}</button>
                                                                    </div>
                                                                </div>
                                                            </form>

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
        </div>
    </section>
    <!--/User Dashboard-->



@endsection
