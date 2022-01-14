<div class="modal modal_edit fade" id="modal-edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" > {{_i('Edit Blog')}} </h4>
            </div>
            <div class="modal-body">
                <form id="form_edit" class="form-horizontal" method="POST" data-parsley-validate="" enctype="multipart/form-data">
                    @csrf
                    <div class="box-body">
                        <input type="hidden" id="blog_id" name="blog_id">
                        <div class="callout text-danger" id="messages_model" style="display:none">
                        </div>
                        <div class="form-group row" >
                            <label class=" col-sm-3 col-form-label" for="categoryId"><?=_i('Blog Category')?><span style="color: #F00;">*</span></label>
                            <div class="col-sm-9">
                                <select class="form-control" name="category_id" id="categoryId">
                                    @foreach($categories_data as $cat)
                                        <option value="{{$cat->category_id}}">{{$cat->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row" >
                            <label class=" col-sm-3 col-form-label" for="created_data"><?=_i('Created Date')?></label>
                            <div class="col-sm-5">
                                <input type="date" class="form-control" name="created" id="created_data"  placeholder="YYYY-MM-DD"
                                       data-inputmask="'alias': 'yyyy-mm-dd'" data-mask=""   >
                                <span class="help-block">{{_i('Select date')}}</span>
                            </div>
                            <!----- publish row--->
                            <span class="col-sm-1 "></span>
                            <label class="col-sm-1 col-form-label" for="published_edit">
                                {{_i('Publish')}}
                            </label>
                            <div class="mt-1 col-sm-1">
                                <label>
                                    <input type="checkbox" class="js-switch-small" name="published" id="published_edit">
                                </label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="titlet_edit" class="col-sm-2 control-label"> <?=_i('Title')?> <span style="color: #F00;">*</span> </label>
                            <div class="col-sm-10">
                                <input type="text" id="titlet_edit" class="form-control" name="title" required="" placeholder="{{_i('Please Enter Slider Title')}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="image_edit">{{_i('Image')}} <span style="color: #F00;">*</span></label>
                            <div class="col-sm-10">
                                <input type="file" name="img" id="image_edit" onchange="showImgEdit(this)"
                                       class="btn btn-default" accept="image/*" >
                                <img class="img-responsive pad" id="old_imgedit" style=" width: 100px; height: 100px;"
                                     src="{{asset('custom/index.png')}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="slug_edit">{{_i('Slug')}} </label>
                            <div class="col-sm-10">
                                <input type="text" name="slug" id="slug_edit" class="form-control" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="content_edit">{{_i('Content')}} </label>
                            <div class="col-sm-10">
                                <textarea class="wysihtml5 form-control" id="content_edit" name="content_blog" rows="10"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="metakeyword_edit">{{_i('Meta Keywords')}} </label>
                            <div class="col-sm-10">
                                <textarea name="meta_keyword" id="metakeyword_edit" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="metadescription_edit">{{_i('Meta Description')}} </label>
                            <div class="col-sm-10">
                                <textarea name="meta_description" id="metadescription_edit" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="imgdescription_edit">{{_i('Image Description')}} </label>
                            <div class="col-sm-10">
                                <textarea name="img_description" id="imgdescription_edit" class="form-control"></textarea>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button data-dismiss="modal" class="btn btn-default" type="button">{{_i('Close')}}</button>
                        <button class="btn btn-success" type="submit" id="s_form_1"> {{_i('Save')}} </button>
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
            var blogId = $(this).data('blogid');
            var categoryId = $(this).data('categoryid');
            var created = $(this).data('created');
            var published = $(this).data('published');
            var title = $(this).data('title');
            var slug = $(this).data('slug');
            var img = $(this).data('img');
            var content = $(this).data('content');
            var metakeyword = $(this).data('metakeyword');
            var metadescription = $(this).data('metadescription');
            var imgdescription = $(this).data('imgdescription');

            $('#blog_id').val(blogId);
            $('#categoryId').val(categoryId);
            $('#created_data').val(created);
            // $('#published_edit').val(published);
            if ( published == 1 ) {
                $('#published_edit').attr('checked', true);
            }else{
                $('#published_edit').attr('checked', false);
            }
            $('#titlet_edit').val(title);
            $('#slug_edit').val(slug);
            $("#old_imgedit").attr('src',"{{asset('')}}/"+img);
            $('#content_edit').val(content);
            $('#metakeyword_edit').val(metakeyword);
            $('#metadescription_edit').val(metadescription);
            $('#imgdescription_edit').val(imgdescription);
        });

        function showImgEdit(input) {
            var filereader = new FileReader();
            filereader.onload = (e) => {
                //console.log(e);
                $("#old_imgedit").attr('src', e.target.result).width(100).height(100);
            };
            //console.log(input.files);
            filereader.readAsDataURL(input.files[0]);
        }

        $(function() {
            $('#form_edit').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ route('master.blogs.update') }}",
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
