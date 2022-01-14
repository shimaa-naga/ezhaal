@extends('master.layout.index' ,['title' => _i('Create Blog')])

@section('content')
    <!--breadcrumbs start -->
    <div class="page-header">
        <h4 class="page-title">{{ _i('Create Blog') }}</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('MasterHome') }}"><i class="fa fa-home"></i> {{ _i('Home') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ url('master/blogs')  }}"> {{ _i('Blogs') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ _i('Create Blog') }}</li>
        </ol>
    </div>
    <!--breadcrumbs end -->
    <form action="../blogs" method="POST" id='form_add' data-parsley-validate="" enctype="multipart/form-data">
        <button type="submit"
                class="btn btn-success waves-effect waves-light pull-right col-md-12">{{ _i('Save') }}</button>

        @csrf {{ method_field('POST') }}
        @method("POST")
    <div class="row">
        <div class="callout text-danger" id="masages_model" style="display:none">
        </div>

        <div class="col-xl-8">
            <div class="card m-b-20">
                <div class="card-body">
                    <div class="form-group ">
                        <div class="row">
                        <!---- lang -->
                        <label class=" col-sm-3 col-form-label">
                            <?= _i('Language') ?>
                        </label>
                        <div class="col-sm-9">
                            <select class="form-control" name="lang_id" id="language_addform" required="">
                                @foreach ($languages as $lang)
                                    <option value="{{ $lang->id }}">{{ $lang->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="row">
                        <label class=" col-sm-3 col-form-label" for="catId"><?= _i('Blog Category') ?><span style="color: #F00;">*</span></label>
                        <div class="col-sm-9">
                            <select class="form-control" name="category_id" id="catId">
                                @foreach ($categories_data as $cat)
                                    <option value="{{ $cat->category_id }}">{{ $cat->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="row">
                        <label class=" col-sm-3 col-form-label" for="created"><?= _i('Created Date') ?></label>
                        <div class="col-sm-5">
                            <input type="date" class="form-control" name="created" id="created"  placeholder="YYYY-MM-DD"
                                   data-inputmask="'alias': 'yyyy-mm-dd'" data-mask=""   >
                            <span class="help-block">{{ _i('Select date') }}</span>
                        </div>
                        <!----- publish row--->
{{--                        <span class="col-sm-1 "></span>--}}
{{--                        <label class="col-sm-2 col-form-label" for="published">--}}
{{--                            {{ _i('Publish') }}--}}
{{--                        </label>--}}
                        <div class="mt-1 col-sm-4">
                            <label>
                                <input type="checkbox" class="js-switch-small" name="published" id="published" checked="">
                            </label>
                            {{ _i('Publish') }}
                        </div>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="row">
                        <label for="titlet_add" class="col-sm-3 control-label"> <?= _i('Title') ?> <span style="color: #F00;">*</span> </label>
                        <div class="col-sm-9">
                            <input type="text" id="titlet_add" class="form-control" name="title" required="" placeholder="{{ _i('Please Enter Slider Title') }}">
                        </div>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="row">
                        <label class="col-sm-3 col-form-label" for="slug_add">{{ _i('Slug') }} </label>
                        <div class="col-sm-9">
                            <input type="text" name="slug" id="slug_add" class="form-control" >
                        </div>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="row">
                        <label class="col-sm-3 col-form-label" for="content_add">{{ _i('Content') }} </label>
                        <div class="col-sm-9">
                            <textarea class="wysihtml5 form-control" id="content_add" name="content_blog" rows="10"></textarea>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end col -->
        <div class="col-xl-4">
            <div class="card m-b-20">
                <div class="card-body mb-0">
                    <div class="form-group row">

                        <div class="col-sm-12">
                            <img class="img-responsive pad" id="img" class="col-sm-12"
                                 src="{{ asset('custom/index.png') }}">

                            <input type="file" name="img" id="image_add" onchange="showImgTrans(this)"
                                   class="form-control" accept="image/*" >

                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-12 col-form-label" for="metakeyword_add">{{ _i('Meta Keywords') }} </label>
                        <div class="col-sm-12">
                            <textarea name="meta_keyword" id="metakeyword_add" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-12 col-form-label" for="metadescription_add">{{ _i('Meta Description') }} </label>
                        <div class="col-sm-12">
                            <textarea name="meta_description" id="metadescription_add" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-12 col-form-label" for="imgdescription_add">{{ _i('Image Description') }} </label>
                        <div class="col-sm-12">
                            <textarea name="img_description" id="imgdescription_add" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>


{{--    <form action="../blogs" method="POST" id='form_add' data-parsley-validate="" enctype="multipart/form-data">--}}
{{--        <button type="submit"--}}
{{--            class="btn btn-success waves-effect waves-light pull-right col-md-12">{{ _i('Save') }}</button>--}}

{{--        @csrf {{ method_field('POST') }}--}}
{{--        @method("POST")--}}
{{--        <!-- page start-->--}}
{{--        <div class="row">--}}
{{--            <div class="callout text-danger" id="masages_model" style="display:none">--}}
{{--            </div>--}}

{{--            <div class="col-md-8">--}}
{{--                <div class="panel">--}}
{{--                    <div class="panel-body">--}}

{{--                        <div class="form-group row">--}}
{{--                            <!---- lang -->--}}
{{--                            <label class=" col-sm-3 col-form-label">--}}
{{--                                <?= _i('Language') ?>--}}
{{--                            </label>--}}
{{--                                    <div class="col-sm-9">--}}
{{--                                        <select class="form-control" name="lang_id" id="language_addform" required="">--}}
{{--                                            @foreach ($languages as $lang)--}}
{{--                                                <option value="{{ $lang->id }}">{{ $lang->title }}</option>--}}
{{--                                            @endforeach--}}
{{--                                        </select>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="form-group row" >--}}
{{--                                    <label class=" col-sm-3 col-form-label" for="catId"><?= _i('Blog Category') ?><span style="color: #F00;">*</span></label>--}}
{{--                                    <div class="col-sm-9">--}}
{{--                                        <select class="form-control" name="category_id" id="catId">--}}
{{--                                            @foreach ($categories_data as $cat)--}}
{{--                                                <option value="{{ $cat->category_id }}">{{ $cat->title }}</option>--}}
{{--                                            @endforeach--}}
{{--                                        </select>--}}
{{--                                    </div>--}}
{{--                                </div>--}}


{{--                                <div class="form-group row" >--}}
{{--                                    <label class=" col-sm-3 col-form-label" for="created"><?= _i('Created Date') ?></label>--}}
{{--                                    <div class="col-sm-5">--}}
{{--                                        <input type="date" class="form-control" name="created" id="created"  placeholder="YYYY-MM-DD"--}}
{{--                                               data-inputmask="'alias': 'yyyy-mm-dd'" data-mask=""   >--}}
{{--                                        <span class="help-block">{{ _i('Select date') }}</span>--}}
{{--                                    </div>--}}
{{--                                    <!----- publish row--->--}}
{{--                                    <span class="col-sm-1 "></span>--}}
{{--                                    <label class="col-sm-1 col-form-label" for="published">--}}
{{--                                        {{ _i('Publish') }}--}}
{{--                                    </label>--}}
{{--                                    <div class="mt-1 col-sm-2">--}}
{{--                                        <label>--}}
{{--                                            <input type="checkbox" class="js-switch-small" name="published" id="published" checked="">--}}
{{--                                        </label>--}}
{{--                                    </div>--}}
{{--                                </div>--}}


{{--                <div class="form-group row">--}}
{{--                    <label for="titlet_add" class="col-sm-3 control-label"> <?= _i('Title') ?> <span style="color: #F00;">*</span> </label>--}}
{{--                    <div class="col-sm-9">--}}
{{--                        <input type="text" id="titlet_add" class="form-control" name="title" required="" placeholder="{{ _i('Please Enter Slider Title') }}">--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                <div class="form-group row">--}}
{{--                    <label class="col-sm-3 col-form-label" for="slug_add">{{ _i('Slug') }} </label>--}}
{{--                    <div class="col-sm-9">--}}
{{--                        <input type="text" name="slug" id="slug_add" class="form-control" >--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="form-group row">--}}
{{--                    <label class="col-sm-3 col-form-label" for="content_add">{{ _i('Content') }} </label>--}}
{{--                    <div class="col-sm-9">--}}
{{--                        <textarea class="wysihtml5 form-control" id="content_add" name="content_blog" rows="10"></textarea>--}}
{{--                    </div>--}}
{{--                </div>--}}



{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="col-md-4">--}}
{{--                        <div class="panel">--}}
{{--                            <div class="panel-body">--}}

{{--                                <div class="form-group row">--}}

{{--                                    <div class="col-sm-12">--}}
{{--                                        <img class="img-responsive pad" id="img" class="col-sm-12"--}}
{{--                                        src="{{ asset('custom/index.png') }}">--}}

{{--                                        <input type="file" name="img" id="image_add" onchange="showImgTrans(this)"--}}
{{--                                               class="form-control" accept="image/*" >--}}

{{--                                    </div>--}}
{{--                                </div>--}}

{{--                                <div class="form-group row">--}}
{{--                                    <label class="col-sm-12 col-form-label" for="metakeyword_add">{{ _i('Meta Keywords') }} </label>--}}
{{--                                    <div class="col-sm-12">--}}
{{--                                        <textarea name="meta_keyword" id="metakeyword_add" class="form-control"></textarea>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="form-group row">--}}
{{--                                    <label class="col-sm-12 col-form-label" for="metadescription_add">{{ _i('Meta Description') }} </label>--}}
{{--                                    <div class="col-sm-12">--}}
{{--                                        <textarea name="meta_description" id="metadescription_add" class="form-control"></textarea>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="form-group row">--}}
{{--                                    <label class="col-sm-12 col-form-label" for="imgdescription_add">{{ _i('Image Description') }} </label>--}}
{{--                                    <div class="col-sm-12">--}}
{{--                                        <textarea name="img_description" id="imgdescription_add" class="form-control"></textarea>--}}
{{--                                    </div>--}}
{{--                                </div>--}}


{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}


{{--                </div>--}}

{{--            </form>--}}
@endsection

@push('js')

            <script>
                $(function(){
    $('.wysihtml5').wysihtml5();
});
                 function showImgTrans(input) {
                var filereader = new FileReader();
                filereader.onload = (e) => {
                    //console.log(e);
                    $("#img").attr('src', e.target.result);
                };
                //console.log(input.files);
                filereader.readAsDataURL(input.files[0]);
            }
                $(function() {
                    $('.default-date-picker').datepicker({
                        dateFormat: 'yy-mm-dd'
                    });
                    // $.datepicker.setDefaults({
                    //     dateFormat: 'yy-mm-dd'
                    // });
                });
                $(function() {
                    // $('#form_add').submit(function(e) {
                    //     e.preventDefault();
                    //     var url = $(this).attr('action');

                    //     $.ajax({
                    //         {{-- // url: "{{ route('master.sliders.store')}}", --}}
                    //         url: url,
                    //         type: "POST",
                    //         data: new FormData(this),
                    //         dataType: 'json',
                    //         cache: false,
                    //         contentType: false,
                    //         processData: false,
                    //         success: function(response) {
                    //             if (response.errors) {
                    //                 $('#masages_model').empty();
                    //                 $.each(response.errors, function(index, value) {
                    //                     $('#masages_model').show();
                    //                     $('#masages_model').append(value + "<br>");
                    //                 });
                    //             }
                    //             if (response == 'SUCCESS') {
                    //                 new Noty({
                    //                     type: 'success',
                    //                     layout: 'topRight',
                    //                     text: "{{ _i('Saved Successfully') }}",
                    //                     timeout: 2000,
                    //                     killer: true
                    //                 }).show();
                    //                 $('.modal.modal_create').modal('hide');
                    //                 table.ajax.reload();
                    //                 $('#catId').val("");
                    //                 $('#created').val("");
                    //                 $('#published').val("");
                    //             }
                    //         }
                    //     });
                    // });
                });

            </script>
@endpush
