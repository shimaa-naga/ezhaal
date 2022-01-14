<div class="col-xl-6 col-md-6 col-md-6 register-right">
    <div class="tab-pane fade show active" id="personal" role="tabpanel" aria-labelledby="home-tab">
        <form class="login-form php-email-form" method="post" action="" data-parsley-validate="">
            @csrf

            <div class="card mb-0">
                <div class="card-header">
                    <h3 class="card-title">{{ _i('Login to your Account') }}</h3>
                </div>
                <div class="card-body">

                    <div class="form-group">
                        <label class="form-label text-dark">{{ _i('Email address') }}</label>
                        <input type="email" id="sender-email" class="form-control" name="email"
                            required="" value="{{ old('email') }}"
                            placeholder="{{ _i('User Email') }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label text-dark">{{ _i('Password') }}</label>
                        <input type="password" class="form-control" name="password" required=""
                            placeholder="{{ _i('Password') }}">
                    </div>
                    <div class="form-group">
                        <label class="custom-control custom-checkbox">
                            <a href="{{ url('password/reset') }}"
                                class="float-right small text-dark mt-1">{{ _i('I forgot password') }}</a>
                            <input type="checkbox" class="custom-control-input" id="exampleCheck1"
                                value="1" name="remember_me">
                            <span class="custom-control-label text-dark"
                                for="exampleCheck1">{{ _i('Remember me') }}</span>
                        </label>
                    </div>
                    <div class="form-footer mt-2">

                        <button type="submit"
                            class="btn btn-primary btn-block">{{ _i('SignIn') }}</button>
                    </div>
                    <div class="text-center  mt-3 text-dark">
                        {{ _i('Don\'t have account yet') }}? <a
                            href="{{ route('WebsiteRegister') }}">{{ _i('SignUp') }}</a>

                    </div>
                    <hr class="divider">

                    <div class="text-center">
                        @include("website.auth.login.social")
                    </div>
                </div>
            </div>
        </form>
    </div>

</div>
