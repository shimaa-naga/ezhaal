<div class=" mb-0">
    <div class="card-header border-0">
        <h3 class="card-title">{{_i("Create an Account")}}</h3>
    </div>
    <div class="card-body">
        <div class="text-center">
            @include("website.dashboard.project.partial.login.social")
        </div>
        <hr class="divider">
        <div class="form-group">
            {{-- <label class="form-label text-dark">Name</label> --}}
            <input type="text" required data-parsley-group="register" name="name" class="form-control" placeholder="{{_i('Name')}}">
        </div>
        <div class="form-group">
            {{-- <label class="form-label text-dark">Email address</label> --}}
            <input type="email" required data-parsley-group="register" name="email" class="form-control" placeholder="{{_i('Email address')}}">
        </div>
        <div class="form-group">
            {{-- <label class="form-label text-dark">Password</label> --}}
            <input type="password" required data-parsley-group="register"  name="password" class="form-control" id="exampleInputPassword1" placeholder="{{_i('Password')}}">
        </div>
        <div class="form-group">
            <label class="custom-control custom-checkbox" >
                <input type="checkbox" required="" class="custom-control-input" data-parsley-group="register" name="agree">
                <span class="custom-control-label text-dark">{{_i("Agree the")}}
                    <a href="terms.html">{{_i("terms and policy")}}</a>
                </span>
            </label>
        </div>
        <div class="form-footer mt-2">

            <button type="button" onclick="register()" name="btnregister" class="btn btn-primary col-md-12">{{ _i('Create New Account') }}</button>
        </div>


    </div>
</div>
