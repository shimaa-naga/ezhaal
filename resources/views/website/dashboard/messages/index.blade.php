@extends('website.dashboard.index_inner', ['title' => _i('Messages'),'header_title' => _i('Messages'),"nav"=>true])
@push('css')
    <style>
        .email table a {
            color: #666;
        }
        .email table tr.read > td {
            background-color: #f6f6f6;
            font-weight: 400;
        }
    </style>
@endpush


@section('content')
    <!--Breadcrumb-->
    <section>
        <div class="bannerimg cover-image bg-background3" data-image-src="{{asset('website2/assets/images/banners/banner2.jpg')}}">
            <div class="header-text mb-0">
                <div class="container">
                    <div class="text-center text-white ">
                        <h1 class="">{{_i('My Inbox')}}</h1>
                        <ol class="breadcrumb text-center">
                            <li class="breadcrumb-item"><a href="{{ route('WebsiteHome') }}">{{_i('Home')}}</a></li>
                            <li class="breadcrumb-item active text-white" aria-current="page">{{_i('My Inbox')}}</li>
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
                @if (session('success'))

                    <div class="alert alert-success alert-block col-sm-12 ">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <h6>
                            <i class="fa fa-ok-sign"></i>
                            {{ _i('Success') }}!
                        </h6>
                        <p>{{ session('success') }}</p>
                    </div>

                @endif
                @if (session('error'))

                    <div class="alert alert-danger  alert-block  col-sm-12 ">
                        <button data-dismiss="alert" class="close close-sm" type="button">
                            <i class="fa fa-times"></i>
                        </button>
                        <h6>
                            <i class="fa fa-ok-sign"></i>
                            {{ _i('Error') }}!
                        </h6>
                        <p>{{ session('error') }}</p>
                    </div>

                @endif

                @if ($errors->all())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{!! $error !!}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @include('website.dashboard.messages.partial.message_nav')

                <div class="col-xl-9 col-lg-12 col-md-12">
                    <div class="card mb-0">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fa fa-inbox"></i> {{_i('Messages')}}</h3>
                        </div>

                            <div class="card-body">
                                <div id="messages_filter">
                                    @include('website.dashboard.messages.partial.message_ajax')
                                </div>

                            </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/User Dashboard-->

@endsection




    <!-- Content section End -->



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
                type: "get",
                method: "get",
                //data: new FormData($('#filter-form')[0]),
                cache       : false,
                contentType : false,
                processData : false,
            }).done(function(response) {
                $('#messages_filter').empty().html(response);
                location.hash = page;
            }).fail(function(jqXHR, ajaxOptions, thrownError) {
                alert('No response from server');
            });
        }

        //delete
        $('body').on('click','.delmessage',function (e) {
            e.preventDefault();
            var url = $(this).attr('href');
            var tr = $(this).closest('tr');
            $.ajax({
                url: url,
                method: "get",
                type: "get",

                success: function (response) {
                    if (response.data === true){
                        new Noty({
                            type: 'error',
                            layout: 'topRight',
                            text: "{{ _i('Deleted Successfully')}}",
                            timeout: 2000,
                            killer: true
                        }).show();
                        tr.remove();
                        //$(this).parent().remove();
                    }
                }
            });
        });

    </script>
@endpush
