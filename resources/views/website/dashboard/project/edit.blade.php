<?php
if ($service) {
    $title = _i('Sell');
} else {
    $title = _i('Buy');
}

$type = $project->type;

//$arr =$project->Attributes->toArray() ;
//$arr_attributes =(array_combine(array_column($arr,"id"),$arr));
//dd($project->SelectedValue->toArray(),$arr);

?>
@extends('website.dashboard.index_inner', ["form"=>true,'title' => $title])

@section('content')

    <!--Breadcrumb-->
    <section>
        <div class="bannerimg cover-image bg-background3"
            data-image-src="{{ asset('website2/assets/images/banners/banner2.jpg') }}">
            <div class="header-text mb-0">
                <div class="container">
                    <div class="text-center text-white ">
                        <h1 class="">{{ $title }}</h1>
                        <ol class=" breadcrumb text-center">
                            <li class="breadcrumb-item"><a href="{{ route('WebsiteHome') }}">{{ _i('Home') }}</a></li>
                            <li class="breadcrumb-item active text-white" aria-current="page">{{ $title }}</li>
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



                <div class="col-xl-12 col-lg-12 col-md-12">
                    <div class="card mb-0">
                        <div class="card-header">
                            <h3 class="card-title">{{ $title }}</h3>

                        </div>

                        <div class="card-body">
                            <form class="php-email-form form-horizontal tasi-form" method="Post"
                                action="{{ $project->id }}/publish">
                                @csrf
                                <h5>
                                    <button class="btn btn-default pull-{{ \App\Help\Utility::getLangCode() == 'ar' ? 'left' : 'right' }} " name="publish"
                                        type="submit">{{ _i('Publish') }}</button>

                                    <i
                                        class="badge badge-{{ $project->Status()->first() != null ? $project->Status()->first()->code : '' }}">{{ $project->Status()->first() != null ? $project->Status()->first()->title : '' }}</i>

                                </h5>
                            </form>
                            <form class="php-email-form form-horizontal tasi-form" method="Post"
                                enctype="multipart/form-data" action="" data-parsley-validate="">
                                {{-- <input type="hidden" name="_method" value="PUT"> --}}
                                @csrf

                                {{-- <div class="form-group">
                                    <input type="text" id="title" class="form-control" name="title" required=""
                                        value="{{ $project->title }}" placeholder="{{ _i('Title') }}">
                                </div> --}}

                                <div class="form-group">
                                    <label for="">{{ _i('Category') }}</label>
                                    @php
                                        $list = \App\Help\Utility::getCategoriesWithType($type);
                                        //dd($list,$type);
                                    @endphp
                                    <select class="form-control" required="" name="category" onchange="getAttr()"
                                        id="sel_category">
                                        <option value="">---</option>
                                        <?php

                                        // $obj = new \App\Help\Category();
                                        // $list = $obj->selectTreeArray();
                                        $selected_list = $project
                                            ->Category()
                                            ->get()
                                            ->pluck('id')
                                            ->toArray();
                                        foreach ($list as $key => $value) {



                                        $selected = in_array($value["id"], $selected_list) ? 'selected' : ''; ?>
                                        <option {{ $selected }} value="{{ $value['id'] }}">{{ $value['title'] }}
                                        </option>

                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group" id="attr">
                                    {{-- @include("website.dashboard.project.partial.attributes",["project"=>$project]) --}}
                                </div>
                                {{-- <div class="form-group">
                                    <label for="">{{ _i('Skills') }}</label>
                                    <?php
                                    // $selected_list = $project
                                    // ->Skills()
                                    // ->get()
                                    // ->pluck('id')
                                    // ->toArray();
                                    ?>
                                    <select class="js-example-basic-multiple form-control" multiple="multiple" name="skills[]">
                                        <option value="">...</option>
                                        @foreach (App\Help\Skills::GetAll() as $item)
                                            <?php //$selected = in_array($item->skill_id, $selected_list) ? 'selected' : '';
                                            ?>
                                            <option {{ $selected }} value="{{ $item->skill_id }}">{{ $item->title }}</option>
                                        @endforeach

                                    </select>
                                </div> --}}

                                {{-- <div class="input-group mb-3">

                                    <input type="number" min="{{ \App\Help\Settings::getBudget() }}" id="budget"
                                        class="form-control" name="budget" required="" value="{{ $project->budget }}"
                                        placeholder="{{ _i('Budget') }}">
                                    <div class="input-group-append">
                                        <span class="input-group-text">{{ \App\Help\Settings::getCurrency() }}</span>
                                    </div>
                                </div> --}}

                                @include("website.dashboard.project.partial.basic")
                                {{-- <div class="input-group mb-3">
                                        <input type="number" min="{{ \App\Help\Settings::getDuration() }}" id="duration" class="form-control"
                                               name="duration"  value="{{ $project->duration }}" placeholder="{{ _i('Duration') }}">
                                        <div class="input-group-append">
                                            <span class="input-group-text">{{ _i('Days') }}</span>
                                        </div>
                                    </div> --}}




                                {{-- <div class="input-group mb-3">
                                    <input type="file" name="attach[]" class="form-control multi {
                                                            accept:'gif|jpg',
                                                            max:3,
                                                            STRING:{
                                                              remove:'Remover',
                                                              selected:'Selecionado: $file',
                                                              denied:'{{ _i('Invalid type file') }} $ext!',
                                                              duplicate:'{{ _i('File already selected') }}:\n$file!'
                                                            }
                                                          }" />
                                    @include("website.dashboard.project.partial.attach",["project" => $project])
                                </div> --}}
                                <div class="mb-12 text-center">
                                    <button class="btn btn-primary col-lg-12" type="submit">{{ _i('Update') }} <i
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
@endsection


@push('css')

    <link rel="stylesheet" type="text/css" href="{{ asset('custom/select2/css/select2.min.css') }}" />

@endpush
@push('js')
    <script type="text/javascript" src="{{ asset('custom/select2/js/select2.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $(".js-example-basic-single").select2();

            $(".js-example-basic-multiple").select2();
        });
    </script>

    <script src="{{ asset('custom/jquery.MultiFile.min.js') }}"></script>
    <script>
        $(function() {
            getAttr();
        });


    </script>
@endpush
