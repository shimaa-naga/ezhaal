<div class="card mb-0">
    <div class="card-header">
        <h3 class="card-title">{{ _i('Login by Account') }}</h3>
    </div>
    <div class="card-body">

        <div class="form-group">
            {{-- <label for="recipient-name" class="form-control-label">{{ _i('Email') }}:</label> --}}
            <input type="email" data-parsley-group="login" placeholder="{{ _i('Email') }}" required
                class="form-control" name="login_email" id="recipient-name">
        </div>
        <div class="form-group">
            {{-- <label for="recipient-pass" class="form-control-label">{{ _i('Password') }}:</label> --}}
            <input type="password" data-parsley-group="login" placeholder="{{ _i('Password') }}" required
                class="form-control" name="login_password" id="recipient-pass">
        </div>

        <div class="form-group">
            <label class="custom-control custom-checkbox">
                <a href="{{ url('password/reset') }}" class="float-right small text-dark mt-1">
                    {{ _i('I forgot password') }}
                </a>
                <input type="checkbox" class="custom-control-input" name="remember_me">
                <span class="custom-control-label text-dark">{{ _i('Remember me') }}</span>
            </label>
        </div>
        <div class="form-footer mt-2">
            <input type="hidden" name="btn" value="login" id="btn" />
            @if (isset($buttons))
            <button type="submit" class="btn btn-primary btn-block">{{ _i('SignIn') }}</button>
            @else
                <button type="button" name="btnlogin" onclick="login()"
                    class="btn btn-primary col-md-12">{{ _i('Sign In') }}</button>
            @endif
        </div>
        @if (isset($buttons))
            <hr class="divider">

            <div class="text-center">
                @include("website.auth.login.social")
            </div>
        @else
            <hr class="divider">

            <div class="text-center">
                @include("website.dashboard.project.partial.login.social")
            </div>
        @endif
    </div>
</div>
