<div class="modal modal_urls fade" id="modal-url" tabindex="-1" role="dialog" style="z-index: 1050; display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ _i('Blog Urls') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <form action="" method="POST" id='form_blog_urls' data-parsley-validate="">
                @csrf {{ method_field('POST') }}
                @method("POST")
                <input type="hidden" name="blog_id" id="blogId">
                <div class="modal-body " >
                    <div class="callout text-danger" id="masages_model" style="display:none">
                    </div>

                    <div class="form-group ">
                        <div class="row">
                        <label class=" col-sm-2 col-form-label"><?=_i('Links')?> : </label>
                        <div class="col-sm-10">
{{--                            <input type="url" class="form-control" name="blog_urls[]" id="blog_url" data-parsley-type="url" >--}}
                            <div class="row" id="url_box_edit">
{{--                                <div class="row form-group" >--}}
{{--                                    <div class="col-sm-10">--}}
{{--                                        <input type="url" class="form-control" name="blog_urls[]" id="blog_url" data-parsley-type="url" >--}}
{{--                                    </div>--}}
{{--                                    <div class="col-sm-2">--}}
{{--                                        <a href="#" class="btn btn-sm btn-danger del_url text-center"  onclick="DeleteUrl(this)" >--}}
{{--                                            <i class="fa fa-trash-o"></i>--}}
{{--                                        </a>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                            </div>
                            <div class="row">
                                <a href="#" class="btn btn-success  text-center btn-sm" id="add_url_edit">
                                    <i class="fa fa-plus"></i>
                                </a>
                            </div>

                        </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn btn-default" type="button">{{_i('Close')}}</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light" >{{ _i('Save') }}</button>
                </div>
            </form>

        </div>
    </div>
</div>
@push('js')
    <script>
        $('body').on('click','#add_url_edit',function (e) {
            $('#url_box_edit').append(`
            <div class="row form-group" >
                <div class="col-sm-10">
                    <input type="url" class="form-control" name="blog_urls[]"  data-parsley-type="url" >
                </div>
                <div class="col-sm-2">
                    <a href="#" class="btn btn-sm btn-danger del_url text-center"  onclick="DeleteUrl(this)" >
                         <i class="fa fa-trash-o"></i>
                    </a>
                </div>
            </div>
        `);
        });

        function DeleteUrl(obj)
        {
            $(obj).closest('.row').remove();
        }

        $('body').on('click', '.modalurls', function (e) {
            e.preventDefault();
            var blogId = $(this).data('blogid');
            $('#blogId').val(blogId);

            $.ajax({
                url: 'blogs/urls/'+blogId,
                method: "get",
                type: "get",
                data: {

                },
                success: function (response) {

                     $('#url_box_edit').empty();
                     if(response){
                         $.each(response,function(key,value){
                             $('#url_box_edit').append(`
                                <div class="row form-group" >
                                    <div class="col-sm-10">
                                        <input type="url" class="form-control" name="blog_urls[]" data-parsley-type="url" value="`+value+`" >
                                    </div>
                                    <div class="col-sm-2">
                                        <a href="#" class="btn btn-sm btn-danger del_url text-center"  onclick="DeleteUrl(this)" >
                                             <i class="fa fa-trash-o"></i>
                                        </a>
                                    </div>
                                </div>
                            `);
                         });
                     }
                }
            });
        });

        $(function() {
            $('#form_blog_urls').submit(function (e) {
                e.preventDefault();
                var url = $(this).attr('action');

                $.ajax({
                    url: "blogs/urls/{id}/store",
                    type: "POST",
                    data: new FormData(this),
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        if (response == 'SUCCESS') {
                            new Noty({
                                type: 'success',
                                layout: 'topRight',
                                text: "{{ _i('Saved Successfully')}}",
                                timeout: 2000,
                                killer: true
                            }).show();
                            $('.modal.modal_urls').modal('hide');
                            table.ajax.reload();
                        }
                    }
                });
            });
        });
    </script>

@endpush
