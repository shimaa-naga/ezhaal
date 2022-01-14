<!--------------------------------------------- modal trans start ----------------------------------------->
<div class="modal fade modal_trans " id="langedit" tabindex="-1" role="dialog" style="z-index: 1050; display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="header" > {{_i('Trans To')}} : </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <form  action="{{ route('master.blog_category.lang.store') }}" method="post" class="form-horizontal"  id="lang_submit" data-parsley-validate="" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="blog_cat_id" id="id_data" value="">
                        <input type="hidden" name="lang_id_data" id="lang_id_data" value="" >
                        <div class="box-body">
                            <div class="callout text-danger" id="messages_modeltrans" style="display:none">
                            </div>
                            <div class="form-group ">
                                <div class="row">
                                <label for="titletrans" class="col-sm-2 control-label"> <?=_i('Title')?> <span style="color: #F00;">*</span> </label>
                                <div class="col-sm-10">
                                    <input type="text" id="titletrans" class="form-control" name="title" required="" placeholder="{{_i('Please Enter Blog Category Title')}}">
                                </div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="row">
                                <label class="col-sm-2 col-form-label" for="image">{{_i('Image')}} <span style="color: #F00;">*</span></label>
                                <div class="col-sm-10">
                                    <input type="file" name="img" id="imagetrans" onchange="showImgTrans(this)"
                                           class="btn btn-default" accept="image/*" >
                                    <img class="img-responsive pad" id="old_imgtrans" style=" width: 100px; height: 100px;"
                                         src="{{asset('custom/index.png')}}">
                                    <span class="text-danger invalid-feedback">
                                    <strong>{{$errors->first('img')}}</strong>
                                </span>
                                </div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="row">
                                <label class="col-sm-2 col-form-label" for="slugtrans">{{_i('Slug')}} </label>
                                <div class="col-sm-10">
                                    <input type="text" name="slug" id="slugtrans" class="form-control" >
                                </div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="row">
                                <label class="col-sm-2 col-form-label" for="metakeywordtrans">{{_i('Meta Keywords')}} </label>
                                <div class="col-sm-10">
                                    <textarea name="meta_keyword" id="metakeywordtrans" class="form-control"></textarea>
                                </div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="row">
                                <label class="col-sm-2 col-form-label" for="metadescriptiontrans">{{_i('Meta Description')}} </label>
                                <div class="col-sm-10">
                                    <textarea name="meta_description" id="metadescriptiontrans" class="form-control"></textarea>
                                </div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="row">
                                <label class="col-sm-2 col-form-label" for="imgdescriptiontrans">{{_i('Image Description')}} </label>
                                <div class="col-sm-10">
                                    <textarea name="img_description" id="imgdescriptiontrans" class="form-control"></textarea>
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button data-dismiss="modal" class="btn btn-default" type="button">{{_i('Close')}}</button>
                            <button type="submit" class="btn btn-primary" >
                                {{_i('Save')}}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@push('js')
    <script>
        $('body').on('click','.lang_ex',function (e) {
            e.preventDefault();
            $('#messages_modeltrans').empty();

            var id = $(this).data('blogcategoryid');
            var lang_id = $(this).data('lang');
            var lang_title = $(this).data('title');
            $.ajax({
                url: '{{ route('master.blog_category.lang') }}',
                method: "get",
                data: {
                    lang_id: lang_id,
                    catId: id,
                },
                success: function (response) {
                    if (response.data == false){
                        $('#titletrans').val('');
                        $('#slugtrans').val('');
                        $('#metakeywordtrans').val('');
                        $('#metadescriptiontrans').val('');
                        $('#imgdescriptiontrans').val('');
                       $("#old_imgtrans").attr("src", "{{asset('custom/index.png')}}");

                    }else{
                        $('#titletrans').val(response.data.title);
                        $('#slugtrans').val(response.data.slug);
                        $('#metakeywordtrans').val(response.data.meta_keyword);
                        $('#metadescriptiontrans').val(response.data.meta_description);
                        $('#imgdescriptiontrans').val(response.data.img_description);
                        $("#old_imgtrans").attr('src',"{{asset('')}}/"+response.data.img);
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
                        $('#messages_modeltrans').empty();
                        $.each(response.errors, function( index, value ) {
                            $('#messages_modeltrans').show();
                            $('#messages_modeltrans').append(value + "<br>");
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
