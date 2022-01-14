<div class="modal modal_edit fade" id="modal-edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ _i('Edit Currency') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_edit" class="form-horizontal" method="POST" data-parsley-validate="" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="item_id" name="item_id">
                    <input type="hidden" name="_method" value="PUT">
                    <div class="modal-body">
                        <div class="form-group row">
                            <label class=" col-sm-2 col-form-label" for="country_id_add"><?= _i('Code') ?>
                                <span style="color: #F00;">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="code" id="code" required="" />
                            </div>
                        </div>

                    <div class="form-group row">
                        <label for="titletrans" class="col-sm-2 control-label"> <?= _i('Rate') ?> <span style="color: #F00;">*</span> </label>
                        <div class="col-sm-10">
                            <input type="number" step="0.1" class="form-control" id="rate" name="rate" required="" placeholder="{{ _i('rate') }}">
                        </div>
                    </div>
                </div>
                    <div class="modal-footer">
                        <button data-dismiss="modal" class="btn btn-default" type="button">{{ _i('Close') }}</button>
                        <button class="btn btn-primary" type="submit" id="s_form_1"> {{ _i('Save') }} </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
            $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
            $('body').on('click', '.edit', function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                var code = $(this).data('code');
                var rate = $(this).data('rate');
                $('#code').val(code);
                $('#item_id').val(id);
                $('#rate').val(rate);
            });

            $(function() {
                $('#form_edit').submit(function(e) {
                    e.preventDefault();
                    $.ajax({
                        url: "currency/"+$('#item_id').val(),
                        type: "Post",
                        data:$(this).serialize(),
                        dataType: 'json',
                        cache       : false,
                        success: function(response) {
                            if (response == 'SUCCESS'){
                                new Noty({
                                    type: 'success',
                                    layout: 'topRight',
                                    text: "{{ _i('Saved Successfully') }}",
                                    timeout: 2000,
                                    killer: true
                                }).show();
                                $('.modal.modal_edit').modal('hide');
                                table.ajax.reload();
                            }
                        }
                    });
                });
            });

            // edit form

        </script>
@endpush
