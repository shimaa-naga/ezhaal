@if ($blog->published == 0)
    <?php $head = _i('Blog not Found'); ?>
@else

    <?php $head = "<a href='" . url(' blog/cat/' . $category->id) . "'>" . $category->title . '</a> / ' .
    $blog_data->title ?? _i('Blog not translated yet'); ?>
    @extends('website.layout.index', ['title' => $title,'header_title' => $head,"meta_keywords" =>
    $blog_data->meta_keyword ,
    "meta_description" => $blog_data->meta_description ,
    "meta_title" => $blog_data->title,
    "meta_image" => asset($blog_data->img) ])
    @section('content')
        <div class="container">
            <div class="row">
                <!--Left Side Content-->
                <div class="col-xl-4 col-lg-4 col-md-12">

                    @include("website.blog_management.partial.categories")

                    <div class="card mb-lg-0">
                        <div class="card-header">
                            <h3 class="card-title">{{ _i('Related Blogs') }}</h3>
                        </div>
                        <div class="card-body p-0">
                            <ul class="vertical-scroll">

                                @foreach ($related_blogs as $related_blog)
                                    <li class="item2">
                                        <div class="footerimg d-flex mt-0 mb-0">
                                            <div class="d-flex footerimg-l mb-0">
                                                <img src="@if ($related_blog->img != null &&
                                                file_exists(public_path($related_blog->img))) {{ asset($related_blog->img) }}@else{{ asset('uploads/no-image.jpg') }} @endif" alt="{{ $related_blog->img_description }}"
                                                title="{{ $related_blog->meta_description }}" class="avatar brround mr-2">
                                                <a href="{{ route('website.blog', [$related_blog->slug == null ? $related_blog->title : $related_blog->slug, $related_blog->id]) }}"
                                                    class="time-title p-0 leading-normal mt-2">{{ $related_blog->title }}
                                                </a>
                                                <br />


                                            </div>
                                            <div class="mt-2 footerimg-r m{{\App\Help\Utility::getLangCode() == 'ar' ? 'r' : 'l'}}-auto">
                                                <small><i class="fa fa-calendar"></i>
                                                    {{ date('d M, Y', strtotime($related_blog->created)) }}</small>

                                            </div>
                                        </div>
                                    </li>

                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <!--/Left Side Content-->

                <!--Add Lists-->
                <div class="col-xl-8 col-lg-8 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="item7-card-img">
                                <img src="{{ asset($blog_data->img) }}" title="{{ $blog_data->img_description }}"
                                    alt="{{ $blog_data->img_description }}" class="w-100">
                                <div class="item7-card-text">
                                    <span class="badge badge-info">Jobs</span>
                                </div>
                            </div>
                            <div class="item7-card-desc d-flex mb-2 mt-3">
                                <a href="#"><i class="fa fa-calendar-o text-muted mr-2"></i>
                                    {{ date('d M Y', strtotime($blog->created)) }}</a>
                                <a href="#"><i class="fa fa-user text-muted mr-2"></i> @php
                                    $user = \App\User::where('id', $blog->by_id)->first();
                                @endphp
                                    @if ($user != null)
                                        {{ $user->name . ' ' . $user->last_name }}
                                    @endif
                                </a>
                                <div class="m{{\App\Help\Utility::getLangCode() == 'ar' ? 'r' : 'l'}}-auto">
                                    <a href="#"><i class="fa fa-comment-o text-muted mr-2"></i>
                                        {{ $blog_comments->count() }} {{ _i('Comments') }}
                                    </a>
                                </div>
                            </div>
                            <a href="{{ route('website.blog', [$blog_data->slug, $blog->id]) }}" class="text-dark">
                                <h2 class="font-weight-semibold"> {{ $blog_data->title }}</h2>
                            </a>

                            <p>
                                {!! $blog_data->content !!} </p>
                            <h5 class="widget-title">{{ _i('Urls') }}</h5>
                            <ul class="cat-list">
                                {{-- <li><a href="#">October 2016 <span class="num-posts">(29)</span></a></li>                                </li> --}}
                                @foreach ($blog_urls as $blog_url)
                                    <li>
                                        <a href="{{ $blog_url->url }}">{{ $blog_url->url }}</a>
                                    </li>
                                @endforeach
                            </ul>

                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ _i('Comments') }}</h3>
                        </div>
                        <div class="card-body p-0" id="comments">
                            @foreach ($blog_comments as $comment)
                                @php
                                    $comment_user = \App\WebsiteUser::all()
                                        ->where('id', $comment->user_id)
                                        ->first();
                                @endphp
                                <div class="media mt-0 p-5">
                                    <div class="d-flex mr-3">
                                        <a href="#"><img class="media-object brround" alt="64x64" src="@if ($comment_user->image != null &&
                                            file_exists(public_path($comment_user->image))) {{ asset($comment_user->image) }}@else{{ asset('uploads/users/default.png') }} @endif"> </a>
                                    </div>
                                    <div class="media-body">
                                        <h5 class="mt-0 mb-1 font-weight-semibold">
                                            {{ $comment_user->name . ' ' . $comment_user->last_name }}
                                            <span class="fs-14 m{{\App\Help\Utility::getLangCode() == 'ar' ? 'r' : 'l'}}-0" data-toggle="tooltip" data-placement="top" title=""
                                                data-original-title="verified"><i
                                                    class="fa fa-check-circle-o text-success"></i></span>
                                            <span class="fs-14 m{{\App\Help\Utility::getLangCode() == 'ar' ? 'r' : 'l'}}-2"> 4.5 <i class="fa fa-star text-yellow"></i></span>
                                        </h5>
                                        <small class="text-muted"><i
                                                class="fa fa-calendar"></i>{{ date('d M, Y', strtotime($comment->created_at)) }}
                                            <i class=" m{{\App\Help\Utility::getLangCode() == 'ar' ? 'r' : 'l'}}-3 fa fa-clock-o"></i> 13.00 <i class=" m{{\App\Help\Utility::getLangCode() == 'ar' ? 'r' : 'l'}}-3 fa fa-map-marker"></i>
                                            Brezil</small>
                                        <p class="font-13  mb-2 mt-2">
                                            {{ $comment->comment }}
                                        </p>
                                        <a href="#" class="mr-2"><span class="badge badge-primary">Helpful</span></a>
                                        <a href="" class="mr-2" data-toggle="modal" data-target="#Comment"><span
                                                class="">Comment</span></a>
                                        <a href="" class="mr-2" data-toggle="modal" data-target="#report"><span
                                                class="">Report</span></a>
                                        {{-- <div class="media mt-5">
                                    <div class="d-flex mr-3">
                                        <a href="#"> <img class="media-object brround" alt="64x64" src="../assets/images/faces/female/2.jpg"> </a>
                                    </div>
                                    <div class="media-body">
                                        <h5 class="mt-0 mb-1 font-weight-semibold">Rose Slater <span class="fs-14 m{{\App\Help\Utility::getLangCode() == 'ar' ? 'r' : 'l'}}-0" data-toggle="tooltip" data-placement="top" title="" data-original-title="verified"><i class="fa fa-check-circle-o text-success"></i></span></h5>
                                        <small class="text-muted"><i class="fa fa-calendar"></i> Dec 22st  <i class=" m{{\App\Help\Utility::getLangCode() == 'ar' ? 'r' : 'l'}}-3 fa fa-clock-o"></i> 6.00  <i class=" m{{\App\Help\Utility::getLangCode() == 'ar' ? 'r' : 'l'}}-3 fa fa-map-marker"></i> Brezil</small>
                                        <p class="font-13  mb-2 mt-2">
                                           Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris   commodo Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur consequat.
                                        </p>
                                        <a href="" data-toggle="modal" data-target="#Comment"><span class="badge badge-default">Comment</span></a>
                                    </div>
                                </div> --}}
                                    </div>
                                </div>
                            @endforeach
                            <div>
                            </div>
                        </div>
                    </div>




                    @php
                    $auth_user = auth()
                        ->guard('web')
                        ->user();
                @endphp
                @if ($auth_user != null)
                <div class="card mb-0" id="respond">
                    <div class="card-header">
                        <h3 class="card-title">{{_i("Write Your Comments")}}</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('website.blog.comment', $blog->id) }}"
                            id="form_comment" data-parsley-validate="" class="php-email-form">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input id="author" class="form-control" name="author" type="text"
                                            value="{{ $auth_user->name . ' ' . $auth_user->last_name }}"
                                            size="30" placeholder="{{ _i('Enter your name (optional)') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input id="email" class="form-control" name="author" type="text"
                                            value="{{ $auth_user->email }}" size="30"
                                            placeholder="{{ _i('Enter your email (optional)') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <textarea id="comment" class="form-control" name="comment" cols="45"
                                            rows="8"
                                            placeholder="{{ _i('Here goes your comment (required)') }}"
                                            required=""></textarea>
                                    </div>
                                    <button type="submit" id="submit"
                                        class="btn btn-common">{{ _i('Submit Comment') }}</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>

                @endif

                </div>
                <!--/Add Lists-->
            </div>
        </div>


        <section id="portfolio-details" class="portfolio-details">
            <div class="container">
                <div class="row gy-4">
                    <div class="col-lg-8">
                        @if ($blog_data != null)
                            <div class="portfolio-details-slider swiper-container">
                                <a>
                                    <img class="img-fulid">
                                </a>
                                <div class="hover-wrap">
                                </div>
                            </div>

                            <div class="post-content">
                                <h3>


                                </h3>
                                <div class="">


                                </div>
                                <p></p>

                                {{-- <p>{{ $blog_data->slug }}</p> --}}

                            </div>
                        @else
                            <div class="post-content">
                                {{ _i('Blog not translated yet') }}
                            </div>
                        @endif

                    </div>



                </div>

            </div>
        </section>

        <!-- Content section End -->
    @endif

@endsection

@push('js')
    <script>
        $(function() {
            $('#form_comment').submit(function(e) {
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
                        if (response == 'SUCCESS') {
                            new Noty({
                                type: 'success',
                                layout: 'topRight',
                                text: "{{ _i('The comment has been sent, awaiting approval') }}",
                                timeout: 2000,
                                killer: true
                            }).show();
                            $('#comment').val("");
                        }
                    }
                });
            });
        });

    </script>
@endpush
