<div class="modal modal_create fade" id="add-Modal" tabindex="-1" role="dialog" style="z-index: 1050; display: none;"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ _i('Create new Blog Category') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <form action="{{ route('master.blog_category.store') }}" method="POST" id='form_add'
                data-parsley-validate="" enctype="multipart/form-data">
                @csrf {{ method_field('POST') }}
                @method("POST")
                <div class="modal-body ">
                    <div class="callout text-danger" id="masages_model" style="display:none">
                    </div>
                    <div class="form-group ">
                        <div class="row">
                            <label class=" col-sm-2 col-form-label"><?= _i('Language') ?><span
                                    style="color: #F00;">*</span></label>
                            <div class="col-sm-10">
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
                            <label class=" col-sm-2 col-form-label"><?= _i('Title') ?> <span
                                    style="color: #F00;">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" id="title" class="form-control" name="title" required=""
                                    placeholder="{{ _i('Please Enter Title') }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="row">
                            <label class="col-sm-2 col-form-label" for="image">{{ _i('Image') }} <span
                                    style="color: #F00;">*</span></label>
                            <div class="col-sm-10">
                                <input type="file" name="img" id="img_add" class="btn btn-default form-control"
                                    accept="image/*" required="">
                                <span class="text-danger invalid-feedback">
                                    <strong>{{ $errors->first('img') }}</strong>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="row">
                            <label class="col-sm-2 col-form-label" for="slug">{{ _i('Slug') }} </label>
                            <div class="col-sm-10">
                                <input type="text" name="slug" id="slug" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="row">
                            <label class="col-sm-2 col-form-label" for="meta_keyword">{{ _i('Meta Keywords') }} </label>
                            <div class="col-sm-10">
                                <textarea name="meta_keyword" id="meta_keyword" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="row">
                            <label class="col-sm-2 col-form-label" for="meta_description">{{ _i('Meta Description') }}
                            </label>
                            <div class="col-sm-10">
                                <textarea name="meta_description" id="meta_description"
                                    class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="row">
                            <label class="col-sm-2 col-form-label" for="img_description">{{ _i('Image Description') }}
                            </label>
                            <div class="col-sm-10">
                                <textarea name="img_description" id="img_description" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn btn-default" type="button">{{ _i('Close') }}</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">{{ _i('Save') }}</button>
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
                    {{-- // url: "{{ route('master.sliders.store')}}", --}}
                    url: url,
                    type: "POST",
                    data: new FormData(this),
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
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
                            table.ajax.reload();
                            $('#title').val("");
                            $('#img_add').val("");
                            $('#slug').val("");
                            $('#meta_keyword').val("");
                            $('#meta_description').val("");
                            $('#img_description').val("");
                        }
                    }
                });
            });
        });
    </script>
@endpush
