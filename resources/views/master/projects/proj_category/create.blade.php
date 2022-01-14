<div class="modal modal_create fade" id="add-Modal" tabindex="-1" role="dialog" style="z-index: 1050; display: none;"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ _i('Create new project category') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <form action="{{ route('category.store') }}" method="POST" id='form_add'
                data-parsley-validate="" enctype="multipart/form-data">
                @csrf {{ method_field('POST') }}

                @method("POST")

                <div class="modal-body ">
                    <div class="callout text-danger" id="masages_model" style="display:none"></div>

                    <div class="form-group ">
                        <div class="row">
                            <div class="col-lg-12 col-sm-12">
                                <input type="file" name="img" class="dropify" data-height="100" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group ">
                        <div class="row">
                            <label class=" col-sm-3 col-form-label"><?= _i('Language') ?>
                                <span style="color: #F00;">*</span>
                            </label>
                            <div class="col-sm-9">
                                <select class="form-control" name="lang_id" id="langId">
                                    @foreach ($languages as $lang)
                                        <option value="{{ $lang->id }}">{{ $lang->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group ">
                        <div class="row">
                            <label class=" col-sm-3 col-form-label"><?= _i('Parent') ?></label>
                            <div class="col-sm-9">

                                <select class="form-control get_parent" name="parent_id" id="parentId">
                                    <option selected value="">{{ _i('Choose Parent') }}</option>
                                    @php
                                        $obj = new \App\Help\Category();
                                    @endphp
                                    @foreach ($obj->selectTreeArray() as $parent)
                                        <option value="{{ $parent['id'] }}">{!!$parent['title'] !!}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="row">
                            <label class=" col-sm-3 col-form-label"><?= _i('Title') ?> <span
                                    style="color: #F00;">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" id="title" class="form-control" name="title" required=""
                                    placeholder="{{ _i('Please Enter Title') }}">
                            </div>

                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="row">
                            <label class=" col-sm-3">
                                {{ _i('Status') }}
                            </label>
                            <div class="col-sm-9">
                                <label class="custom-switch">
                                    <input type="checkbox" class="custom-switch-input" name="active" id="active"
                                        checked="">
                                    <span class="custom-switch-indicator"></span>
                                    <span class="custom-switch-description">{{ _i('Active') }}</span>
                                </label>


                                <label class="custom-switch">
                                    <input type="checkbox" id="scope" name="scope" class="custom-switch-input">
                                    <span class="custom-switch-indicator"></span>
                                    <span class="custom-switch-description">{{ _i('Trusted accounts only') }}</span>
                                </label>

                            </div>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="row">
                            <label class="col-sm-3 col-form-label" for="meta_keyword">{{ _i('Meta Keywords') }} </label>
                            <div class="col-sm-9">
                                <textarea placeholder="cat,.." name="meta_keyword" id="meta_keyword" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="row">
                            <label class="col-sm-3 col-form-label" for="meta_description">{{ _i('Meta Description') }}
                            </label>
                            <div class="col-sm-9">
                                <textarea name="meta_description" id="meta_description"
                                    class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="row">
                            <label class="col-sm-3 col-form-label" for="img_description">{{ _i('Image Description') }}
                            </label>
                            <div class="col-sm-9">
                                <textarea name="img_description" id="img_description" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn btn-default" type="button">{{ _i('Close') }}</button>
                    <button type="submit" id="creat_save"
                        class="btn btn-primary waves-effect waves-light">{{ _i('Save') }}</button>
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
                $("#creat_save").addClass("btn-loading");
                $("#creat_save").prop("disabled", true);

                $.ajax({
                    url: url,
                    type: "POST",
                    data: new FormData(this),
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    complete: function() {
                        $("#creat_save").removeClass("btn-loading");
                        $("#creat_save").prop("disabled", false);

                    },
                    success: function(response) {

                        if (response.errors) {
                            $('#masages_model').empty();
                            $.each(response.errors, function(index, value) {
                                $('#masages_model').show();
                                $('#masages_model').append(value + "<br>");
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
                            $('.modal.modal_create').modal('hide');
                            get_parent();
                            getData(page);
                            $('#title').val("");
                            $('#parentId').val("");
                        }
                    }
                });

            });
        });
    </script>
@endpush
