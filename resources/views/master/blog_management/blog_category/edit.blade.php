<div class="modal modal_edit fade" id="modal-edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" > {{_i('Edit Blog Category')}} </h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <form id="form_edit" class="form-horizontal" method="POST" data-parsley-validate="" enctype="multipart/form-data">
                    @csrf
                    <div class="box-body">
                        <input type="hidden" id="blog_cat_data_id" name="blog_cat_data_id">
                        <input type="hidden" id="categoryId" name="category_id">
                        <div class="callout text-danger" id="messages_model" style="display:none">
                        </div>
                        <div class="form-group ">
                            <div class="row">
                            <label class=" col-sm-2 col-form-label"><?=_i('Language')?><span style="color: #F00;">*</span></label>
                            <div class="col-sm-10">
                                <select class="form-control" name="lang_id" id="langid">
                                    @foreach($languages as $lang)
                                        <option value="{{$lang->id}}">{{$lang->title}}</option>
                                    @endforeach
                                </select>
                            </div></div>
                        </div>
                        <div class="form-group ">
                            <div class="row">
                            <label class=" col-sm-2 col-form-label"><?=_i('Title')?> <span style="color: #F00;">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" id="data_title" class="form-control" name="title"  required="" placeholder="{{_i('Please Enter Title')}}">
                            </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="row">
                            <label class="col-sm-2 col-form-label" for="image">{{_i('Image')}} <span style="color: #F00;">*</span></label>
                            <div class="col-sm-10">
                                <input type="file" name="img" id="image" onchange="showImg(this)"
                                       class="btn btn-default" accept="image/*" >
                                <img class="img-responsive pad" id="old_img" style=" width: 100px; height: 100px;"
                                     src="">
                                <span class="text-danger invalid-feedback">
                                    <strong>{{$errors->first('img')}}</strong>
                                </span>
                            </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="row">
                            <label class="col-sm-2 col-form-label" for="data_slug">{{_i('Slug')}} </label>
                            <div class="col-sm-10">
                                <input type="text" name="slug" id="data_slug" class="form-control" >
                            </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="row">
                            <label class="col-sm-2 col-form-label" for="metakeyword">{{_i('Meta Keywords')}} </label>
                            <div class="col-sm-10">
                                <textarea name="meta_keyword" id="metakeyword" class="form-control"></textarea>
                            </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="row">
                            <label class="col-sm-2 col-form-label" for="metadescription">{{_i('Meta Description')}} </label>
                            <div class="col-sm-10">
                                <textarea name="meta_description" id="metadescription" class="form-control"></textarea>
                            </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="row">
                            <label class="col-sm-2 col-form-label" for="imgdescription">{{_i('Image Description')}} </label>
                            <div class="col-sm-10">
                                <textarea name="img_description" id="imgdescription" class="form-control"></textarea>
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button data-dismiss="modal" class="btn btn-default" type="button">{{_i('Close')}}</button>
                        <button class="btn btn-primary" type="submit" id="s_form_1"> {{_i('Save')}} </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        $('body').on('click', '.edit', function (e) {
            e.preventDefault();
            $('#messages_model').empty();
            var blogCatDataId = $(this).data('cat_dataid');
            var blogCatId = $(this).data('id');
            var langId = $(this).data('lang');
            var title = $(this).data('title');
            var slug = $(this).data('slug');
            var metaKeyword = $(this).data('metakeyword');
            var metaDescription = $(this).data('metadescription');
            var imgDescription = $(this).data('imgdescription');
            var image = $(this).data('image');
            // var categoryId = $(this).data('categoryid');


            $('#blog_cat_data_id').val(blogCatDataId);
            $('#categoryId').val(blogCatId);
            $('#langid').val(langId);
            $('#data_title').val(title);
            $('#data_slug').val(slug);
            $('#metakeyword').val(metaKeyword);
            $('#metadescription').val(metaDescription);
            $('#imgdescription').val(imgDescription);
            $("#old_img").attr('src',"{{asset('')}}/"+image);
            // $('#categoryId').val(categoryId);

        });

        function showImg(input) {
            var filereader = new FileReader();
            filereader.onload = (e) => {

                $("#old_img").attr('src', e.target.result).width(100).height(100);
            };
            filereader.readAsDataURL(input.files[0]);
        }

        $(function() {
            $('#form_edit').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ route('master.blog_category.update') }}",
                    type: "POST",
                    data: new FormData(this),
                    dataType: 'json',
                    cache       : false,
                    contentType : false,
                    processData : false,
                    success: function(response) {
                        if (response.errors){
                            $('#messages_model').empty();
                            $.each(response.errors, function(index, value) {
                                $('#messages_model').show();
                                $('#messages_model').append(value + "<br>");
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
                            $('.modal.modal_edit').modal('hide');
                            table.ajax.reload();
                        }
                    }
                });
            });
        });
    </script>
@endpush
