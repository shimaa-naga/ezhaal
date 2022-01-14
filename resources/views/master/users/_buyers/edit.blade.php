@extends('master.layout.index' ,['title' => _i('Edit Buyer')])

@section('content')
    <!--breadcrumbs start -->
    <div class="page-header">
        <h4 class="page-title">{{ _i('Edit Buyer') }}</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('MasterHome') }}"><i class="fa fa-home"></i> {{ _i('Home') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ _i('Edit Buyer') }}</li>
        </ol>
    </div>
    <!--breadcrumbs end -->

    <!-- page start-->
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <h5> {{ _i('Edit Buyer') }} </h5>

                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('master.buyers.update', $user->id) }}" class="form-horizontal" enctype="multipart/form-data"  data-parsley-validate="">
                        @csrf
                        @method('PATCH')
                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">{{ _i('First name') }}</label>
                            <div class="col-sm-6">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ $user->name }}" required="" data-parsley-maxlength="191">
                                @if ($errors->has('name'))
                                    <span class="text-danger invalid-feedback" role="alert">
                                	<strong>{{ $errors->first('name') }}</strong>
                            	</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="last_name" class="col-sm-2 col-form-label">{{ _i('Last name') }}</label>
                            <div class="col-sm-6">
                                <input id="last_name" type="text" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" value="{{ $user->last_name }}" data-parsley-maxlength="191">
                                @if ($errors->has('last_name'))
                                    <span class="text-danger invalid-feedback" role="alert">
                                	<strong>{{ $errors->first('last_name') }}</strong>
                            	</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-sm-2 col-form-label">{{ _i('Email') }}</label>
                            <div class="col-sm-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{$user->email}}" required="" data-parsley-maxlength="191">
                                @if ($errors->has('email'))
                                    <span class="text-danger invalid-feedback" role="alert">
                                	<strong>{{ $errors->first('email') }}</strong>
                            	</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="image">{{_i('Image')}}</label>
                            <div class="col-sm-6">
                                <input type="file" name="image" id="image"
                                       class="btn btn-default" accept="image/gif, image/jpeg, image/png" value="{{old('image')}}" >
                                <span class="text-danger invalid-feedback">
										<strong>{{$errors->first('image')}}</strong>
									</span>
                            </div>
                        </div>
                        @if(!empty($user->image))
                            <div class="form-group ">
                                <span class="col-sm-2 "></span>
                                <div class="col-sm-6">
                                    <img src="{{asset($user->image)}}" class="img-thumbnail " style="margin-top: -12px; max-height: 150px; max-width: 150px;">
                                </div>
                            </div>
                        @endif
                        <div class="form-group row">
                            <label for="email" class="col-sm-2 col-form-label">{{ _i('Mobile') }}</label>
                            <div class="col-sm-6">
                                <input  type="number" class="form-control{{ $errors->has('mobile') ? ' is-invalid' : '' }}" name="mobile" value="{{$user->mobile}}" data-parsley-maxlength="15">
                                @if ($errors->has('mobile'))
                                    <span class="text-danger invalid-feedback" role="alert">
                                	<strong>{{ $errors->first('mobile') }}</strong>
                            	</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-sm-2 col-form-label">{{ _i('Status') }}</label>
                            <label class="col-sm-6 control-label" id="user_status">
                                @if($user->is_active == 1)
                                    <div class="badge badge-success btn btn-success"> {{_i("Active")}}</div>
                                @else
                                    <div class="badge badge-warning btn btn-warning"> {{_i("Not Active")}} </div>
                                @endif
                            </label>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-sm-2 col-form-label">{{ _i('Balance') }}</label>
                            <label class="col-sm-6 control-label" >
                                <div class="badge badge-warning btn btn-warning"> {{$user->balance}} </div>
                            </label>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-sm-2 col-form-label">{{ _i('DOB') }}</label>
                            <label class="col-sm-6 col-form-label" >
                                <div class="text-muted"> {{$user->dob}} </div>
                            </label>
                        </div>


                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary col-sm-3 "> {{ _i('Save')}}</button>
                            <button type="button" class="btn btn-warning col-sm-3" data-toggle="modal" data-target="#default-Modal">{{_i('Change Password')}}</button>
                        </div>
                    </form>
                    <div style="display: inline" class="show_button_status">
                        @if($user->is_active == 1)
                            <form method="Post" action="{{route('master.admins.changeStatus')}}"
                                  class="status_button disaple_form" style="display: inline">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                <input type="hidden" name="user_status" value="0">
                                <button type="submit" class="btn btn-primary  col-sm-3  ">
                                    {{_i('Deactivate')}}
                                </button>
                            </form>
                        @else
                            <form method="Post" action="{{route('master.admins.changeStatus')}}"
                                  class="status_button active_form" style="display: inline">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                <input type="hidden" name="user_status" value="1">
                                <button type="submit" class="btn btn-primary  col-sm-3">
                                    {{_i('Activate')}}
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- page end-->

    <!-- password model start-->
    <div class="modal fade modal_password" id="default-Modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> {{_i('Change password')}} </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <form method="post" id="change_password" action="{{ route('master.admins.change_password', $user->id) }}" class="form-horizontal"  data-parsley-validate="">
                    @csrf
                    @method('POST')
                    {{ method_field('POST') }}
                    <div class="modal-body">
                        <div class="form-group row">
                            <label for="name" class="col-sm-4 control-label">{{ _i('Change password') }}</label>
                            <div class="col-sm-8">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" value="{{old('password')}}" required="" min="6" data-parsley-min="6" placeholder="{{_i('Change Password')}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-4 control-label">{{ _i('Confirm Password') }}</label>
                            <div class="col-sm-8">
                                <input type="password" name="password_confirmation"  class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" value="{{old('password_confirmation')}}" required=""  min="6" data-parsley-min="6" data-parsley-equalto="#password" placeholder="{{_i('Confirm Password')}}">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button data-dismiss="modal" class="btn btn-default" type="button">{{_i('Close')}}</button>
                        <button type="submit" class="btn btn-primary waves-effect waves-light "> {{_i('Save')}} </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- password model end-->

@endsection

@push('js')
    <script>
        $('#change_password').submit(function (e) {
            e.preventDefault();
            var url = $(this).attr('action');
            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                data: new FormData(this),
                cache       : false,
                contentType : false,
                processData : false,
                success: function (response) {
                    // console.log(response);
                    if (response.data === true){
                        new Noty({
                            type: 'success',
                            layout: 'topRight',
                            text: "{{ _i('Saved Successfully')}}",
                            timeout: 2000,
                            killer: true
                        }).show();
                        $('.modal.modal_password').modal('hide');
                    }
                }
            });
        });

        $('body').on('submit', '.status_button', function (e) {
            e.preventDefault();
            var url = $(this).attr('action');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var form = $(this);
            $.ajax({
                url: url,
                method: "POST",
                data: new FormData(this),
                type: 'POST',
                datatype: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response.is_active == 1) {
                        $('#user_status').empty();
                        $('#user_status').append(
                            '<div class="badge badge-info btn btn-success" > {{_i(" Active ")}}</div>');
                        $('.show_button_status').empty();
                        $('.show_button_status').append('<form method="Post" action="{{route('master.admins.changeStatus')}}" class="status_button disaple_form" style="display: inline">' +
                            '{{method_field('post')}} <input type="hidden" name="user_id" value="{{$user->id}}"> <input type="hidden" name="user_status" value="0">' +
                            '<button type="submit" class="btn btn-primary col-sm-3"> {{_i('Deactivate')}}</button></form>');
                    } else {
                        $('#user_status').empty();
                        $('#user_status').append(
                            '<div class="badge badge-warning btn btn-warning" > {{_i(" Not Active ")}} </div>');
                        $('.show_button_status').empty();
                        $('.show_button_status').append('<form method="Post" action="{{route('master.admins.changeStatus')}}" class="status_button disaple_form" style="display: inline">' +
                            '{{method_field('post')}} <input type="hidden" name="user_id" value="{{ $user->id }}"> <input type="hidden" name="user_status" value="1">' +
                            '<button type="submit" class="btn btn-primary col-sm-3"> {{_i('Activate')}} </button>  </form>');
                    }
                    if(response.is_active !== undefined){
                        new Noty({
                            type: 'success',
                            layout: 'topRight',
                            text: "{{ _i('Changes saved successfully') }}",
                            timeout: 2000,
                            killer: true
                        }).show();
                    }
                },
            });
        });
    </script>
@endpush
