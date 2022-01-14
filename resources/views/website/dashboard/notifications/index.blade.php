@extends('website.dashboard.index_inner',["title"=>_i("Notifications")])
@section('content')

    <!--Breadcrumb-->
    <section>
        <div class="bannerimg cover-image bg-background3" data-image-src="{{asset('website2/assets/images/banners/banner2.jpg')}}">
            <div class="header-text mb-0">
                <div class="container">
                    <div class="text-center text-white ">
                        <h1 class="">{{_i('Notifications')}}</h1>
                        <ol class="breadcrumb text-center">
                            <li class="breadcrumb-item"><a href="{{ route('WebsiteHome') }}">{{_i('Home')}}</a></li>
                            <li class="breadcrumb-item active text-white" aria-current="page">{{_i('Notifications')}}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Breadcrumb-->

    <section class="sptb">
        <div class="container">
            <div class="row">



                <div class="col-xl-12 col-lg-12 col-md-12">
                    <div class="card mb-0">
                        <div class="card-header">
                            <h3 class="card-title">{{_i('Notifications')}}</h3>
                        </div>

                        <div class="card-body">
                            @include("website.dashboard.notifications.render.index",["notifications"=>$notifications])

                        </div>


                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection
@push('js')
    <script>
        $('body').on('submit', '.readform', function(e) {
            e.preventDefault();
            var url = $(this).attr('action');
            var btn = this;
            $.ajax({
                url: url,
                method: "post",
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    if (response.status === "ok") {

                        $("#content").html(response.data);
                        new Noty({
                            type: 'success',
                            layout: 'topRight',
                            text: "{{ _i('OK') }}",
                            timeout: 2000,
                            killer: true
                        }).show();

                    }
                }
            }).fail(function(jqXHR, ajaxOptions, thrownError) {
                new Noty({
                    type: 'error',
                    layout: 'topRight',
                    text: "{{ _i('No response from server') }}",
                    timeout: 2000,
                    killer: true
                }).show();
            });
        });
        //delete
        $('body').on('submit', '.delform', function(e) {
            e.preventDefault();
            var url = $(this).attr('action');
            var btn = this;
            $.ajax({
                url: url,
                method: "delete",
                type: "delete",
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    if (response.status=="ok") {
                        $("#content").html(response.data);
                        new Noty({
                            type: 'success',
                            layout: 'topRight',
                            text: "{{ _i('OK') }}",
                            timeout: 2000,
                            killer: true
                        }).show();

                    }
                }
            }).fail(function(jqXHR, ajaxOptions, thrownError) {
                new Noty({
                    type: 'error',
                    layout: 'topRight',
                    text: "{{ _i('No response from server') }}",
                    timeout: 2000,
                    killer: true
                }).show();
            });
        });

    </script>

@endpush
