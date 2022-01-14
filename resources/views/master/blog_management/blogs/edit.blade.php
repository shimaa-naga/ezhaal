@extends('master.layout.index' ,['title' => _i('Blogs')])

@section('content')
    <!--breadcrumbs start -->
    <div class="page-header">
        <h4 class="page-title">{{ $data->title }}</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('MasterHome') }}"><i class="fa fa-home"></i> {{ _i('Home') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ url('master/blogs')  }}"> {{ _i('Blogs') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $data->title }}</li>
        </ol>
    </div>
    <!--breadcrumbs end -->

    <form id="form_edit" class="form-horizontal" action="../{{$data->id}}" method="POST" data-parsley-validate="" enctype="multipart/form-data">
        <button type="submit" class="btn btn-success waves-effect waves-light pull-right col-md-12">{{ _i('Save') }}</button>

        @csrf {{ method_field('POST') }}
        @method("PUT")
        <!-- page start-->
        <div class="row">

            <div class="col-xl-8">
                <div class="card m-b-20">
                    <div class="card-body">
                        <input type="hidden" id="blog_id" name="blog_id">

                        <div class="form-group ">
                            <div class="row">
                                <label class=" col-sm-3 col-form-label" for="categoryId"><?= _i('Blog Category') ?><span style="color: #F00;">*</span></label>
                            <div class="col-sm-9">
                                {!! Form::select('category_id', $categories_data->pluck('title', 'category_id'), $data->categoryId, ['class' => 'form-control']) !!}
                            </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="row">
                                <label class=" col-sm-3 col-form-label" for="created_data"><?= _i('Created Date') ?></label>
                            <div class="col-sm-5">
                                <input type="date" class="form-control" name="created" id="created_data"  placeholder="YYYY-MM-DD" value="{{ $data->created}}"
                                       data-inputmask="'alias': 'yyyy-mm-dd'" data-mask=""   >
                            </div>
                            <!----- publish row--->
                            <div class="mt-1 col-sm-4">
                                <label>
                                    {!! Form::checkbox('published', '1', $data->published) !!}
                                    {{ _i('Publish') }}
                                </label>

                            </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="row">
                                <label for="titlet_edit" class="col-sm-3 col-form-label"> <?= _i('Title') ?> <span style="color: #F00;">*</span> </label>
                            <div class="col-sm-9">
                                <input type="text" value="{{ $data->title }}" id="titlet_edit" class="form-control" name="title" required="" placeholder="{{ _i('Please Enter Slider Title') }}">
                            </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="row">
                                <label class="col-sm-3 col-form-label" for="slug_edit">{{ _i('Slug') }} </label>
                            <div class="col-sm-9">
                                <input type="text" name="slug" value="{{ $data->slug }}" id="slug_edit" class="form-control" >
                            </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="row">
                                <label class="col-sm-3 col-form-label" for="content_edit">{{ _i('Content') }} </label>
                            <div class="col-sm-9">
                                <textarea class="wysihtml5 form-control" id="content_edit" name="content_blog" rows="10">{!! $data->content !!}</textarea>
                            </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-xl-4">
                <div class="card m-b-20">
                    <div class="card-body mb-0">
                        <div class="form-group row">

                            <div class="col-sm-12">
                                <img class="img-responsive pad" id="old_imgedit" class="col-sm-12"
                                     src="{{ asset($data->img) != '' ? asset($data->img) : asset('custom/index.png') }}">
                                <input type="file" name="img" onchange="showImgTrans(this)"  class="form-control" accept="image/*" >

                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-12 col-form-label" for="metakeyword_edit">{{ _i('Meta Keywords') }} </label>
                            <div class="col-sm-12">
                                <textarea name="meta_keyword" id="metakeyword_edit" class="form-control">{{ $data->meta_keyword }}</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-12 col-form-label" for="metadescription_edit">{{ _i('Meta Description') }} </label>
                            <div class="col-sm-12">
                                <textarea name="meta_description" id="metadescription_edit" class="form-control">{{ $data->meta_description }}</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-12 col-form-label" for="imgdescription_edit">{{ _i('Image Description') }} </label>
                            <div class="col-sm-12">
                                <textarea name="img_description" id="imgdescription_edit" class="form-control">{{ $data->img_description }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


                    </form>
@endsection
@push('js')

                        <script type="text/javascript">
$(function(){
    $('.wysihtml5').wysihtml5();
});
                             function showImgTrans(input) {
                            var filereader = new FileReader();
                            filereader.onload = (e) => {
                                //console.log(e);
                                $("#old_imgedit").attr('src', e.target.result);
                            };
                            //console.log(input.files);
                            filereader.readAsDataURL(input.files[0]);
                        }
                        </script>
            @endpush
