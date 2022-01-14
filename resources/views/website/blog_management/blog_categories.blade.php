@extends('website.layout.index', ['title' => _i('Blog Categories'),'header_title' => _i('Blog Categories')])

@section('content')

    <!-- Content section Start -->
    <div class="container">
    <div class="row">

        @foreach ($blog_cats as $category)

        <div class="col-lg-3 col-md-6 col-xs-12">
            <div class="card">
                <div class="item-card">
                    <div class="item-card-desc">
@php
    $url = route('website.blogCat', ["cat_id" =>$category->id,
                            "title"=>($category->slug==null)? $category->title:$category->slug ]);
@endphp
                        <a href="{{$url}}"></a>
                        <div class="item-card-img">
                            <img src="@if ($category->img != null &&
                            file_exists(public_path($category->img))) {{ asset($category->img) }}@else{{ asset('uploads/no-image.jpg') }} @endif" alt="img" class="br-tr-7 br-tl-7">
                        </div>
                        <div class="item-card-text">
                            <h4 class="mb-0"> {{ $category->title }}</h4>
                        </div>
                    </div>
                    <div class="item-card-btn">
                        <a href="{{$url}}" class="btn btn-secondary">{{_i("View More")}}</a>
                    </div>
                </div>
            </div>
        </div>

        @endforeach

    </div>
    </div>
    <!-- Content section End -->
@endsection
