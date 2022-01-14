@extends('website.layout.index',['title' => _i('Reset'),'header_title' => _i('Reset')])

@section('content')
    <!--Forgot password-->

    <div class="row">
        <div class="col-xl-4 col-md-12 col-md-12 d-block mx-auto">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <div class="card mb-0">
                <form method="POST" action="{{ route('password.email') }}" class="php-email-form"
                    data-parsley-validate="">
                    @csrf
                    <div class="card-header">
                        <h3 class="card-title">{{ _i('Forgot password') }}</h3>
                    </div>
                    <div class="card-body">

                        <div class="form-group">

                            <label for="email" class="form-label text-dark">{{ __('E-Mail Address') }}</label>

                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                placeholder="{{ _i('Enter Email') }}" name="email" value="{{ old('email') }}" required
                                autocomplete="email" autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-footer">

                            <button type="submit" class="btn btn-primary btn-block">
                                {{ __('Send Password Reset Link') }}
                            </button>
                        </div>
                        <div class="text-center text-dark mt-3 ">
                            {{ _i('Forget it') }}, <a href="../login">{{ _i('send me back') }}</a>
                            {{ _i('to the sign in') }}.
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>



@endsection
