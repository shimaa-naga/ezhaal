
@extends('master.layout.index' ,['title' => _i('Sliders')])

@section('content')
    <!--breadcrumbs start -->
    <ul class="breadcrumb">
        <li><a href="{{route('MasterHome')}}"><i class="fa fa-home"></i> {{_i('Home')}}</a></li>
        <li class="active">{{_i('Sliders')}}</li>
    </ul>
    <!--breadcrumbs end -->

    <!-- page start-->
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    <a href="#" class='btn btn-shadow btn-primary mb-2' data-toggle='modal' data-target='#add-Modal'>
                        <i class="fa fa-plus"> </i> {{ _i('Create new Slider') }}
                    </a>
                </header>
                <div class="panel-body">
                    <div class="adv-table">
                        <table id="datatable" class="table table-striped table-bordered nowrap">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th class="text-center"> {{_i('Image')}}</th>
                                <th class="text-center"> {{_i('Status')}}</th>
                                <th class="text-center"> {{_i('Create Time')}}</th>
                                <th class="text-center"> {{_i('Options')}}</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <section class="panel">
        <header class="panel-heading">
            Image Galley
        </header>
        <div class="panel-body">
            <ul class="grid cs-style-3">
                <li>
                    <figure>
                        <img src="../../img/gallery/4.jpg" alt="img04">
                        <figcaption>
                            <h3>Mindblowing</h3>
                            <span>lorem ipsume </span>
                            <a class="fancybox" rel="group" href="../../img/gallery/4.jpg">Take a look</a>
                        </figcaption>
                    </figure>
                </li>
                <li>
                    <figure>
                        <img src="../../img/gallery/1.jpg" alt="img01">
                        <figcaption>
                            <h3>Clean & Fresh</h3>
                            <span>dolor ament</span>
                            <a class="fancybox" rel="group" href="../../img/gallery/1.jpg">Take a look</a>
                        </figcaption>
                    </figure>
                </li>
                <li>
                    <figure>
                        <img src="../../img/gallery/2.jpg" alt="img02">
                        <figcaption>
                            <h3>Flat Concept</h3>
                            <span>tawseef tasi</span>
                            <a class="fancybox" rel="group" href="../../img/gallery/2.jpg">Take a look</a>
                        </figcaption>
                    </figure>
                </li>
                <li>
                    <figure>
                        <img src="../../img/gallery/5.jpg" alt="img05">
                        <figcaption>
                            <h3>Modern</h3>
                            <span>dkmosa inc</span>
                            <a class="fancybox" rel="group" href="../../img/gallery/5.jpg">Take a look</a>
                        </figcaption>
                    </figure>
                </li>
                <li>
                    <figure>
                        <img src="../../img/gallery/3.jpg" alt="img03">
                        <figcaption>
                            <h3>Clean Code</h3>
                            <span>nice concept</span>
                            <a class="fancybox" rel="group" href="../../img/gallery/3.jpg">Take a look</a>
                        </figcaption>
                    </figure>
                </li>
                <li>
                    <figure>
                        <img src="../../img/gallery/6.jpg" alt="img06">
                        <figcaption>
                            <h3>Cheers</h3>
                            <span>sumon ahmed</span>
                            <a class="fancybox" rel="group" href="../../img/gallery/6.jpg">Take a look</a>
                        </figcaption>
                    </figure>
                </li>
                <li>
                    <figure>
                        <img src="../../img/gallery/4.jpg" alt="img04">
                        <figcaption>
                            <h3>Freshness</h3>
                            <span>rerum facilis </span>
                            <a class="fancybox" rel="group" href="../../img/gallery/4.jpg">Take a look</a>
                        </figcaption>
                    </figure>
                </li>
                <li>
                    <figure>
                        <img src="../../img/gallery/1.jpg" alt="img01">
                        <figcaption>
                            <h3>Awesome</h3>
                            <span>At vero eos</span>
                            <a class="fancybox" rel="group" href="../../img/gallery/1.jpg">Take a look</a>
                        </figcaption>
                    </figure>
                </li>
                <li>
                    <figure>
                        <img src="../../img/gallery/2.jpg" alt="img02">
                        <figcaption>
                            <h3>Music</h3>
                            <span>atque corrupti </span>
                            <a class="fancybox" rel="group" href="../../img/gallery/2.jpg">Take a look</a>
                        </figcaption>
                    </figure>
                </li>
                <li>
                    <figure>
                        <img src="../../img/gallery/3.jpg" alt="img03">
                        <figcaption>
                            <h3>Clean Code</h3>
                            <span>nice concept</span>
                            <a class="fancybox" rel="group" href="../../img/gallery/3.jpg">Take a look</a>
                        </figcaption>
                    </figure>
                </li>
                <li>
                    <figure>
                        <img src="../../img/gallery/6.jpg" alt="img06">
                        <figcaption>
                            <h3>Cheers</h3>
                            <span>sumon ahmed</span>
                            <a class="fancybox" rel="group" href="../../img/gallery/6.jpg">Take a look</a>
                        </figcaption>
                    </figure>
                </li>
                <li>
                    <figure>
                        <img src="../../img/gallery/4.jpg" alt="img04">
                        <figcaption>
                            <h3>Freshness</h3>
                            <span>rerum facilis </span>
                            <a class="fancybox" rel="group" href="../../img/gallery/4.jpg">Take a look</a>
                        </figcaption>
                    </figure>
                </li>
            </ul>

        </div>
    </section>
    <!-- page end-->
@include('master.sliders.create')
@include('master.sliders.edit')
@include('master.sliders.trans')
@endsection
@push("css")

<link href="/master/assets/fancybox/source/jquery.fancybox.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="/master/css/gallery.css" />

@endpush
@push('js')
<script class="include" type="text/javascript" src="/master/js/jquery.dcjqaccordion.2.7.js"></script>
<script src="/master/assets/fancybox/source/jquery.fancybox.js"></script>
<script src="/master/js/modernizr.custom.js"></script>
<script src="/master/js/toucheffects.js"></script>

    <script>
         $(function() {
        //    fancybox
          $(".fancybox").fancybox();
      });
        var table = $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('master.sliders.index')}}',
            columns: [
                {data: 'id'},
                {data: 'image'},
                {data: 'status'},
                {data: 'created_at'},
                {data: 'options'}
            ]
        });

        $('body').on('submit','#delform',function (e) {
            e.preventDefault();
            var url = $(this).attr('action');
            $.ajax({
                url: url,
                method: "delete",
                type: "DELETE",
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function (response) {
                    if (response.data === true){
                        new Noty({
                            type: 'error',
                            layout: 'topRight',
                            text: "{{ _i('Deleted Successfully')}}",
                            timeout: 2000,
                            killer: true
                        }).show();
                        table.ajax.reload();
                    }
                }
            });
        })

        $('body').on('click','.lang_ex',function (e) {
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
                success: function (response) {
                    if (response.data == 'false'){
                        $('#titletrans').val('');
                        $('#description_trans').val('');
                    }else{
                        $('#titletrans').val(response.data.title);
                        $('#description_trans').val(response.data.description);
                    }
                }
            });
            $('#langedit #header').text('{{ _i("Translate to :") }}'+lang_title);
            $('#id_data').val(id);
            $('#lang_id_data').val(lang_id);
        });
        $('body').on('submit','#lang_submit',function (e) {
            e.preventDefault();
            let url = $(this).attr('action');
            $.ajax({
                url: url,
                method: "post",
                type: "post",
                data: new FormData(this),
                dataType: 'json',
                cache       : false,
                contentType : false,
                processData : false,
                success: function (response) {

                    if (response.errors){
                        $('#masages_model').empty();
                        $.each(response.errors, function( index, value ) {
                            $('#masages_model').show();
                            $('#masages_model').append(value + "<br>");
                        });
                    }
                    if (response == 'SUCCESS'){
                        new Noty({
                            //type: 'warning',
                            type: 'success',
                            layout: 'topRight',
                            text: "{{ _i('Translated Successfully')}}",
                            timeout: 2000,
                            killer: true
                        }).show();
                        $('.modal.modal_trans').modal('hide');
                        table.ajax.reload();
                    }
                },
            });
        });
    </script>
@endpush
