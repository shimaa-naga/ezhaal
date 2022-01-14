@extends('website.layout.home', ['title' => _i('Home')])
@push('css')

@endpush
@section('slider')
    @include("website.home.slider")
    <div>
        <form class="" method="post" action="{{ url('projects/search') }}" data-parsley-validate="">
            <div class="banner-1 cover-image sptb-2 bg-background2"
                data-image-src="../website2/assets/images/banners/banner7.jpg">
                <div class="header-text mb-0">
                    <div class="container">
                        <div class="text-center text-white ">
                            <h1 class="mb-1">{{ _i('Search Your Favorite services') }}</h1>
                            <p>{{ _i('It is a long established fact that a reader will be distracted by the readable') }}.
                            </p>
                        </div>
                        <div class="row">


                            <div class="col-xl-8 col-lg-12 col-md-12 d-block mx-auto">

                                <div class=" search-background">
                                    <div class="form row no-gutters">
                                        @csrf
                                        <div class="form-group  col-xl-6 col-lg-5 col-md-12 mb-0">

                                            <input type="text" id="search" class="form-control input-lg border-right-0"
                                                name="title" required="" placeholder="{{ _i('keyword ...') }}">
                                        </div>
                                        <div class="form-group col-xl-4 col-lg-4 select2-lg  col-md-12 mb-0">
                                            <?php
                                            $list = \App\Help\Utility::getCategories('project');
                                            // dd($list);
                                            ?>
                                            <select class="form-control select2-show-search border-bottom-0 w-100"
                                                data-placeholder="Select" name="category">
                                                <optgroup label="{{ _i('Buy') }}"">

                                                        <option value="">---</option>
                                                        <?php
                                                    foreach ($list as  $key=>$value) { ?>
                                                        <option value=" {{ $value['id'] }}">{!! $value['title'] !!}
                                                    </option>

                                                    <?php }
                                                    ?>

                                                </optgroup>
                                                <optgroup label="{{ _i('Sell') }}"">

                                                        <option value="">---</option>
                                                        <?php
                                                         $list = \App\Help\Utility::getCategories('service');
                                                    foreach ($list as  $key=>$value) { ?>

                                                        <option value=" {{ $value['id'] }}">{!! $value['title'] !!}
                                                    </option>

                                                    <?php }
                                                    ?>

                                                </optgroup>
                                            </select>
                                        </div>
                                        <div class="col-xl-2 col-lg-3 col-md-12 mb-0">
                                            {!! Form::submit('Search', ['class' => 'btn btn-lg btn-block btn-secondary']) !!}

                                        </div>
                                    </div>
                                </div>


                            </div>
                            {{-- </form> --}}

                        </div>
                    </div>
                </div><!-- /header-text -->
            </div>
        </form>
    </div>

@endsection
@section('content')

    <!-- ======= About Section ======= -->
    @include('website.home.categories',["type" => "project"])

    @include('website.home.categories',["type" => "service"])

    <!-- End Counts Section -->
    <!-- ======= Services Section ======= -->
    @include('website.home.services')
    <!-- End Services Section -->
    <!-- ======= Team Section ======= -->
    @include('website.home.projects')
    <!-- ======= Portfolio Section ======= -->
    @include('website.home.blogs')
    <!-- End Portfolio Section -->



    @include('website.home.contact')
@endsection
