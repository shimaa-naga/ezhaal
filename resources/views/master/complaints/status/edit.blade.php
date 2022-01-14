<div class="modal modal_edit fade" id="modal-edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" > {{ _i('Edit Type') }} </h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <form id="form_edit" class="form-horizontal" method="POST" data-parsley-validate=""
                    enctype="multipart/form-data">
                    @csrf
                    <div class="box-body">
                        <input type="hidden" id="status_id" name="status_id">

                        <div class="form-group ">
                            <div class="row">
                            <label for="titletrans" class="col-sm-2 control-label"> <?= _i('Title') ?> <span style="color: #F00;">*</span> </label>
                            <div class="col-sm-10">
                                <input type="text" id="title_edit" class="form-control" name="title" required="" placeholder="{{ _i('Please Enter type Title') }}">
                            </div>
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
            var id;
            $('body').on('click', '.edit', function (e) {
                e.preventDefault();
                var typeId = $(this).data('id');
                id =typeId;
                var lang = $(this).data('lang');
                var title = $(this).data('title');

                $('#status_id').val(typeId);

                $('#langId').val(lang);
                $('#title_edit').val(title);

            });

            $(function() {
                $('#form_edit').submit(function(e) {
                    e.preventDefault();
                    $.ajax({
                        url: "status/"+id,
                        method: "Put",
                        type: "PuT",
                        data: {
                         _token: '{{ csrf_token() }}',
                         title: $("#title_edit").val()
                          },

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


        </script>
@endpush
