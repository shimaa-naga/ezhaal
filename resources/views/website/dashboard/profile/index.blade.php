@extends('website.dashboard.index_inner', ['title' => _i('Profile'),'header_title' => _i('Profile')])

@section('content')

    <!--Breadcrumb-->
    <section>
        <div class="bannerimg cover-image bg-background3" data-image-src="{{asset('website2/assets/images/banners/banner2.jpg')}}">
            <div class="header-text mb-0">
                <div class="container">
                    <div class="text-center text-white ">
                        <h1 class="">{{_i('My Profile')}}</h1>
                        <ol class="breadcrumb text-center">
                            <li class="breadcrumb-item"><a href="{{ route('WebsiteHome') }}">{{_i('Home')}}</a></li>
                            <li class="breadcrumb-item active text-white" aria-current="page">{{_i('My Profile')}}</li>
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
                            <h3 class="card-title">{{_i('Edit Profile')}}</h3>
                        </div>


                        <div class="card-body">


                            <div class="card mb-3">
                                <form  method="POST" action="{{ route('website.profile.save') }}" data-parsley-validate="" enctype="multipart/form-data">
                                    @csrf
                                    <div class="card-body">


                                        <div class="row">
                                            <div class="col ">
                                                <label>{{_i('Introductory profile')}} :</label>
                                                <textarea class="form-control" rows="5" name="about" placeholder="{{_i('Please write your profile here')}}...">{{$user_info->about??""}}</textarea>
                                            </div>
                                        </div><hr>
                                        <div class="row">
                                            <div class="col-md-12">
                                            <div class="form-group mb-0">
                                                <label class="form-label">{{_i('Upload CV')}} :</label>
                                                @if($user_info != null)
                                                    @if($user_info->cv!=null && file_exists(public_path($user_info->cv)))
                                                        <a href="{{ asset($user_info->cv) ?? ''  }}" download=""
                                                           class="btn btn-success col-sm-3">{{ _i('cv') }} <i class="fa fa-download"></i></a> <br><br>
                                                    @endif
                                                    <div class="custom-file">
                                                        <input type="file" class="form-control custom-file-input" name="cv" title="{{_i('Update CV')}}">
                                                        <label class="custom-file-label" title="{{_i('Update CV')}}">{{_i('Choose file')}}</label>
                                                    </div>
                                                @else
                                                    <div class="custom-file">
                                                        <input type="file" class="form-control custom-file-input" name="cv" title="{{_i('Upload CV')}}">
                                                        <label class="custom-file-label" title="{{_i('Upload CV')}}">{{_i('Choose file')}}</label>
                                                    </div>
                                                @endif

                                            </div>
                                            </div>
                                        </div><hr>

                                        <button type="submit" class="btn btn-primary col-lg-3">{{_i('Save')}} <i class="fa fa-save"></i></button>
                                    </div>
                                </form>
                            </div>


                        </div>


                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/User Dashboard-->
@endsection
