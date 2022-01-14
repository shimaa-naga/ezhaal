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
                    <form  action="{{ route('master.proj_category.lang.store') }}" method="post" class="form-horizontal"  id="lang_submit" data-parsley-validate="" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="category_id" id="id_data" value="">
                        <input type="hidden" name="lang_id_data" id="lang_id_data" value="" >
                        <div class="box-body">
                            <div class="callout text-danger" id="messages_modeltrans" style="display:none">
                            </div>
                            <div class="form-group ">
                                <div class="row">
                                <label for="titletrans" class="col-sm-3 control-label"> <?=_i('Title')?> <span style="color: #F00;">*</span> </label>
                                <div class="col-sm-9">
                                    <input type="text" id="titletrans" class="form-control" name="title" required="" placeholder="{{_i('Please Enter Project Category Title')}}">
                                </div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="row">
                                    <label class="col-sm-3 col-form-label" for="meta_keyword">{{ _i('Meta Keywords') }} </label>
                                    <div class="col-sm-9">
                                        <textarea placeholder="cat,.." name="meta_keyword" id="trans_meta_keyword" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="row">
                                    <label class="col-sm-3 col-form-label" for="meta_description">{{ _i('Meta Description') }}
                                    </label>
                                    <div class="col-sm-9">
                                        <textarea name="meta_description" id="trans_meta_description"
                                            class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="row">
                                    <label class="col-sm-3 col-form-label" for="img_description">{{ _i('Image Description') }}
                                    </label>
                                    <div class="col-sm-9">
                                        <textarea name="img_description" id="trans_img_description" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        </div>
                        <div class="modal-footer">
                            <button data-dismiss="modal" class="btn btn-default" type="button">{{_i('Close')}}</button>
                            <button type="submit" class="btn btn-success" >
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

            var id = $(this).data('categoryid');
            var lang_id = $(this).data('lang');
            var lang_title = $(this).data('title');
            $.ajax({
                url: '{{ route('master.proj_category.lang') }}',
                method: "get",
                data: {
                    lang_id: lang_id,
                    category_id: id,
                },
                success: function (response) {
                    if (response.data == false){
                        $('#titletrans').val('');
                        $("#trans_meta_keyword").val('');
                        $("#trans_meta_description").val('');
                        $("#trans_meta_keyword").val('');
                    }else{
                        $('#titletrans').val(response.data.title);
                        $("#trans_meta_keyword").val(response.data.meta_keyword);
                        $("#trans_meta_description").val(response.data.meta_description);
                        $("#trans_meta_keyword").val(response.data.img_description);

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
                        getData(page);
                        get_parent();
                    }
                },
            });
        });
    </script>
@endpush
