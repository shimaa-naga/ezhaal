<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <meta name="keyword" content="FlatLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    <title>{{ config('app.name') }} | {{ _i('Login') }}</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('master/assets/bootstrap-4.1.3/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('master/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('master/css/admin-custom.css') }}" rel="stylesheet">

    {{-- <link href="{{ asset('master/css/bootstrap-reset.css') }}" rel="stylesheet"> --}}
    <!--external css-->
    <link href="{{ asset('master/font-awesome/css/font-awesome.css') }}" rel="stylesheet" />


</head>

<body class="login-body">

    <!--Page-->
    <div class="page ">
        <div class="page-content z-index-10">
            <div class="container">

                <div class="row">
                    <div class="col-xl-4 col-md-12 col-md-12 d-block mx-auto">
                        <div class="card mb-0">
                            <div class="card-header">
                                <h3 class="form-signin-heading">{{ _i('Sign in to') }} {{ config('app.name') }}
                                </h3>
                            </div>
                            <div class="card-body">
                                @if ($errors->all())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <form class="form-signin" method="post" action="{{ route('MasterPostLogin') }}">
                                    {!! csrf_field() !!}
                                    {{ method_field('post') }}

                                    <div class="form-group">
                                        <label class="form-label text-dark">{{ _i('Email address') }}</label>
                                        <input type="email" class="form-control" name="email"
                                            value="{{ old('email') }}" placeholder="{{ _i('User Email') }}"
                                            autofocus>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label text-dark">{{ _i('Password') }}</label>
                                        <input type="password" class="form-control" name="password"
                                            placeholder="{{ _i('Password') }}">
                                    </div>

                                    <div class="form-group">
                                        <label class="custom-control custom-checkbox">
                                            <a data-toggle="modal" href="#myModal"
                                                class="float-right small text-dark mt-1">
                                                {{ _i('Forgot Password') }}?</a>
                                            <input type="checkbox" class="custom-control-input" value="1" name="remember_me">
                                            <span class="custom-control-label text-dark">{{ _i('Remember me') }}</span>
                                        </label>
                                    </div>



                                    <div class="form-footer mt-2">
                                        <button class="btn btn-primary btn-block"
                                            type="submit">{{ _i('Sign in') }}</button>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="container">

        @if (session('success'))
            <div class="col-sm-12 center">
                <div class="alert alert-success alert-block fade in col-sm-4 " style="margin-top: 20px;">
                    <button data-dismiss="alert" class="close close-sm" type="button">
                        <i class="fa fa-times"></i>
                    </button>
                    <h4>
                        <i class="fa fa-ok-sign"></i>
                        {{ _i('Success') }}!
                    </h4>
                    <p>{{ session('success') }}</p>
                </div>
            </div>
        @endif
        @if (session('error'))
            <div class="col-sm-12 center">
                <div class="alert alert-danger  alert-block fade in col-sm-4 " style="margin-top: 20px;">
                    <button data-dismiss="alert" class="close close-sm" type="button">
                        <i class="fa fa-times"></i>
                    </button>
                    <h4>
                        <i class="fa fa-ok-sign"></i>
                        {{ _i('Error') }}!
                    </h4>
                    <p>{{ session('error') }}</p>
                </div>
            </div>
        @endif






        <!-- Modal -->
        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal"
            class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">{{ _i('Forgot Password') }}?</h4>
                    </div>
                    <form method="post" action="{{ route('master.do.reset.password') }}">
                        {!! csrf_field() !!}
                        {{ method_field('post') }}
                        <div class="modal-body">
                            <p>{{ _i('Enter your e-mail address below to reset your password') }}.</p>
                            <input type="email" name="email" placeholder="{{ _i('Type your email') }}"
                                autocomplete="off" class="form-control placeholder-no-fix">

                        </div>
                        <div class="modal-footer">
                            <button data-dismiss="modal" class="btn btn-default"
                                type="button">{{ _i('Cancel') }}</button>
                            <button class="btn btn-success" type="submit">{{ _i('Submit') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- modal -->

    </div>



    <!-- js placed at the end of the document so the pages load faster -->
    <script src="{{ asset('master/js/jquery.js') }}"></script>
    <script src="{{ asset('master/js/bootstrap.min.js') }}"></script>


</body>

</html>
