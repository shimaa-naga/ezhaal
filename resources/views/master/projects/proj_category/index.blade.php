@extends('master.layout.index' ,['title' => _i('Projects Categories')])
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('master/assets/nestable/jquery.nestable.css') }}" />
@endpush
@section('content')

    <!--breadcrumbs start -->
    <div class="page-header">
        <h4 class="page-title">
            {{ _i('Projects Categories') }}</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('MasterHome') }}"><i class="fa fa-home"></i>
                    {{ _i('Home') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ _i('Projects Categories') }}</li>
        </ol>
    </div>
    <!--breadcrumbs end -->

    <!-- page start-->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div>
                    <div class="user-tabs mb-4">
                        <!-- Tabs -->
                        <ul class="nav panel-tabs">
                            <li class="">
                                <a href=" #" data-toggle='modal' data-target='#add-Modal' class="btn btn-primary">
                                    <i class="fa fa-plus"> </i>

                                    {{ _i('Create new category') }}

                                </a>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row" id="tag_container">
        @include("master.projects.proj_category.ajax_index")
    </div>

    </div>

    <!-- page end-->
    @include('master.projects.proj_category.create')
    @include('master.projects.proj_category.edit')
    @include('master.projects.proj_category.trans') @endsection @push('js')
    @push('css') <style>
            .mx-2 {
                margin-left: 2px;
                margin-right: 2px;
            }

        </style>
        <link href="{{ asset('master/assets/plugins/fileuploads/css/dropify.css') }}" rel="stylesheet" type="text/css" />

    @endpush
    @push('js')
        <script src="{{ asset('master/assets/plugins/fileuploads/js/dropify.js') }}"></script>

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

                $('.dropify').dropify({
                    messages: {
                        'default': "{{ _i('Drag and drop a file here or click') }}",
                        'replace': "{{ _i('Drag and drop or click to replace') }}",
                        'remove': "{{ _i('Remove') }}",
                        'error': "{{ _i('Ooops, something wrong appended.') }}"
                    },
                    error: {
                        'fileSize': "{{ _i('The file size is too big (2M max).') }}"
                    }
                });

            });

            function getData(page) {
                $.ajax({
                    url: '?page=' + page,
                    type: "get",
                    datatype: "html"
                }).done(function(data) {
                    $("#tag_container").empty().html(data);
                    location.hash = page;
                }).fail(function(jqXHR, ajaxOptions, thrownError) {
                    new Noty({
                        type: 'error',
                        layout: 'topRight',
                        text: "{{ _i('No response from server') }}",
                        timeout: 2000,
                        killer: true
                    }).show();
                });
            }


            $('body').on('submit', '.delete', function(e) {

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
                            getData(page);
                            get_parent();
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
            })

            function get_parent() {

                $.ajax({
                    url: "{{ route('master.proj_category.get_parent') }}",
                    type: "GET",
                    dataType: 'json',
                    success: function(res) {
                        if (res) {

                            $('.get_parent').empty();
                            <?php if (isset($external)) { ?>
                            $('.get_parent').append('<option selected >---</option>');
                            <?php } else { ?>
                            $('.get_parent').append(
                                '<option value="" selected >{{ _i('Choose Parent') }} </option>');
                            <?php } ?>

                            $.each(res, function(result, row) {
                                $('.get_parent').append('<option value="' + row.id + '"> ' + row
                                    .title + '</option>');
                            });


                            $("#parenedit").val(selected);

                        } else {
                            $(".get_parent").empty();
                        }
                    }
                });
            }
        </script>
    @endpush
