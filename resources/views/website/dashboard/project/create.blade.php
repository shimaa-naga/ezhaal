<?php
if ($service) {
    $title = _i('Sell');
} else {
    $title = _i('Buy');
}
$old = request()->old();
//dd(old());
?>
@extends('website.dashboard.index_inner', ['title' => $title])

@section('content')

    <!--Breadcrumb-->
    <section>

        <div class="bannerimg cover-image bg-background3"
            data-image-src="{{ asset('website2/assets/images/banners/banner2.jpg') }}">
            <div class="header-text mb-0">
                <div class="container">
                    <div class="text-center text-white ">
                        <h1 class="">
                            {{ $title }}
                        </h1>
                        <ol class="
                            breadcrumb text-center">
                            <li class="breadcrumb-item"><a href="{{ route('WebsiteHome') }}">{{ _i('Home') }}</a></li>
                            <li class="breadcrumb-item active text-white" aria-current="page">
                                {{ $title }}
                            </li>
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
            @include('website.sessions_messages',["form"=>true])

            <div class="row">


                <div class="col-xl-3 col-lg-12 col-md-12">
                    <div class="card">
                        @php
                            $data = \App\Help\Settings::GetIntro();
                            $code = \App\Help\Utility::getLangCode();
                            //dd($code);
                        @endphp
                        <div class="card-header">
                            <h3 class="card-title"> {!! $data->title->{$code} !!}</h3>
                        </div>
                        <div class="card-body">

                            {!! nl2br($data->intro->{$code}) !!}
                        </div>

                    </div>


                </div>




                <div class="col-xl-9 col-lg-12 col-md-12">
                    <div class="card mb-0">
                        <div class="card-header">
                            <h3 class="card-title">
                                {{ $title }}
                            </h3>
                        </div>

                        <div class="card-body">
                            @csrf
                            <form class=" form-horizontal " method="post" enctype="multipart/form-data"
                                action="@auth {{ url('dash/project') }} @else {{ url('projects/store') }}  @endauth"
                                data-parsley-validate="" id="frm_create">
                                @csrf
                                <input type="hidden" name="type" value="{{ $service == true ? 'service' : 'project' }}">

                                {{-- <div class="form-group">
                                    <input type="hidden" id="title" class="form-control" name="title"
                                        value="{{ old('title') }}" placeholder="{{ _i('Title') }}">
                                </div> --}}

                                <div class="form-group">
                                    {{-- <label for="">{{ _i('Category') }}</label> --}}
                                    @php
                                        $type = 'project';
                                        if ($service === true) {
                                            $type = 'service';
                                        }
                                        $list_parent = \App\Help\Utility::getParentCategories($type);
                                        // $list_parent = \App\Help\Utility::getParentCategories();
                                        $list_parent = json_decode(json_encode($list_parent));

                                    @endphp


                                    <select class="form-control select2-show-search" required="" name="parent_category"
                                        onchange="parnet_selected()" id="sel_parent_category">
                                        <option value="">---</option>
                                        <?php foreach ($list_parent as $key => $value) {
                                   ?>
                                        <option value="{{ $value->id }}" imageUrl="{{ $value->imageUrl }}">
                                            {{ $value->title }} </option>

                                        <?php
                                    } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    {{-- @php
                                        $list = \App\Help\Utility::getCategories('project');
                                    @endphp --}}
                                    <select class="form-control select2-show-search" name="category" onchange="getAttr()"
                                        id="sel_category">
                                        <option value="">---</option>
                                    </select>
                                </div>
                                <div class="form-group" id="attr">
                                </div>

                                {{-- <div class="form-group">
                                    <textarea id="desc" rows="5" class="form-control" name="desc" required=""
                                        placeholder="{{ _i('Description') }}">{{ old('desc') }}</textarea>
                                </div> --}}

                              @include("website.dashboard.project.partial.basic")



                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary col-lg-3">{{ _i('Submit') }} <i
                                            class="fa fa-send"></i></button>
                                </div>
                            </form>

                        </div>


                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/User Dashboard-->
    @guest
        @include("website.dashboard.project.partial.login")

    @endguest
@endsection

@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('custom/select2/css/select2.min.css') }}" />

@endpush
@push('js')
    @guest
        <script>
            function login() {
                $("#btn").val("login");
                $('#frm_login_first').parsley().validate("login");
                if ($('#frm_login_first').parsley().isValid("login")) {
                    document.getElementById("frm_login_first").submit();
                }

            }

            function register() {
                $("#btn").val("register");
                $('#frm_login_first').parsley().validate("register");
                if ($('#frm_login_first').parsley().isValid("register")) {
                    document.getElementById("frm_login_first").submit();

                }

            }
            $('#frm_create').parsley().on('form:submit', function(formInstance) {
                // if you want to prevent submit in any condition after validation success -> return it false
                $('#prev_fields').html("");
                frm = $("#frm_create")[0];
                for (var i = 0; i < frm.length; i++) {
                    if (frm[i].type != "button" && frm[i].type != "submit") {
                        var elem = frm[i];
                        var clone = $.clone(elem);
                        if (elem.type == "select-one")
                            $(clone).val($(elem).val());
                        $('#prev_fields').append(clone);
                    }
                }
                //$("#prev_fields").html($(frm).html());
                $('#exampleModal3').modal('show');
                return false;

            });
        </script>
    @endguest
    <script type="text/javascript" src="{{ asset('custom/select2/js/select2.min.js') }}"></script>
    {{-- <script type="text/javascript">
        $(document).ready(function() {
            $(".js-example-basic-single").select2();

            $(".js-example-basic-multiple").select2();
        });
    </script> --}}

    <script src="{{ asset('custom/jquery.MultiFile.min.js') }}"></script>

@endpush
