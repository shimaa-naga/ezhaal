<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ _i('Categories') }}</h3>
    </div>
    <div class="card-body p-0">
        <div class="list-catergory">
            <div class="item-list">

                <ul class="list-group mb-0">

                    @foreach ($blog_cats as $blog_cat)
                    @php
                    $blog_count = \App\Models\Blogs\Blogs::leftJoin('blogs_data', 'blogs_data.blog_id', 'blogs.id')
                        ->where('blogs.category_id', $blog_cat->id)
                        ->where('lang_id', \App\Help\Utility::websiteLang())
                        ->count();
                @endphp
                    <li class="list-group-item">
                        <a href="{{ route('website.blogCat', [($blog_cat->slug==null)?$blog_cat->title:$blog_cat->slug,$blog_cat->id]) }}" class="text-dark">
                            <i class="fa fa-building bg-primary text-primary"></i> {{ $blog_cat->title }}
                            <span class="badgetext badge badge-pill badge-secondary mb-0">{{ $blog_count }}</span>
                        </a>
                    </li>

                @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
