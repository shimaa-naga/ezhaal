@extends('master.layout.index' ,['title' => _i('Profile')])

@section('content')
    <!--breadcrumbs start -->
    <div class="page-header">
        <h4 class="page-title">{{ _i('Profile') }}</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('MasterHome') }}"><i class="fa fa-home"></i> {{ _i('Home') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ _i('Profile') }}</li>
        </ol>
    </div>
    <!--breadcrumbs end -->

    <!-- page start-->
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        {{ _i('Profile details') }}
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('master.profile.update') }}" class="form-horizontal" enctype="multipart/form-data"  data-parsley-validate="">
                        @csrf
                        @method('POST')
                        <div class="form-group ">
                            <div class="row">
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
                        </div>
                        <div class="form-group ">
                            <div class="row">
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
                        </div>
                        <div class="form-group ">
                            <div class="row">
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
                        </div>
                        <div class="form-group ">
                            <div class="row">
                            <label class="col-sm-2 col-form-label" for="image">{{_i('Image')}}</label>
                            <div class="col-sm-6">
                                <input type="file" name="image"  onchange="showImgEdit(this)"
                                       class="btn btn-default" accept="image/gif, image/jpeg, image/png" value="{{old('image')}}" >
                                <span class="text-danger invalid-feedback">
										<strong>{{$errors->first('image')}}</strong>
									</span>
                            </div>
                        </div>
                        </div>
                        @if(!empty($user->image))
                            <div class="form-group ">
                                <div class="row">
                                <span class="col-sm-2 "></span>
                                <div class="col-sm-6">
                                    <img src="{{asset($user->image)}}" id="old_imge" class="img-thumbnail " style="margin-top: -12px; height: 100px; width: 100px;">
                                </div>
                            </div>
                            </div>
                        @endif
                        <div class="form-group ">
                            <div class="row">
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
                        </div>

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary col-sm-3 "> {{ _i('Save')}}</button>
                            <button type="button" class="btn btn-warning col-sm-3" data-toggle="modal" data-target="#default-Modal">{{_i('Change Password')}}</button>
                        </div>
                    </form>
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
                <form method="post" id="change_password" action="{{ route('master.profile.change_password') }}" class="form-horizontal"  data-parsley-validate="">
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

        function showImgEdit(input) {
            var filereader = new FileReader();
            filereader.onload = (e) => {
                //console.log(e);
                $("#old_imge").attr('src', e.target.result).width(100).height(100);
            };
            //console.log(input.files);
            filereader.readAsDataURL(input.files[0]);
        }
    </script>
@endpush
