@extends('website.dashboard.index_inner',["form"=>true,'title' => _i('My Bids')])
@section('content')
    <!--Breadcrumb-->
    <section>
        <div class="bannerimg cover-image bg-background3" data-image-src="{{asset('website2/assets/images/banners/banner2.jpg')}}">
            <div class="header-text mb-0">
                <div class="container">
                    <div class="text-center text-white ">
                        <h1 class="">{{_i('My Bids')}}</h1>
                        <ol class="breadcrumb text-center">
                            <li class="breadcrumb-item"><a href="{{ route('WebsiteHome') }}">{{_i('Home')}}</a></li>
                            <li class="breadcrumb-item active text-white" aria-current="page">{{_i('My Bids')}}</li>
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

                @include('website.dashboard.project_bids.my.bids_nav')

                <div class="col-xl-9 col-lg-12 col-md-12">
                    <div class="card mb-0">
                        <div class="card-header">
                            <h3 class="card-title">{{_i('My Bids')}}</h3>
                        </div>

                        <div class="card-body">
                            @csrf

                            <div id="projects_filter">
                                @include("website.dashboard.project_bids.my.all.ajax")
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


        $(window).on('hashchange', function() {
            if (window.location.hash) {
                var page = window.location.hash.replace('#', '');
                if (page == Number.NaN || page <= 0) {
                    return false;
                } else {
                    getData(page);
                }
            }
        });
        var page = 0;
        $(document).ready(function() {

            $(document).on('click', '.pagination a', function(event) {
                event.preventDefault();

                $('li').removeClass('active');
                $(this).parent('li').addClass('active');

                var myurl = $(this).attr('href');
                page = $(this).attr('href').split('page=')[1];

                getData(page);
            });

        });

        function getData(page) {

            $.ajax({
                url: '?page=' + page,
                type: "post",
                method: "post",
                data: new FormData($('#filter-form')[0]),
                cache       : false,
                contentType : false,
                processData : false,
            }).done(function(response) {
                $('#projects_filter').empty().html(response);
                //$("#tag_container").empty().html(data);
                location.hash = page;
            }).fail(function(jqXHR, ajaxOptions, thrownError) {
                alert('No response from server');
            });
        }


        $(document).on('change', '#filter-form :input', function() {
            getData(page);

        })

    </script>
@endpush
