<!--------------------------------------------- modal trans start ----------------------------------------->
<div class="modal fade modal_trans " id="langedit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top:40px;">
    <div class="modal-dialog" role="document">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="header" > {{_i('Trans To')}} : </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="callout text-danger" id="masages_model" style="display:none">
                    </div>
                    <form  action="{{ route('master.city.lang.store') }}" method="post" class="form-horizontal"  id="lang_submit" data-parsley-validate="">
                        @csrf
                        <input type="hidden" name="id" id="id_data" value="">
                        <input type="hidden" name="lang_id_data" id="lang_id_data" value="" >
                        <div class="box-body">
                            <div class="form-group ">
                                <div class="row">
                                <label for="titletrans" class="col-sm-2 control-label"> <?=_i('Title')?> <span style="color: #F00;">*</span> </label>
                                <div class="col-sm-10">
                                    <input type="text" id="titletrans" class="form-control" name="title" required="" placeholder="{{_i('Please Enter City Title')}}">
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
            $('#masages_model').empty();
            var id = $(this).data('id');
            var lang_id = $(this).data('lang');
            var lang_title = $(this).data('title');
            $.ajax({
                url: '{{ route('master.city.lang') }}',
                method: "get",
                data: {
                    lang_id: lang_id,
                    id: id,
                },
                success: function (response) {
                    if (response.data == false){
                        $('#titletrans').val('');
                    }else{
                        $('#titletrans').val(response.data.title);
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

