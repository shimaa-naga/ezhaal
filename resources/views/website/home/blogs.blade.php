<!--Blogs-->

@if(count($blogs)>0)
<section class="sptb" id="last_blogs">
    <div class="container">
        <div class="section-title center-block text-center">
            <h1>{{ _i('Latest Blogs') }}</h1>
            <p>{{_i('Show the latest blogs for the site')}}</p>
        </div>
        <div id="defaultCarouselb" class="owl-carousel Card-owlcarousel owl-carousel-icons">


                @foreach ($blogs as $blog)
                    <div class="item">
                        <div class="card mb-0">
                            <div class="item7-card-img">
                                <a
                                    href="{{ route('website.blog', [$blog->slug == null ? $blog->title : $blog->slug, $blog->blog_id]) }}"></a>
                                <img src="@if ($blog->img != null &&
                                file_exists(public_path($blog->img))) {{ asset($blog->img) }}@else{{ asset('uploads/no-image.jpg') }} @endif" alt="img" class="cover-image">
                            </div>
                            <div class="card-body p-4">
                                <div class="item7-card-desc d-flex mb-2">
                                    <a href="#"><i class="fa fa-calendar-o text-muted mr-2"></i>
                                        {{ date('d M, Y', strtotime($blog->created_at)) }}</a>
                                    <div class="m{{\App\Help\Utility::getLangCode() == 'ar' ? 'r' : 'l'}}-auto">
                                        <a href="#"><i
                                                class="fa fa-comment-o text-muted mr-2"></i>{{ $blog->Comments->count() }}
                                            {{ _i('Comments') }}</a>
                                    </div>
                                </div>
                                <a href="{{ route('website.blog', [$blog->slug == null ? $blog->title : $blog->slug, $blog->blog_id]) }}"
                                    class="text-dark">
                                    <h4 class="fs-20"> {{ $blog->title }}</h4>
                                </a>
                                <p>{{ Illuminate\Support\Str::words(strip_tags($blog->img_description), 30, '..') }}
                                </p>
                                <div class="d-flex align-items-center pt-2 mt-auto">
                                    <img src="../assets/images/faces/male/5.jpg" class="avatar brround avatar-md mr-3"
                                        alt="avatar-img">
                                    <div>
                                        <a href="{{ route('website.blog', [$blog->slug == null ? $blog->title : $blog->slug, $blog->blog_id]) }}"
                                            class="text-default">
                                            @php

                                                $user = \App\User::where('id', $blog->by_id)->first();

                                            @endphp
                                            @if ($user != null)
                                                {{ $user->name . ' ' . $user->last_name }}
                                            @endif
                                        </a>
                                        <small class="d-block text-muted">1 day ago</small>
                                    </div>
                                    <div class="m{{\App\Help\Utility::getLangCode() == 'ar' ? 'r' : 'l'}}-auto text-muted">
                                        <a href="javascript:void(0)" class="icon d-none d-md-inline-block m{{\App\Help\Utility::getLangCode() == 'ar' ? 'r' : 'l'}}-3"><i
                                                class="fe fe-heart mr-1"></i></a>
                                        <a href="javascript:void(0)" class="icon d-none d-md-inline-block m{{\App\Help\Utility::getLangCode() == 'ar' ? 'r' : 'l'}}-3"><i
                                                class="fa fa-thumbs-o-up"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach


        </div>
    </div>
</section>
<!--Blogs-->
@endif
