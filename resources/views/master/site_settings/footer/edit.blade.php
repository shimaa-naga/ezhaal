<div class="modal modal_edit fade" id="modal-edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ _i('Edit Footer') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_edit" class="form-horizontal" method="POST" data-parsley-validate=""
                    enctype="multipart/form-data">
                    @csrf
                    <div class="box-body">
                        <input type="hidden" id="footer_id" name="footer_id">

                        <div class="form-group  ">
                            <div class="row">
                                <label class=" col-sm-2 col-form-label"><?= _i('Language') ?><span style="color: #F00;">*</span></label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="lang_id" id="langId" required="">
                                        <option value="" selected disabled>{{ _i('Select language') }}</option>
                                        @foreach ($languages as $lang)
                                            <option value="{{ $lang->id }}">{{ $lang->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>


                        <div class="form-group  ">
                            <div class="row">
                            <label for="order_edit" class=" col-sm-2 col-form-label"><?= _i('Order') ?> <span style="color: #F00;">*</span></label>
                            <div class="col-sm-10">
                                <select class="form-control" name="order" required="" id="order_edit">
                                    <option selected disabled><?= _i('CHOOSE') ?></option>
                                    @for ($i = 1; $i <= 10; $i++)
                                        <option value="<?= $i ?>"><?= $i ?></option>
                                    @endfor
                                </select>
                            </div>
                            </div>
                        </div>
                        <div class="form-group  ">
                            <div class="row">
                            <label for="titletrans" class="col-sm-2 control-label"> <?= _i('Title') ?> <span style="color: #F00;">*</span> </label>
                            <div class="col-sm-10">
                                <input type="text" id="title_edit" class="form-control" name="title" required="" placeholder="{{ _i('Please Enter Footer Title') }}">
                            </div>
                            </div>
                        </div>
                        <div class="form-group  ">
                            <div class="row">
                            <label class="col-sm-2 control-label" for="editor1"> <?= _i('Content') ?> <span style="color: #F00;">*</span> </label>
                            <div class="col-sm-10">
                            <textarea id="editor2" class="textarea form-control" name="content_edit" required=""
                                  placeholder="{{ _i('Place write content here') }}..."></textarea>
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
                        $(function() {
                            CKEDITOR.replace('editor2', {
                                height: 200,
                                extraPlugins: 'colorbutton,colordialog',
                            });
                        });
                        $('body').on('click', '.edit', function (e) {
                            e.preventDefault();
                            var FooterId = $(this).data('id');

                            $.ajax({
                                    url: "footer/"+FooterId,
                                    type: "GET",
                                    dataType: 'json',
                                    success: function(response) {
                                        if (response.status == 'ok'){
                                            var order = response.data.order;
                            var lang = response.data.lang_id;
                            var title = response.data.title;
                            var content = response.data.content;
               // alert(content);
                            $('#footer_id').val(FooterId);
                            $('#order_edit').val(order);
                            $('#langId').val(lang);
                            $('#title_edit').val(title);
                            CKEDITOR.instances.editor2.setData(content);
                                        }
                                    }
                                });

                        });

                        $(function() {
                            $('#form_edit').submit(function(e) {
                                e.preventDefault();
                                var data = new FormData(this);
                                data.set("content_edit",CKEDITOR.instances.editor2.getData());

                              //  console.log(data);
                                $.ajax({
                                    url: "{{ route('master.footer.update') }}",
                                    type: "POST",
                                    data:data,

                                    contentType : false,
                                    processData : false,
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
