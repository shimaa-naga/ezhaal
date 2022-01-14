@extends('master.layout.index' ,['title' => _i('Sliders')])

@section('content')
    <!--breadcrumbs start -->
    <div class="page-header">
        <h4 class="page-title">{{ _i('Sliders') }}</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('MasterHome') }}"><i class="fa fa-home"></i> {{ _i('Home') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ _i('Sliders') }}</li>
        </ol>
    </div>
    <!--breadcrumbs end -->

    <!-- page start-->
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <a href="#" class='btn btn-shadow btn-primary mb-2 text-white' data-toggle='modal' data-target='#add-Modal'>
                            <i class="fa fa-plus"> </i> {{ _i('Create new Slider') }}
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="grid cs-style-3" id="messages_filter">
                        @include('master.sliders.ajax')

                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- page end-->
    @include('master.sliders.create')
    @include('master.sliders.edit')
    @include('master.sliders.trans')
@endsection
@push('css')

    <link href="/master/assets/fancybox/source/jquery.fancybox.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="/master/css/gallery.css" />

@endpush
@push('js')
    <script class="include" type="text/javascript" src="/master/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="/master/assets/fancybox/source/jquery.fancybox.js"></script>
    <script src="/master/js/modernizr.custom.js"></script>
    <script src="/master/js/toucheffects.js"></script>

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




        $(function() {
            //    fancybox
            $(".fancybox").fancybox();
        });





        $('body').on('submit', '#delform', function(e) {
            e.preventDefault();
            var url = $(this).attr('action');
            $.ajax({
                url: url,
                method: "delete",
                type: "DELETE",
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    if (response.data === true) {
                        new Noty({
                            type: 'error',
                            layout: 'topRight',
                            text: "{{ _i('Deleted Successfully') }}",
                            timeout: 2000,
                            killer: true
                        }).show();
                        getData();
                    }
                }
            });
        })

        $('body').on('click', '.lang_ex', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            var lang_id = $(this).data('lang');
            var lang_title = $(this).data('title');
            $.ajax({
                url: '{{ route('master.sliders.lang') }}',
                method: "get",
                data: {
                    lang_id: lang_id,
                    id: id,
                },
                success: function(response) {
                    if (response.data == 'false') {
                        $('#titletrans').val('');
                        $('#description_trans').val('');
                    } else {
                        $('#titletrans').val(response.data.title);
                        $('#description_trans').val(response.data.description);
                    }
                }
            });
            $('#langedit #header').text('{{ _i("Translate to :") }}' + lang_title);
            $('#id_data').val(id);
            $('#lang_id_data').val(lang_id);
        });
        $('body').on('submit', '#lang_submit', function(e) {
            e.preventDefault();
            let url = $(this).attr('action');
            $.ajax({
                url: url,
                method: "post",
                type: "post",
                data: new FormData(this),
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {

                    if (response.errors) {
                        $('#masages_model').empty();
                        $.each(response.errors, function(index, value) {
                            $('#masages_model').show();
                            $('#masages_model').append(value + "<br>");
                        });
                    }
                    if (response == 'SUCCESS') {
                        new Noty({
                            //type: 'warning',
                            type: 'success',
                            layout: 'topRight',
                            text: "{{ _i('Translated Successfully') }}",
                            timeout: 2000,
                            killer: true
                        }).show();
                        $('.modal.modal_trans').modal('hide');
                        //table.ajax.reload();
                        getData();

                    }
                },
            });
        });

    </script>
@endpush
