
<div class="modal modal_create fade" id="add-Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ _i('Add New Currency') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="currency" method="POST" id='form_add' data-parsley-validate="" enctype="multipart/form-data">
                @csrf {{ method_field('POST') }}
                @method("POST")
                <div class="modal-body">
                    <div class="form-group row" >
                        <label class=" col-sm-2 col-form-label" for="country_id_add"><?=_i('Code')?>
                            <span style="color: #F00;">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="code" id="country_id_add" required="" />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="titletrans" class="col-sm-2 control-label"> <?=_i('Rate')?> <span style="color: #F00;">*</span> </label>
                        <div class="col-sm-10">
                            <input type="number" step="0.1" class="form-control" name="rate" required="" placeholder="{{_i('rate')}}">
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{_i('Close')}}</button>
                    <button type="submit" class="btn btn-primary">{{ _i('Save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('js')
    <script>
        $(function() {
            $('#form_add').submit(function(e) {
                e.preventDefault();
                var url = $(this).attr('action');

                $.ajax({
                   {{--// url: "{{ route('master.sliders.store')}}",--}}
                    url: url,
                    type: "POST",
                    data: new FormData(this),
                    dataType: 'json',
                    cache       : false,
                    contentType : false,
                    processData : false,
                    success: function(response) {
                        if (response.errors){
                            $('#masages_model').empty();
                            $.each(response.errors, function(index, value) {
                                $('#masages_model').show();
                                $('#masages_model').append(value + "<br>");
                            });
                        }
                        if (response == 'SUCCESS'){
                            new Noty({
                                type: 'success',
                                layout: 'topRight',
                                text: "{{ _i('Saved Successfully')}}",
                                timeout: 2000,
                                killer: true
                            }).show();
                            $('.modal.modal_create').modal('hide');
                            table.ajax.reload();
                            // $('#lang_add').val("");
                            $('#code_add').val("");
                            $('#logo_add').val("");
                        }
                    }
                });
            });
        });
    </script>
@endpush
