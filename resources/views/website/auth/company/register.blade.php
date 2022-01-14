


<form class="login-form php-email-form" method="post" action="company/register" data-parsley-validate="">
@csrf

<div class="form-group">
    <label class="form-label text-dark">{{ _i('Institution Name') }}</label>
    <input type="text" class="form-control" name="name" value="{{ old('name') }}" required=""
           placeholder="{{ _i('Institution Name') }}">
</div>
<div class="form-group">
    <label class="form-label text-dark">{{_i('Email address')}}</label>
    <input type="email" id="sender-email" class="form-control" name="email" required=""
           value="{{ old('email') }}" placeholder="{{ _i('Email') }}">
</div>
<div class="form-group">
    <label class="form-label text-dark">{{_i('Password')}}</label>
    <input type="password" class="form-control" id="co_password" name="password" required=""
           placeholder="{{ _i('Password') }}">
</div>
<div class="form-group">
    <label class="form-label text-dark">{{_i('Retype Password')}}</label>
    <input type="password" class="form-control" required="" name="password_confirmation"
           data-parsley-equalto="#co_password" placeholder="{{ _i('Retype Password') }}">
</div>
<div class="form-footer mt-2">
    <button type="submit" class="btn btn-primary btn-block">{{_i('Create New Account')}}</button>
</div>

</form>
