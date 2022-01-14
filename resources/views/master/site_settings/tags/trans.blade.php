<!--------------------------------------------- modal trans start ----------------------------------------->
<div class="modal fade modal_trans " id="langedit" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="header">{{ _i('Trans To') }} :</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post"
                        class="form-horizontal" id="lang_submit" data-parsley-validate="" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="data_id" id="id_data" value="">
                        <input type="hidden" name="lang_id" id="lang_id" value="">
                        <div class="box-body">
                            <div class="callout text-danger" id="messages_modeltrans" style="display:none">
                            </div>
                            <div class="form-group ">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="form-label" ><?= _i('Meta keywords') ?> <span style="color: #F00;">*</span></label>
                                    </div>
                                    <div class="col-md-9">
                                        <textarea  class="form-control" name="keywords" id="edit_keywords" required="" placeholder="{{ _i('Enter keywords') }}"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="form-label" ><?= _i('Meta description') ?> <span style="color: #F00;">*</span></label>
                                    </div>
                                    <div class="col-md-9">
                                        <textarea  class="form-control" name="description" id="edit_desc" required="" placeholder="{{ _i('Enter keywords') }}"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button data-dismiss="modal" class="btn btn-default" type="button">{{ _i('Close') }}</button>
                            <button type="submit" class="btn btn-primary" >
                                {{ _i('Save') }}
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

                var id = $(this).data('id');
                var lang_id = $(this).data('lang_id');
                var lang_title = $(this).data('title');
                $.ajax({
                    url: 'tags/'+id,
                    method: "get",
                    data: {
                        lang_id: lang_id,
                    },
                    success: function (response) {

                            $('#edit_keywords').text(response.keywords);
                            $('#edit_desc').text(response.description);

                    }
                });
                $('#langedit #header').text('{{ _i("Translate to :") }}'+lang_title);
                $('#id_data').val(id);
                $('#lang_id').val(lang_id);

            });



            $('body').on('submit','#lang_submit',function (e) {
                e.preventDefault();
                var id =$('#id_data').val();

                $.ajax({
                    url: "tags/"+id+"/trans",
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
                                text: "{{ _i('Translated Successfully') }}",
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
