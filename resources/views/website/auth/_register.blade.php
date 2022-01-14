@extends('website.layout.index', ['title' => _i('Register'),'header_title' => _i('Create Your account')])
@section('content')
    <div class="row">
        <div class="col-lg-10 offset-1">
            <div class="d-flex align-items-start">
                <div class="nav flex-column nav-pills me-3 col-md-2" id="v-pills-tab" role="tablist"
                    aria-orientation="vertical">
                    <a class="nav-link {{(request()->query("company")==null)? 'active' : ''}}  " id="v-pills-home-tab" data-bs-toggle="pill"
                        data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home"
                        aria-selected="true">{{ _i('Personal') }}</a>
                    <a class="nav-link {{(request()->query("company")!=null)? 'active' : ''}} " id="v-pills-profile-tab" data-bs-toggle="pill"
                        data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile"
                        aria-selected="false">{{ _i('Institution') }}</a>

                </div>
                <div class="tab-content col-md-8" id="v-pills-tabContent">
                    <div class="tab-pane fade  {{(request()->query("company")==null)? ' show active' : ''}} " id="v-pills-home" role="tabpanel"
                        aria-labelledby="v-pills-home-tab">
                        <form class="login-form php-email-form" method="post" action="" data-parsley-validate="">
                            <h3>
                                {{ _i('Create Your account') }}
                            </h3>
                            @if (session('success'))
                                <div class="row form-group">
                                    <div class="alert alert-success alert-block col-sm-12 ">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <h6>
                                            <i class="fa fa-ok-sign"></i>
                                            {{ _i('Success') }}!
                                        </h6>
                                        <p>{{ session('success') }}</p>
                                    </div>
                                </div>
                            @endif
                            @if (session('error'))
                                <div class="row form-group">
                                    <div class="alert alert-danger  alert-block  col-sm-12 ">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <h6>
                                            <i class="fa fa-ok-sign"></i>
                                            {{ _i('Error') }}!
                                        </h6>
                                        <p>{{ session('error') }}</p>
                                    </div>
                                </div>
                            @endif

                            @if ($errors->all())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @csrf


                            <div class="form-group">
                                <div class="input-icon">
                                    <i class="lni-user"></i>
                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                                        required="" placeholder="{{ _i('First Name') }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-icon">
                                    <i class="lni-user"></i>
                                    <input type="text" class="form-control" name="last_name"
                                        value="{{ old('last_name') }}" placeholder="{{ _i('Last Name') }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-icon">
                                    <i class="lni-envelope"></i>
                                    <input type="email" id="sender-email" class="form-control" name="email" required=""
                                        value="{{ old('email') }}" placeholder="{{ _i('User Email') }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-icon">
                                    <i class="lni-lock"></i>
                                    <input type="password" class="form-control" id="password" name="password" required=""
                                        placeholder="{{ _i('Password') }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-icon">
                                    <i class="lni-unlock"></i>
                                    <input type="password" class="form-control" required="" name="password_confirmation"
                                        data-parsley-equalto="#password" placeholder="{{ _i('Retype Password') }}">
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-common log-btn mt-3">{{ _i('Register') }}</button>
                            </div>
                            <p class="text-center">{{ _i('Already have an account') }}?<a
                                    href="{{ route('WebsiteLogin') }}">
                                    {{ _i('Sign In') }}</a></p>

                            <div class="row ">
                                <div class="col-md-12 col-xs-12 form-group">
                                    <a class="btn  btn-warning  form-control" href="{{ url('/auth/redirect/google') }}">
                                        <span class="fa fa-google fa-2x"></span> <i class="lni lni-google"></i>
                                        {{ _i('Using Google') }}
                                    </a>
                                </div>

                                <div class="col-md-12 col-xs-12 form-group">
                                    <a class="btn  btn-info  form-control" href="{{ url('/auth/redirect/facebook') }}">
                                        <span class="fa fa-facebook fa-2x"></span>{{ _i('Using Facebook') }}
                                    </a>
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col-md-12 col-xs-12 form-group">
                                    <a class="btn  btn-danger  form-control" href="{{ url('/auth/redirect/linkedin') }}">
                                        <span class="fa fa-linkedin fa-2x"></span>{{ _i('Using Linkedin') }}
                                    </a>
                                </div>
                                <div class="col-md-12 col-xs-12 form-group">
                                    <a class="btn  btn-success  form-control" href="{{ url('/auth/redirect/twitter') }}">
                                        <span class="fa fa-twitter fa-2x"></span>{{ _i('Using Twitter') }}
                                    </a>
                                </div>
                            </div>
                        </form>

                    </div>
                    <div class="tab-pane fade {{(request()->query("company")!=null)? ' show active' : ''}} " id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">

                        @include("website.auth.company.register")
                    </div>

                </div>
            </div>


        </div>
    </div>
@endsection
