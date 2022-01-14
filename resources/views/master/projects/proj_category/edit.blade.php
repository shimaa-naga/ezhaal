<div class="modal modal_edit fade" id="modal-edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> {{ _i('Edit Project Category') }} </h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <form id="form_edit" class="form-horizontal" method="POST" data-parsley-validate=""
                    enctype="multipart/form-data">
                    @csrf
                    <div class="box-body">
                        <input type="hidden" id="rowId" name="row_id">
                        <input type="hidden" id="edit_parentId" name="parent_id">
                        <div class="callout text-danger" id="messages_model" style="display:none">
                        </div>
                        <div class="form-group ">
                            <div class="row">
                                <div class="col-lg-12 col-sm-12">
                                    <input type="file" name="img" id="edit_img" data-height="180"
                                        data-default-file="" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="row">
                                <label class=" col-sm-2 col-form-label"><?= _i('Parent') ?></label>
                                <div class="col-sm-10">
                                    <select class="form-control get_parent" name="parent_id" id="parenedit">
                                        <option selected value="">{{ _i('Choose Parent') }}</option>
                                        @foreach ($parents as $parent)
                                            <option value="{{ $parent->id }}">{{ $parent->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="row">
                                <label class=" col-sm-2 col-form-label"><?= _i('Title') ?> <span
                                        style="color: #F00;">*</span></label>
                                <div class="col-sm-10">
                                    <input type="text" id="edit_title" class="form-control" name="title" required=""
                                        placeholder="{{ _i('Please Enter Title') }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="row">
                                <label class=" col-sm-2">
                                    {{ _i('Status') }}
                                </label>
                                <div class="col-sm-10">
                                    <label class="custom-switch">
                                        <input type="checkbox" class="custom-switch-input" name="active"
                                            id="edit_active" checked="">
                                        <span class="custom-switch-indicator"></span>
                                        <span class="custom-switch-description">{{ _i('Active') }}</span>
                                    </label>


                                    <label class="custom-switch">
                                        <input type="checkbox" id="edit_scope" name="scope" value="trusted"
                                            class="custom-switch-input">
                                        <span class="custom-switch-indicator"></span>
                                        <span
                                            class="custom-switch-description">{{ _i('Trusted accounts only') }}</span>
                                    </label>

                                </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="row">
                                <label class="col-sm-3 col-form-label" for="meta_keyword">{{ _i('Meta Keywords') }}
                                </label>
                                <div class="col-sm-9">
                                    <textarea placeholder="cat,.." name="meta_keyword" id="edit_keyword"
                                        class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="row">
                                <label class="col-sm-3 col-form-label"
                                    for="meta_description">{{ _i('Meta Description') }}
                                </label>
                                <div class="col-sm-9">
                                    <textarea name="meta_description" id="edit_meta_description"
                                        class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="row">
                                <label class="col-sm-3 col-form-label"
                                    for="img_description">{{ _i('Image Description') }}
                                </label>
                                <div class="col-sm-9">
                                    <textarea name="img_description" id="edit_img_description"
                                        class="form-control"></textarea>
                                </div>
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
        var selected = "";

        $('body').on('click', '.edit', function(e) {

            e.preventDefault();
            $('#messages_model').empty();
            var row_id = $(this).data('id');
            $("#edit_title").val($(this).data("title"));
            $("#edit_keyword").val($(this).data("meta_keyword"));
            $("#edit_meta_description").val($(this).data("meta_description"));
            $("#edit_img_description").val($(this).data("img_description"));

            selected = $(this).data("parent");

            // $("#edit_img").attr("data-default-file", '{{ asset('uploads/category') }}/' +
            //     $(this).data("img"));

            // $('#edit_img').dropify();
            imagenUrl = '{{ asset('uploads/category') }}/' + $(this).data("img");
            var drEvent = $('#edit_img').dropify({
                defaultFile: imagenUrl
            });
            drEvent = drEvent.data('dropify');
            drEvent.resetPreview();
            drEvent.clearElement();
            drEvent.settings.defaultFile = imagenUrl;
            drEvent.destroy();
            drEvent.init();

            // console.log('{{ asset('uploads/category') }}/' +
            // $(this).data("img"));

            if ($(this).data("publish") == "1")
                $("#edit_active").prop("checked", true);
            else
                $("#edit_active").prop("checked", false);

            if ($(this).data("scope") == "trusted")
                $("#edit_scope").prop("checked", true);
            else
                $("#edit_scope").prop("checked", false);


            $("#form_edit:input[name='type'][value='" + $(this).data("type") + "']").prop("checked", "checked")
            //console.log(parent_id);
            $('#rowId').val(row_id);
            return get_parent();
            //  alert($(this).data("parent"));

        });


        $(function() {
            $('#form_edit').submit(function(e) {
                e.preventDefault();
                $("#s_form_1").addClass("btn-loading");
                $.ajax({
                    url: "{{ route('master.proj_category.update') }}",
                    type: "POST",
                    data: new FormData(this),
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $("#s_form_1").removeClass("btn-loading");

                        if (response.errors) {
                            $('#messages_model').empty();
                            $.each(response.errors, function(index, value) {
                                $('#messages_model').show();
                                $('#messages_model').append(value + "<br>");
                            });
                        }
                        if (response == 'SUCCESS') {
                            new Noty({
                                type: 'success',
                                layout: 'topRight',
                                text: "{{ _i('Saved Successfully') }}",
                                timeout: 2000,
                                killer: true
                            }).show();
                            $('.modal.modal_edit').modal('hide');
                            //table.ajax.reload();
                            getData(page);
                            $('#edit_parentId').val("");
                            get_parent();
                        }
                    }
                });
            });
        });
    </script>
@endpush
