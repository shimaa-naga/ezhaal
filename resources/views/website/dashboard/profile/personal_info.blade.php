@extends('website.dashboard.index_inner', ['title' => _i('Account details')])

@section('content')
    <!--Breadcrumb-->
    <section>
        <div class="bannerimg cover-image bg-background3" data-image-src="{{asset('website2/assets/images/banners/banner2.jpg')}}">
            <div class="header-text mb-0">
                <div class="container">
                    <div class="text-center text-white ">
                        <h1 class="">{{_i('Account details')}}</h1>
                        <ol class="breadcrumb text-center">
                            <li class="breadcrumb-item"><a href="{{ route('WebsiteHome') }}">{{_i('Home')}}</a></li>
                            <li class="breadcrumb-item active text-white" aria-current="page">{{_i('Account details')}}</li>
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

                @include('website.dashboard.profile.profile_nav')

                <div class="col-xl-9 col-lg-12 col-md-12">
                    <div class="card mb-0">
                        <div class="card-header">
                            <h3 class="card-title">{{_i('Edit Account')}}</h3>
                        </div>

                            <div class="card-body">


                                <div class="col">
                                    <div class="row">
                                        <div class="col mb-3">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="e-profile">
                                                        <div class="row">
                                                            <div class="col-12 col-sm-auto mb-3">
                                                                <div class="mx-auto" style="width: 140px;">
                                                                    <form  method="POST" id="fileupload" action="{{route('website.profile.update_logo')}}"  enctype="multipart/form-data">
                                                                        @csrf
                                                                        <div class="d-flex justify-content-center align-items-center rounded" >
                                                                            <img class="img-fluid img-circle" onclick="document.getElementById('image').click()"
                                                                                 src="@if($user->image!=null && file_exists(public_path($user->image))) {{asset($user->image) }} @else {{asset('uploads/users/user-default2.jpg')}} @endif">
                                                                            <input onchange="document.getElementById('fileupload').submit()" style="display: none;"  id="image" type="file" name="image">
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                            <div class="col d-flex flex-column flex-sm-row justify-content-between mb-3">
                                                                <div class="text-center text-sm-left mb-2 mb-sm-0">
                                                                    <h4 class="pt-sm-2 pb-1 mb-0 text-nowrap">{{$user->name ." ".$user->last_name}}</h4>
                                                                    <p class="mb-0">{{$user->user_name}}</p>
                                                                    <div class="text-muted"><small>{{$user->account_type}}</small></div>
                                                                    <br>
                                                                    <div class="mt-2">
                                                                        {{--                                                        <button class="btn btn-primary" type="button" >--}}
                                                                        {{--                                                            <input type="file"  hidden id="upload">--}}
                                                                        {{--                                                            <i  class="fa fa-fw fa-camera"></i>--}}
                                                                        {{--                                                            <label for="upload">{{_i('Change Photo')}}</label>--}}
                                                                        {{--                                                        </button>--}}
                                                                    </div>
                                                                </div>
                                                                <div class="text-center text-sm-right">
                                                                    <span class="badge badge-secondary">{{_i('administrator')}}</span>
                                                                    <div class="text-muted"><small>{{_i('Joined')}} {{date("d M Y", strtotime($user->created_at))}} </small></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <ul class="nav nav-tabs">
                                                            <li class="nav-item"><a href="" class="active nav-link">{{_i('Settings')}}</a></li>
                                                        </ul>
                                                        <div class="tab-content pt-3">
                                                            <div class="tab-pane active">
                                                                <form  class="form" method="POST" action="{{route('website.profile.update_personal_info')}}" data-parsley-validate="" enctype="multipart/form-data">
                                                                    @csrf
                                                                    @if(Session::has('msg'))
                                                                        {{--                                                        <h6 class="alert alert-danger text-center" > <b>   {{ Session::get('msg') }} </b></h6>--}}
                                                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                                            <strong>{{_i('Error')}}!</strong> {{ Session::get('msg') }} .
                                                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                    @endif
                                                                    @if ($errors->any())
                                                                        @foreach ($errors->all() as $error)
                                                                            {{--                                                            <div class="alert alert-danger text-center"> {{$error}}</div>--}}
                                                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                                                <strong>{{_i('Error')}}!</strong> {{$error}}
                                                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                        @endforeach
                                                                    @endif

                                                                    <div class="row">
                                                                        <div class="col">
                                                                            <div class="row ">
                                                                                <div class="col">
                                                                                    <div class="form-group">
                                                                                        <label>{{_i('First Name')}} <span class="text-danger">*</span></label>
                                                                                        <input class="form-control" type="text" name="name" value="{{$user->name}}" required="" placeholder="{{_i('Please enter first name here')}}">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col">
                                                                                    <div class="form-group">
                                                                                        <label>{{_i('Last Name')}}</label>
                                                                                        <input class="form-control" type="text" name="last_name" value="{{$user->last_name}}" placeholder="{{_i('Please enter last name here')}}" >
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="row">
                                                                                <div class="col">
                                                                                    <div class="form-group">
                                                                                        <label>{{_i('Email')}} <span class="text-danger">*</span></label>
                                                                                        <input class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" type="email" name="email" value="{{$user->email}}" required=""  placeholder="{{_i('Email : user@example.com')}}">
                                                                                        @if ($errors->has('email'))
                                                                                            <span class="text-danger invalid-feedback" role="alert">
											                                    <strong>{{ $errors->first('email') }}</strong>
										                                    </span>
                                                                                        @endif
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col">
                                                                                    <div class="form-group">
                                                                                        <label>{{_i('Country')}} <span class="text-danger">*</span></label>
                                                                                        <select class="form-control" id="country_id" required="" name="country_id" >
                                                                                            <option disabled selected>{{_i('Choose Country')}}</option>
                                                                                            @foreach($countries as $country)
                                                                                                <option value="{{$country->country_id}}" {{$user->country_id==$country->country_id?"selected":""}}>{{$country->title}}</option>
                                                                                            @endforeach
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col">
                                                                                    <div class="form-group">
                                                                                        <label>{{_i('City')}} <span class="text-danger">*</span></label>
                                                                                        <select class="form-control" id="city_id" required="" name="city_id" >

                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col">
                                                                                    <div class="form-group">
                                                                                        <label>{{_i('Mobile')}} <span class="text-danger">*</span></label>
                                                                                        <input class="form-control" type="number" name="mobile" value="{{$user->mobile}}" required=""
                                                                                               maxlength="11" data-parsley-maxlength="11"  placeholder="{{_i('Please enter mobile number here')}}">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col">
                                                                                    <div class="form-group">
                                                                                        <label>{{_i('DOB')}} <span class="text-danger">*</span></label>
                                                                                        <input class="form-control" type="date" name="dob" value="{{$user->dob}}" required="" >
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-12 col-sm-6 mb-3">
                                                                            <div class="mb-2"><b><a href="#" id="change_pass">{{_i('Change Password')}}</a></b></div>
                                                                            <div id="pass_div">
                                                                                <div class="row">
                                                                                    <div class="col">
                                                                                        <div class="form-group">
                                                                                            <label>{{_i('Current Password')}}</label>
                                                                                            <input class="form-control {{ $errors->has('old_password') ? ' is-invalid' : '' }}" type="password" name="old_password" placeholder="{{_i('Enter the password for your current account in Website')}}">
                                                                                            @if ($errors->has('old_password'))
                                                                                                <span class="text-danger invalid-feedback" role="alert">
                                                                                    <strong>{{ $errors->first('old_password') }}</strong>
                                                                                </span>
                                                                                            @endif
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col">
                                                                                        <div class="form-group">
                                                                                            <label>{{_i('New Password')}}</label>
                                                                                            <input class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" id="password" type="password" name="password" min="6" data-parsley-min="6" placeholder="{{_i('Enter the new password')}}">
                                                                                            @if ($errors->has('password'))
                                                                                                <span class="text-danger invalid-feedback" role="alert">
                                                                                    <strong>{{ $errors->first('password') }}</strong>
                                                                                </span>
                                                                                            @endif
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col">
                                                                                        <div class="form-group">
                                                                                            <label>{{_i('Confirm Password')}}</label>
                                                                                            <input class="form-control {{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" type="password" name="password_confirmation" min="6" data-parsley-min="6" data-parsley-equalto="#password" placeholder="{{_i('Enter confirmation new password')}}">
                                                                                            @if ($errors->has('password_confirmation'))
                                                                                                <span class="text-danger invalid-feedback" role="alert">
                                                                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                                                                </span>
                                                                                            @endif
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        {{--                                                        <div class="col-12 col-sm-5 offset-sm-1 mb-3">--}}
                                                                        {{--                                                            <div class="mb-2"><b>Keeping in Touch</b></div>--}}
                                                                        {{--                                                            <div class="row">--}}
                                                                        {{--                                                                <div class="col">--}}
                                                                        {{--                                                                    <label>Email Notifications</label>--}}
                                                                        {{--                                                                    <div class="custom-controls-stacked px-2">--}}
                                                                        {{--                                                                        <div class="custom-control custom-checkbox">--}}
                                                                        {{--                                                                            <input type="checkbox" class="custom-control-input" id="notifications-blog" checked="">--}}
                                                                        {{--                                                                            <label class="custom-control-label" for="notifications-blog">Blog posts</label>--}}
                                                                        {{--                                                                        </div>--}}
                                                                        {{--                                                                    </div>--}}
                                                                        {{--                                                                </div>--}}
                                                                        {{--                                                            </div>--}}
                                                                        {{--                                                        </div>--}}
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col d-flex justify-content-end">
                                                                            <button class="btn btn-primary" type="submit">{{_i('Save Changes')}}</button>
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
@push('js')
    <script>
        $("#pass_div").hide();
        $("#change_pass").click(function(e){
            e.preventDefault();
            $("#pass_div").toggle();
        });

        $.ajax({
            type:"GET",
            url:"{{route('website.city.list')}}?country_id="+`{{$user->country_id}}`,
            dataType:'json',
            success:function(res){
                if(res){
                    $("#city_id").empty();
                    //$("#country_id_add").append('<option disabled selected>{{ _i('Choose') }}</option>');
                    $.each(res,function(key,value){
                        $("#city_id").append('<option value="'+key+'">'+value+'</option>');
                    });

                }else{
                    $("#city_id").empty();
                }
            }
        });

        $('#country_id').click(function(){
            var countryID = $(this).val();

            if(countryID){
                $.ajax({
                    type:"GET",
                    url:"{{route('website.city.list')}}?country_id="+countryID,
                    dataType:'json',
                    success:function(res){
                        if(res){
                            $("#city_id").empty();
                            //$("#country_id_add").append('<option disabled selected>{{ _i('Choose') }}</option>');
                            $.each(res,function(key,value){
                                $("#city_id").append('<option value="'+key+'">'+value+'</option>');
                            });

                        }else{
                            $("#city_id").empty();
                        }
                    }
                });
            }else{
                $("#city_id").empty();
            }
        });
    </script>
@endpush
