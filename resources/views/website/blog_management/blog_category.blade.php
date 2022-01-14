@extends('website.layout.index', ['title' => $title,"header_title"=>["<a
    href='".url("blogs/categories")."'>"._i("Categories")."</a>",$title],"meta_keywords" => $blog_cat->meta_keyword ,
"meta_description" => $blog_cat->meta_description ])

@section('content')

    <!-- Content section Start -->



    <!--Add listing-->

    <div class="container">
        <div class="row">
            <!--Left Side Content-->
            <div class="col-xl-4 col-lg-4 col-md-12">

                @include("website.blog_management.partial.categories")


            </div>
            <!--/Left Side Content-->

            <div class="col-xl-8 col-lg-8 col-md-12">
                <!--Add Lists-->
                @if (count($blogs) > 0)
                    <div class="row">

                        @foreach ($blogs as $blog)
                            <div class="col-xl-12 col-lg-12 col-md-12">
                                <div class="card overflow-hidden">

                                    <div class="row no-gutters blog-list ">
                                        <div class="col-xl-4 col-lg-12 col-md-12">
                                            <div class="item7-card-img">
                                                <a href="{{ route('website.blog', [$blog->slug, $blog->id]) }}"></a>
                                                <img src="@if ($blog->img != null &&
                                                file_exists(public_path($blog->img))) {{ asset($blog->img) }}@else{{ asset('uploads/no-image.jpg') }} @endif" alt="{{ $blog_cat->img_description }}"
                                                title="{{ $blog_cat->meta_description }}" class="cover-image">

                                            </div>
                                        </div>
                                        <div class="col-xl-8 col-lg-12 col-md-12">
                                            <div class="card-body">
                                                <div class="item7-card-desc d-flex mb-1">
                                                    <a href="{{ route('website.blog', [$blog->slug, $blog->id]) }}"><i
                                                            class="fa fa-calendar-o text-muted mr-2"></i>{{ date('d M Y', strtotime($blog->created)) }}</a>
                                                    <a href="{{ route('website.blog', [$blog->slug, $blog->id]) }}"><i
                                                            class="fa fa-user text-muted mr-2"></i>
                                                        @php
                                                            $user = \App\User::where('id', $blog->by_id)->first();
                                                        @endphp
                                                        @if ($user != null)
                                                            <span><i class="fa fa-user"></i>
                                                                {{ $user->name . ' ' . $user->last_name }}</span>
                                                        @endif
                                                    </a>
                                                    <div class="m{{\App\Help\Utility::getLangCode() == 'ar' ? 'r' : 'l'}}-auto">
                                                        <a href="{{ route('website.blog', [$blog->slug, $blog->id]) }}"><i
                                                                class="fa fa-comment-o text-muted mr-2"></i>
                                                            @php
                                                                $blog_comments = \App\Models\Blogs\BlogComment::where('blog_id', $blog->id)
                                                                    ->where('published', 1)
                                                                    ->count();
                                                            @endphp
                                                            {{ $blog_comments }}
                                                            {{ _i('Comments') }}</a>
                                                    </div>
                                                </div>
                                                <a href="{{ route('website.blog', [$blog->slug, $blog->id]) }}"
                                                    class="text-dark">
                                                    <h4 class="font-weight-semibold mb-4"> {{ $blog->title }}</h4>
                                                </a>
                                                <p class="mb-1">

                                                    {{ Illuminate\Support\Str::words(strip_tags($blog->content), 30, '..') }}
                                                </p>
                                                <a href="{{ route('website.blog', [$blog->slug, $blog->id]) }}"
                                                    class="btn btn-primary btn-sm mt-4">{{ _i('Read More') }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>



                        @endforeach





                    </div>
                    <div class="center-block text-center">
                        {{ $blogs->appends(['search' => request()->search])->render() }}

                        {{-- <ul class="pagination mb-0">
                        <li class="page-item page-prev disabled">
                            <a class="page-link" href="#" tabindex="-1">Prev</a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item page-next">
                            <a class="page-link" href="#">Next</a>
                        </li>
                    </ul> --}}
                    </div>
                @else
                    <div class="col-xl-12 col-lg-12 col-md-12">
                        <div class="card overflow-hidden">
                            <div class="card-body ">

                                <p>{{ _i('No blogs found') }}</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <!--/Add Lists-->
        </div>
    </div>

    <!--/Add Listing-->

@endsection
