<?php


namespace App\Http\Controllers\Master\Blogs;


use App\Help\Utility;
use App\Http\Controllers\Controller;
use App\Language;
use App\MasterUsers;
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
use Yajra\DataTables\Facades\DataTables;

class BlogController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            //            $query = Blogs::rightJoin('blogs_data','blogs_data.blog_id','blogs.id')
            //                ->select('blogs_data.*' ,'blogs.id as blogId', 'blogs.by_id','blogs.published')
            //                 ->where('blogs_data.lang_id', Utility::getLang());
            $query = Blogs::select('blogs.id', 'blogs.category_id', 'blogs.by_id', 'blogs.published', 'blogs.created', DB::raw("blogs.id as blogId"))
                ->orderByDesc('blogs.id');;

            return DataTables::eloquent($query)
                ->addColumn('blog_title', function ($query) {
                    $query_data = $query->Source();
                    return $query_data != null ? $query_data->title : '<a href="#" class="btn btn-round btn-xs btn-default"> ' . _i('Blog not translated yet') . '</a>';
                })
                ->addColumn('comments', function ($query) {
                    $comments = $query->Comments()->get();
                    return '<a href="#" class="btn btn-round btn-xs btn-info"> ' . $comments->count() . '</a>';
                })
                ->addColumn('by_id', function ($query) {
                    $user = $query->ByUser()->first(); //MasterUsers::where('id', $query->by_id)->first();
                    return $user->name . " " . $user->last_name;
                })
                ->editColumn('published', function ($query) {
                    if ($query->published == 0) {
                        return '<span  class="btn btn-round btn-xs btn-default"> ' . _i('Not Published') . '</span>';
                    } else {
                        return '<span class="btn btn-round btn-xs btn-success"> ' . _i('Published') . '</span>';
                    }
                })
                ->addColumn('categoryId', function ($query) {
                    $category_data = BlogCategoryData::where('blog_category_data.category_id', $query->category_id)
                        ->where('lang_id', Utility::getLang())->first();
                    if ($category_data != null) {
                        return $category_data->title;
                    } else {
                        return  _i('Category selected not translated yet');
                    }
                })
                ->addColumn('options', function ($query) {
                    $query_data = $query->Source();
                    $html = '
						<a href ="blogs/'.$query_data->id .'/edit" class="btn waves-effect waves-light btn-primary edit text-center" title="' . _i("Edit") . '" >
							<i class="fa fa-edit"></i>
						</a>  &nbsp;' . '
						<a href="#" data-toggle="modal" data-target="#modal-url" class="btn btn-success modalurls" title="' . _i('Blog Urls') . '"
						data-blogid="' . $query_data->blog_id . '" ><i class="fa fa-link"></i></a> &nbsp;' . '
						<a href="' . route("master.blogs.comments", $query->id) . '" class="btn btn-info" title="' . _i('Blog Comments') . '"><i class="fa fa-comment"></i></a> &nbsp;' . '
                    	<form class="delete" action="' . route("master.blogs.destroy", $query->id) . '"  method="POST" id="delform" style="display: inline-block; right: 50px;" >
                    		<input name="_method" type="hidden" value="DELETE">
                    		<input type="hidden" name="_token" value="' . csrf_token() . '">
                    		<button type="submit" class="btn btn-danger" title=" ' . _i('Delete') . ' "> <span> <i class="fa fa-trash-o"></i></span></button>
                     	</form>';
                    $html .= '</div> &nbsp';

                    //$langs = Language::get();
                    $langs = Language::where("id", "!=", $query->Source()->lang_id)->get();
                    $options = '';
                    foreach ($langs as $lang) {
                        $options .= '<li ><a href="#" data-toggle="modal" data-target="#langedit" class="lang_ex" data-blogid="' . $query_data->blog_id . '"  data-lang="' . $lang->id . '" data-title="' . $lang->title . '"
                        style="display: block; padding: 5px 10px 10px;">' . $lang->title . '</a></li>';
                    }
                    $html = $html . '
                     <div class="btn-group">
                       <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown"  title=" ' . _i('Translation') . ' ">
                         <span class="fa fa-cogs"></span>
                       </button>
                       <ul class="dropdown-menu">
                         ' . $options . '
                       </ul>
                     </div> ';

                    return $html;
                })
                ->rawColumns([
                    'blog_title',
                    'options',
                    'comments',
                    'by_id',
                    'published',
                    'categoryId',
                ])
                ->make(true);
        }

        $languages = Language::get();
        $categories_data = BlogCategoryData::where('lang_id', Utility::getLang())->get();
        return view('master.blog_management.blogs.index', compact('languages', 'categories_data'));
    }
    protected function create()
    {
        $categories_data = BlogCategoryData::where('lang_id', Utility::getLang())->get();
        $languages = Language::get();
        return view("master.blog_management.blogs.create",compact("categories_data","languages"));
    }
    protected function edit($id)
    {
        $data = BlogData::findOrFail($id);
        $languages = Language::get();
        $categories_data = BlogCategoryData::where('lang_id', Utility::getLang())->get();
        return view("master.blog_management.blogs.edit",compact("data","languages","categories_data"));
    }
    public function store(Request $request)
    {
        //dd($request->all());
        //dd(auth()->id(),auth()->guard('master')->user()->id);
        $blog = Blogs::create([
            'category_id' => $request->category_id,
            'created' => $request->created ?? date('Y-m-d'),
            'published' => $request->published ? 1 : 0,
            'by_id' => auth()->id(),
        ]);
        $blog_data = BlogData::create([
            'blog_id' => $blog->id,
            'title' => $request->title,
            'slug' => $request->slug,
            'meta_keyword' => $request->meta_keyword,
            'meta_description' => $request->meta_description,
            'img_description' => $request->img_description,
            'lang_id' => $request->lang_id,
            'content' => $request->content_blog,
            'source_id' => null,
        ]);
        if ($request->hasFile('img')) {
            $image = $request->file('img');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = '/uploads/blogs/' . $blog_data->id;
            $request->img->move(public_path($destinationPath), $filename);
            $blog_data->img = $destinationPath . '/' . $filename;
            $blog_data->save();
        }
        return redirect("master/blogs")->with("success",_i("Saved"));
    }

    public function update(Request $request,$id)
    {
      //  dd($request->all(),$id);
        // $blog = Blogs::findOrFail($request->blog_id);
        // $blog->update([
        //     'category_id' => $request->category_id,
        //     'created' => $request->created ?? date('Y-m-d'),
        //     'published' => $request->published ? 1 : 0,
        // ]);
        $blog_data = BlogData::findOrFail($id);
        $blog =$blog_data->Blog()->first();
        $blog->update([
                'category_id' => $request->category_id,
                'created' => $request->created ?? date('Y-m-d'),
                'published' => ($request->published!=null) ? 1 : 0,
            ]);
        $blog_data->update([
            'title' => $request->title,
            'slug' => $request->slug,
            'meta_keyword' => $request->meta_keyword,
            'meta_description' => $request->meta_description,
            'img_description' => $request->img_description,
            'content' => $request->content_blog,
        ]);
        if ($request->hasFile('img')) {
            $image = $request->file('img');
            if (File::exists(public_path($blog_data->img))) {
                File::delete(public_path($blog_data->img));
            }
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = '/uploads/blogs/' . $blog_data->id;
            $request->img->move(public_path($destinationPath), $filename);
            $blog_data->img = $destinationPath . '/' . $filename;
            $blog_data->save();
        }
        return back()->with("success",_i("Saved"));
    }

    public function destroy($id)
    {
        $blog = Blogs::findOrFail($id);
        $blogs_data = BlogData::where('blog_id', $id);
        foreach ($blogs_data->get() as $blog_data) {
            if (File::exists(public_path($blog_data->img))) {
                File::delete(public_path($blog_data->img)); // delete file
                File::deleteDirectory(public_path('uploads/blogs/') . $blog_data->id); // delete folder else
            }
        }
        $blogs_data->delete();
        $blog->delete();
        return response(["data" => true]);
    }

    public function getLangValue(Request $request)
    {
        // dd($request->all());
        $rowData = BlogData::where('blog_id', $request->blogId)
            // ->where('lang_id',$request->lang_id)
            ->whereNotNull('source_id')
            ->first(['title', 'slug', 'img', 'content', 'meta_keyword', 'meta_description', 'img_description']);
        //dd($rowData);
        if (!empty($rowData)) {
            return response()->json(['data' => $rowData]);
        } else {
            return response()->json(['data' => false]);
        }
    }

    public function storelangTranslation(Request $request)
    {
        //dd($request->all());
        $rowData = BlogData::where('blog_id', $request->blog_id)
            // ->where('lang_id', $request->lang_id_data)
            ->whereNotNull('source_id')
            ->first();
        if ($rowData !== null) {
            $rowData->update([
                'title' => $request->title,
                'slug' => $request->slug,
                'meta_keyword' => $request->meta_keyword,
                'meta_description' => $request->meta_description,
                'img_description' => $request->img_description,
                'content' => $request->content_blog,
            ]);
        } else {
            $parentRow = BlogData::where('blog_id', $request->blog_id)->where('source_id', null)->first();
            $rowData = BlogData::create([
                'blog_id' => $request->blog_id,
                'title' => $request->title,
                'slug' => $request->slug,
                'meta_keyword' => $request->meta_keyword,
                'meta_description' => $request->meta_description,
                'img_description' => $request->img_description,
                'lang_id' => $request->lang_id_data,
                'content' => $request->content_blog,
                'source_id' => $parentRow->id,
            ]);
        }

        if ($request->hasFile('img')) {
            $image = $request->file('img');
            if (File::exists(public_path($rowData->img))) {
                File::delete(public_path($rowData->img));
            }
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = '/uploads/blogs/' . $rowData->id;
            $request->img->move(public_path($destinationPath), $filename);
            $rowData->img = $destinationPath . '/' . $filename;
            $rowData->save();
        }
        return response()->json("SUCCESS");
    }

    public function blogUrls(Request $request,$id)
    {
        $blog_urls = BlogUrl::where('blog_id', $id)->orderBy('id', 'ASC')->pluck('url', 'id');
        return $blog_urls;
    }

    public function blogUrlsStore(Request $request)
    {
        $delete_old_urls = BlogUrl::where('blog_id', $request->blog_id)->delete();
        if ($request->blog_urls != null) {
            foreach ($request->blog_urls as $url) {
                BlogUrl::create([
                    'blog_id' => $request->blog_id,
                    'url' => $url,
                ]);
            }
        }
        return response()->json("SUCCESS");
    }

    public function blogComments($id)
    {
        $blog_data = BlogData::where('blog_id', $id)->where('lang_id', Utility::getLang())->first();
        $comments = BlogComment::where('blog_id', $id)->orderByDesc('id')->get();
        return view('master.blog_management.blogs.blog_comments', compact('blog_data', 'comments'));
    }

    public function blogCommentApproval($comment_id)
    {
        $comment = BlogComment::where('id', $comment_id)->first();
        $comment->update([
            'published' => !$comment->published
        ]);
        return response()->json($comment);
    }

    public function blogCommentDestroy($comment_id)
    {
        $comment = BlogComment::destroy($comment_id);
        return response()->json("SUCCESS");
    }
}
