
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <meta name="keyword" content="FlatLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <link rel="shortcut icon" href="{{asset('favicon.ico')}}">

    <title>{{config("app.name")}} | {{_i('Reset Password')}}</title>

    <!-- Bootstrap core CSS -->
    <link href="{{asset('master/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('master/css/bootstrap-reset.css')}}" rel="stylesheet">
    <!--external css-->
    {{-- <link href="{{asset('master/assets/font-awesome/css/font-awesome.css')}}" rel="stylesheet" /> --}}
    <!-- Custom styles for this template -->
    <link href="{{asset('master/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('master/css/style-responsive.css')}}" rel="stylesheet" />

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
<!--[if lt IE 9]>
    <script src="{{asset('master/js/html5shiv.js')}}"></script>
    <script src="{{asset('master/js/respond.min.js')}}"></script>
    <![endif]-->

    <!-- parsleyjs  css file -->
    <link href="{{asset('custom/parsley.css')}}" rel="stylesheet">

    <style>
        .form-signin input[type="email"]{
            margin-bottom: 15px;
            border-radius: 5px;
            -webkit-border-radius: 5px;
            border: 1px solid #eaeaea;
            box-shadow: none;
            font-size: 12px;
        }
    </style>
</head>

<body class="login-body">

<div class="container">

    @if (session('success'))
        <div class="col-sm-12 center">
            <div class="alert alert-success alert-block fade in col-sm-4 " style="margin-top: 20px;">
                <button data-dismiss="alert" class="close close-sm" type="button">
                    <i class="fa fa-times"></i>
                </button>
                <h4>
                    <i class="fa fa-ok-sign"></i>
                    {{_i('Success')}}!
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
                    {{_i('Error')}}!
                </h4>
                <p>{{ session('error') }}</p>
            </div>
        </div>
    @endif

    <form class="form-signin" method="post" action="{{route('master.reset.password.token.post')}}" data-parsley-validate="">
        {!! csrf_field() !!}
        {{method_field('post')}}

        <input type="hidden" name="email" value="{{$email}}">
        <input type="hidden" name="token" value="{{$token}}">

        <h2 class="form-signin-heading">{{_i('Reset Password')}}</h2>
        <div class="login-wrap">

            @if ($errors->all())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <input type="email" class="form-control" name="email" value="{{old('email')}}" placeholder="{{_i('User Email')}}" autofocus required="">
            <input type="password" class="form-control" name="password" placeholder="{{_i('Password')}}" id="password" required=""  min="6" data-parsley-min="6">
            <input type="password" class="form-control" name="password_confirmation" placeholder="{{_i('Confirm Password')}}" required=""  min="6" data-parsley-min="6" data-parsley-equalto="#password">
            <button class="btn btn-lg btn-login btn-block" type="submit">{{_i('Reset')}}</button>
        </div>
    </form>


</div>



<!-- js placed at the end of the document so the pages load faster -->
<script src="{{asset('master/js/jquery.js')}}"></script>
<script src="{{asset('master/js/bootstrap.min.js')}}"></script>
<script src="{{ asset('custom/parsley.min.js') }}"></script>


</body>
</html>
