
@extends('master.layout.index' ,['title' => _i('Create Admin')])

@section('content')
    <!--breadcrumbs start -->
    <div class="page-header">
        <h4 class="page-title">{{ _i('Create Admin') }}</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('MasterHome') }}"><i class="fa fa-home"></i> {{ _i('Home') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('master.admins') }}"> {{ _i('Admins') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ _i('Create Admin') }}</li>
        </ol>
    </div>
    <!--breadcrumbs end -->

    <!-- page start-->
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        {{ _i('Create new admin') }}
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('master.admins.store') }}" class="form-horizontal"  id="demo-form" data-parsley-validate="" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body card-block">
                            <div class="form-group ">
                                <div class="row">
                                <label for="name" class="col-sm-2 col-form-label" >{{ _i('First name') }}</label>
                                <div class="col-sm-6">
                                    <input id="name" type="text"  class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}"  placeholder=" {{_i('First Name')}}" required="">
                                    @if ($errors->has('name'))
                                        <span class="text-danger invalid-feedback" role="alert">
											<strong>{{ $errors->first('name') }}</strong>
										</span>
                                    @endif
                                </div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="row">
                                <label for="name" class="col-sm-2 col-form-label" >{{ _i('Last name') }}</label>
                                <div class="col-sm-6">
                                    <input  type="text"  class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" value="{{ old('last_name') }}"  placeholder=" {{_i('Last Name')}}" data-parsley-maxlength="191">
                                    @if ($errors->has('last_name'))
                                        <span class="text-danger invalid-feedback" role="alert">
											<strong>{{ $errors->first('last_name') }}</strong>
										</span>
                                    @endif
                                </div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="row">
                                <label for="email" class="col-sm-2 col-form-label">{{ _i('Email') }}</label>
                                <div class="col-sm-6">
                                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder=" Email" required="" data-parsley-maxlength="191">
                                    @if ($errors->has('email'))
                                        <span class="text-danger invalid-feedback" role="alert">
											<strong>{{ $errors->first('email') }}</strong>
										</span>
                                    @endif
                                </div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="row">
                                <label for="password" class="col-sm-2 col-form-label">{{ _i('Password') }}</label>
                                <div class="col-sm-6">
                                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="{{_i('Password')}}" required="" data-parsley-maxlength="191">
                                    @if ($errors->has('password'))
                                        <span class="text-danger invalid-feedback" role="alert">
											<strong>{{ $errors->first('password') }}</strong>
										</span>
                                    @endif
                                </div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="row">
                                <label for="password-confirm" class="col-sm-2 col-form-label">{{ _i('Confirm password') }}</label>
                                <div class="col-sm-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="{{_i('Confirm password')}}" min="6" data-parsley-min="6" data-parsley-equalto="#password" required="" >
                                </div>
                                </div>
                            </div>
                            {{--                            <div class="form-group row">--}}
                            {{--                                <label class="col-sm-2 col-form-label" for="image">{{_i('Image')}}</label>--}}
                            {{--                                <div class="col-sm-6">--}}
                            {{--                                    <input type="file" name="image" id="image" class="form-control" accept="image/gif, image/jpeg, image/png" value="{{old('image')}}" required="">--}}
                            {{--                                    <span class="text-danger invalid-feedback">--}}
                            {{--										<strong>{{$errors->first('image')}}</strong>--}}
                            {{--									</span>--}}
                            {{--                                </div>--}}
                            {{--                            </div>--}}

                            <div class="form-group ">
                                <div class="row">
                                <label class="col-sm-2 col-form-label" for="image">{{_i('Image')}}</label>
                                <div class="col-sm-6">
                                    <input type="file" name="image" id="image"
                                           class="btn btn-default" accept="image/gif, image/jpeg, image/png" value="{{old('image')}}" >
                                    <span class="text-danger invalid-feedback">
										<strong>{{$errors->first('image')}}</strong>
									</span>
                                </div>
                                </div>
                            </div>

                            <div class="form-group ">
                                <div class="row">
                                <label for="email" class="col-sm-2 col-form-label">{{ _i('Mobile') }}</label>
                                <div class="col-sm-6">
                                    <input  type="number" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" value="{{old('phone')}}" data-parsley-maxlength="15">
                                    @if($errors->has('phone'))
                                        <span class="text-danger invalid-feedback" role="alert">
											<strong>{{ $errors->first('phone') }}</strong>
										</span>
                                    @endif
                                </div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="row">
                                <label for="password" class="col-sm-2 col-form-label">{{ _i('Role') }}</label>
                                <div class="col-sm-6">
                                    <select class="form-control{{ $errors->has('role') ? ' is-invalid' : '' }}" name="role" required="">
                                        @foreach($roles as  $role)
                                            <option value="{{$role->id}}" > {{$role->name}} </option>
                                        @endforeach
                                        @if ($errors->has('role'))
                                            <span class="text-danger invalid-feedback" role="alert">
												<strong>{{ $errors->first('role')}}</strong>
											</span>
                                        @endif
                                    </select>
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary col-sm-4">{{ _i('Add') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- page end-->

@endsection

