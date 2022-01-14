<?php


namespace App\Http\Controllers\Website;

use App\Help\Utility;
use App\Http\Controllers\Controller;
use App\Language;
use App\Models\Blogs\BlogCategory;
use App\Models\Blogs\BlogCategoryData;
use App\Models\Blogs\BlogComment;
use App\Models\Blogs\BlogData;
use App\Models\Blogs\Blogs;
use App\Models\Blogs\BlogUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class BlogController extends Controller
{
    public function blog($slug, $blogId)
    {

        $blog = Blogs::findOrFail($blogId);
        $blog_data = BlogData::where('blog_id', $blogId)->where('lang_id', Utility::websiteLang())->first();
        if ($blog_data == null)
            abort(404);
        $blog_comments = BlogComment::where('blog_id', $blogId)->where('published', 1)->get();
        $blog_urls = BlogUrl::where('blog_id', $blogId)->get();
        $category = BlogCategory::leftJoin('blog_category_data', 'blog_category_data.category_id', 'blog_categories.id')
            ->select('blog_categories.id', 'blog_category_data.title', 'blog_category_data.slug')
            ->where('blog_categories.id', $blog->category_id)
            ->where('blog_category_data.lang_id', Utility::websiteLang())
            ->first();
        $blog_cats = BlogCategory::leftJoin('blog_category_data', 'blog_category_data.category_id', 'blog_categories.id')
            ->select('blog_categories.id', 'blog_category_data.title')
            //->where('blog_categories.id', $blog->category_id)
            ->where('blog_category_data.lang_id', Utility::websiteLang())
            ->get();
        $related_blogs = Blogs::leftJoin('blogs_data', 'blogs_data.blog_id', 'blogs.id')
            ->select('blogs_data.title', 'blogs.id', 'blogs.created')
            ->where('blogs.category_id', $blog->category_id)
            ->where('blogs_data.lang_id', Utility::websiteLang())
            ->where('blogs.published', 1)
            ->where("blogs_data.blog_id", "!=", $blogId)
            ->get();

        if ($blog->published == 0) {
            $title = _i('Blog not Found');
        } else {
            $title = $blog_data->title ?? _i('Blog not translated yet');
        }
        return view('website.blog_management.single_blog', compact(
            'blog',
            'blog_data',
            'blog_comments',
            'blog_urls',
            'category',
            'blog_cats',
            'related_blogs',
            'title'
        ));
    }

    public function blogCategory($title, $catId)
    {
        $blog_cat = BlogCategory::leftJoin('blog_category_data', 'blog_category_data.category_id', 'blog_categories.id')
            ->select('blog_categories.id', 'blog_category_data.title', 'blog_category_data.slug', 'blog_category_data.meta_keyword', 'blog_category_data.meta_description', 'blog_category_data.img_description')
            ->where('blog_categories.id', $catId)
            ->where('blog_category_data.lang_id', Utility::websiteLang())
            ->first();
        $blogs = Blogs::leftJoin('blogs_data', 'blogs_data.blog_id', 'blogs.id')
            ->select('blogs_data.title','blogs_data.content', 'blogs_data.slug', 'blogs_data.img', 'blogs.id', 'blogs.created', 'blogs.by_id')
            ->where('blogs.category_id', $catId)
            ->where('blogs_data.lang_id', Utility::websiteLang())
            ->where('blogs.published', 1)
            ->paginate(6);
            $blog_cats = BlogCategory::leftJoin('blog_category_data', 'blog_category_data.category_id', 'blog_categories.id')
            ->select('blog_categories.id', 'blog_category_data.title', 'blog_category_data.slug', 'blog_category_data.img')
            ->where('blog_category_data.lang_id', Utility::websiteLang())
            ->get();

        if ($blog_cat == null) {
            $title = _i('Blog category not found');
        } else {
            $title = $blog_cat->title ?? _i('Blog category not translated yet');
        }
        if ($blog_cat==null)
            abort(404);
        return view('website.blog_management.blog_category', compact('blog_cat', 'blogs', 'title',"blog_cats"));
    }

    public function blog_cats()
    {
        $blog_cats = BlogCategory::leftJoin('blog_category_data', 'blog_category_data.category_id', 'blog_categories.id')
            ->select('blog_categories.id', 'blog_category_data.title', 'blog_category_data.slug', 'blog_category_data.img')
            ->where('blog_category_data.lang_id', Utility::websiteLang())
            ->get();
        return view('website.blog_management.blog_categories', compact('blog_cats'));
    }

    public function sendBlogCommnet($blogId, Request $request)
    {
        BlogComment::create([
            'blog_id' => $blogId,
            'user_id' => auth()->guard('web')->user()->id,
            'published' => 0,
            'comment' => $request->comment,
        ]);
        return response()->json("SUCCESS");
    }
}
