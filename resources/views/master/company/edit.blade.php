@extends('master.layout.index' ,['title' => _i('Edit Buyer')])

@section('content')
    <!--breadcrumbs start -->
    <div class="page-header">
        <h4 class="page-title">{{ _i('Buyers') }}</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('MasterHome') }}"><i class="fa fa-home"></i> {{ _i('Home') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ url('master/company') }}">{{ _i('Buyers') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ _i('Edit Buyer') }}</li>
        </ol>
    </div>
    <!--breadcrumbs end -->

    <!-- page start-->

    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form method="post" action="{{ route('company.update', $user->id) }}" class="form-horizontal"
                          enctype="multipart/form-data" data-parsley-validate="">
                        @csrf
                        @method('PATCH')


                    <div class="panel panel-primary">
                        <div class="tab-menu-heading">
                            <div class="tabs-menu ">
                                <!-- Tabs -->
                                <ul class="nav panel-tabs">
                                    <li class="active">
                                        <a  class=" active" data-toggle="tab" href="#about-2">
                                            <i class="fa  fa-building-o"></i> {{ _i('Institute Details') }}
                                        </a>
                                    </li>
                                    <li class="">
                                        <a data-toggle="tab" href="#contact-2">
                                            <i class="fa fa-user"></i> {{ _i('Account Details') }}
                                        </a>
                                    </li>
                                    <li>
                                        <button type="button" class="btn btn-warning " data-toggle="modal"
                                                data-target="#default-Modal">{{ _i('Reset Password') }}</button>
                                    </li>
                                </ul>


                            </div>
                        </div>
                        <div class="panel-body tabs-menu-body">
                        <div class="tab-content">

                            <div id="about-2" class="tab-pane active">
                                <div class="form-group ">
                                    <div class="row">
                                    <label for="name" class="col-sm-2 col-form-label">{{ _i('Name') }}</label>
                                    <div class="col-sm-6">
                                        <input id="name" type="text"
                                               class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                               name="name" value="{{ $user->name }}" required=""
                                               data-parsley-maxlength="191">
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
                                    <label for="name" class="col-sm-2 col-form-label">{{ _i('CR Number') }}</label>
                                    <div class="col-sm-6">
                                        <input id="name" type="text"
                                               class="form-control{{ $errors->has('cr_number') ? ' is-invalid' : '' }}"
                                               name="cr_number" value="{{ $company->cr_number }}" required=""
                                               data-parsley-maxlength="191">
                                        @if ($errors->has('cr_number'))
                                            <span class="text-danger invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('cr_number') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <div class="row">
                                    <label for="email" class="col-sm-2 col-form-label">{{ _i('Mobile') }}</label>
                                    <div class="col-sm-6">
                                        <input type="number"
                                               class="form-control{{ $errors->has('mobile') ? ' is-invalid' : '' }}"
                                               name="mobile" value="{{ $user->mobile }}" data-parsley-maxlength="15">
                                        @if ($errors->has('mobile'))
                                            <span class="text-danger invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('mobile') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    </div>
                                </div>

                                <div class="form-group ">
                                    <div class="row">
                                    <label class="col-sm-2 col-form-label">{{ _i('Country') }} </label>
                                    <div class="col-sm-6">
                                        <select class="form-control" id="country_id" name="country_id">
                                            <option selected>
                                                {{ _i('Choose Country') }}</option>
                                            @foreach ($countries as $country)
                                                <option value="{{ $country->country_id }}">
                                                    {{ $country->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <div class="row">
                                    <label class="col-sm-2 col-form-label">{{ _i('City') }}

                                    </label>
                                    <div class="col-sm-6">
                                        <select class="form-control" id="city_id" name="city_id">
                                        </select>
                                    </div>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <div class="row">
                                    <label for="name" class="col-sm-2 col-form-label">{{ _i('Address') }}</label>
                                    <div class="col-sm-6">
                                        <textarea class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}"
                                                  name="address">{{ $company->address }}</textarea>
                                        @if ($errors->has('address'))
                                            <span class="text-danger invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('address') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <div class="row">
                                    <label for="info" class="col-sm-2 col-form-label">{{ _i('About') }}</label>
                                    <div class="col-sm-6">
                                        <textarea class="form-control{{ $errors->has('about') ? ' is-invalid' : '' }}"  name="about">@php
                                                if( $user->info!=null) $user->info->about
                                            @endphp</textarea>
                                        @if ($errors->has('about'))
                                            <span class="text-danger invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('about') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    </div>
                                </div>
                            </div>

                            <div id="contact-2" class="tab-pane ">
                                <div class="form-group ">
                                    <div class="row">
                                    <label for="email" class="col-sm-2 col-form-label">{{ _i('Email') }}</label>
                                    <div class="col-sm-6">
                                        <input id="email" type="email"
                                               class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                               name="email" value="{{ $user->email }}" required=""
                                               data-parsley-maxlength="191">
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
                                    <label class="col-sm-2 col-form-label" for="image">{{ _i('Logo') }}</label>
                                    <div class="col-sm-6">
                                        <input type="file" name="image" id="image" class="btn btn-default"
                                               accept="image/gif, image/jpeg, image/png" value="{{ old('image') }}">
                                        <span class="text-danger invalid-feedback">
                                            <strong>{{ $errors->first('image') }}</strong>
                                        </span>
                                    </div>
                                    </div>
                                </div>
                                @if (!empty($user->image))
                                    <div class="form-group ">
                                        <span class="col-sm-2 "></span>
                                        <div class="col-sm-6">
                                            <img src="{{ asset($user->image) }}" class="img-thumbnail "
                                                 style="margin-top: -12px; max-height: 150px; max-width: 150px;">
                                        </div>
                                    </div>
                                @endif

                                <div class="form-group ">
                                    <div class="row">
                                    <label for="email" class="col-sm-2 col-form-label">{{ _i('Status') }}</label>
                                    <label class="col-sm-6 control-label" id="user_status">
                                        <input onchange="active({{ $company->id }})" type="checkbox"
                                               class="js-switch-blue" {{ $company->active == 1 ? 'checked' : '' }} />
                                        @if ($user->is_active == 1)
                                            <div class="badge badge-success btn btn-success"> {{ _i('Active') }}</div>
                                        @else
                                            <div class="badge badge-warning btn btn-warning"> {{ _i('Not Active') }}
                                            </div>
                                        @endif

                                    </label>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <button type="submit" class="btn btn-primary col-sm-12 "> {{ _i('Save') }}</button>
                        </div>

                    </div>


                    </form>
                </div>

            </div>
        </div>
    </div>



    <!-- password model start-->
    <div class="modal fade modal_password" id="default-Modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> {{ _i('Change password') }} </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <form method="post" id="change_password" action="{{ route('master.admins.change_password', $user->id) }}"
                    class="form-horizontal" data-parsley-validate="">
                    @csrf
                    @method('POST')
                    {{ method_field('POST') }}
                    <div class="modal-body">
                        <div class="form-group ">
                            <div class="row">
                            <label for="name" class="col-sm-4 control-label">{{ _i('Change password') }}</label>
                            <div class="col-sm-8">
                                <input id="password" type="password"
                                    class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                    name="password" value="{{ old('password') }}" required="" min="6"
                                    data-parsley-min="6" placeholder="{{ _i('Change Password') }}">
                            </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="row">
                            <label for="name" class="col-sm-4 control-label">{{ _i('Confirm Password') }}</label>
                            <div class="col-sm-8">
                                <input type="password" name="password_confirmation"
                                    class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}"
                                    value="{{ old('password_confirmation') }}" required="" min="6" data-parsley-min="6"
                                    data-parsley-equalto="#password" placeholder="{{ _i('Confirm Password') }}">
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button data-dismiss="modal" class="btn btn-default" type="button">{{ _i('Close') }}</button>
                        <button type="submit" class="btn btn-primary waves-effect waves-light "> {{ _i('Save') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- password model end-->

@endsection
@push('css')
    <link rel="stylesheet" type="text/css" href="/master/assets/switchery/switchery.css" />
@endpush
@push('js')
    <script src="/master/assets/switchery/switchery.js"></script>
    <script>
         function active(id) {
            $.ajax({
                url: "/master/company/"+id +"/activate",
                type: 'POST',
                dataType: 'json',
                data: {
                    method: 'POST',
                    submit: true,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    // console.log(response);
                    if (response === "success") {
                        new Noty({
                            type: 'success',
                            layout: 'topRight',
                            text: "{{ _i('Updated Successfully') }}",
                            timeout: 2000,
                            killer: true
                        }).show();

                    }
                },
                error: function(response) {
                    new Noty({
                            type: 'error',
                            layout: 'topRight',
                            text: "{{ _i('Not found') }}",
                            timeout: 2000,
                            killer: true
                        }).show();
                }
            });
        }
        $(function() {
            var elems = $('.js-switch-blue');
                    $.each(elems, function(i, elem) {
                        var switchery = new Switchery(elem, {
                            color: '#7c8bc7',
                            jackColor: '#9decff'
                        });
                    });
            $('#country_id').val({{ $user->country_id }});
            loadCity({{ $user->country_id }});

        });
        $('#country_id').change(function() {
            var countryID = $(this).val();
            loadCity(countryID);
        });

        function loadCity(countryID) {
            if (countryID) {
                $.ajax({
                    type: "GET",
                    url: "{{ route('website.city.list') }}?country_id=" + countryID,
                    dataType: 'json',
                    success: function(res) {
                        if (res) {
                            $("#city_id").empty();
                            //$("#country_id_add").append('<option disabled selected>{{ _i('Choose') }}</option>');
                            $.each(res, function(key, value) {
                                $("#city_id").append('<option value="' + key + '">' + value +
                                    '</option>');
                            });

                        } else {
                            $("#city_id").empty();
                        }
                    }
                });
            } else {
                $("#city_id").empty();
            }
        }
        $('#change_password').submit(function(e) {
            e.preventDefault();
            var url = $(this).attr('action');
            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                data: new FormData(this),
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    // console.log(response);
                    if (response.data === true) {
                        new Noty({
                            type: 'success',
                            layout: 'topRight',
                            text: "{{ _i('Saved Successfully') }}",
                            timeout: 2000,
                            killer: true
                        }).show();
                        $('.modal.modal_password').modal('hide');
                    }
                }
            });
        });

    </script>
@endpush
