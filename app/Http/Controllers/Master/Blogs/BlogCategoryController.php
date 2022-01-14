<?php


namespace App\Http\Controllers\Master\Blogs;


use App\Help\Utility;
use App\Http\Controllers\Controller;
use App\Language;
use App\Models\Blogs\BlogCategory;
use App\Models\Blogs\BlogCategoryData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class BlogCategoryController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $query = BlogCategory::select('*')->orderByDesc('id');


            return DataTables::eloquent($query)
                ->addColumn('img', function ($query) {

                    if($query->Source()->img != null){
                        return "<img class='img-thumbnail'  src=".asset($query->Source()->img)." style='max-width:150px; max-hight:150px;'>";
                    }else{
                        return "<img class='img-thumbnail' src=".asset('custom/index.png')." style='max-width:150px; max-hight:150px;'>";
                    }
                })
                ->addColumn('category_title', function ($query)  {

                    return '<a href="#" class="btn btn-round btn-xs btn-default"> '.$query->Source()->title.'</a>' ;
                })
                ->editColumn('created_at', function ($query){
                    return $query->created_at = date('Y-m-d H:i:s', strtotime($query->created_at));
                })
                ->addColumn('options' ,function($query) {
                        $html = '
						<a href ="#" data-toggle="modal" data-target="#modal-edit" class="btn waves-effect waves-light btn-primary edit text-center" title="'._i("Edit").'"
						data-id="'.$query->id.'" data-cat_dataid="'.$query->Source()->id.'" data-image="'.$query->Source()->img.'" data-lang="'.$query->Source()->lang_id.'" data-title="'.$query->Source()->title.'"
						 data-slug="'.$query->Source()->slug.'" data-metakeyword="'.$query->Source()->meta_keyword.'" data-metadescription="'.$query->Source()->meta_description.'"
						  data-imgdescription="'.$query->Source()->img_description.'" ><i class="fa fa-edit"></i> </a>  ';

                    $html .= '&nbsp;
                    <form class="delete" action="'.route("master.blog_category.destroy",$query->id) .'"  method="POST" id="delform" style="display: inline-block; right: 50px;" >
                    		<input name="_method" type="hidden" value="DELETE">
                    		<input type="hidden" name="_token" value="' . csrf_token() . '">
                    		<button type="submit" class="btn btn-danger" title=" '._i('Delete').' "> <span> <i class="fa fa-trash-o"></i></span></button>
                     </form> &nbsp; ';

                    $langs = Language::where("id","!=",$query->Source()->lang_id)->get();
                    $options = '';
                    foreach ($langs as $lang) {
                        $options .= '<li ><a href="#" data-toggle="modal" data-target="#langedit" class="lang_ex" data-blogcategoryid="'.$query->id.'" data-lang="'.$lang->id.'" data-title="'.$lang->title.'"
                        style="display: block; padding: 5px 10px 10px;">'.$lang->title.'</a></li>';
                    }
                    $html = $html.'
                     <div class="btn-group">
                       <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown"  title=" '._i('Translation').' ">
                         <span class="fa fa-cogs"></span>
                       </button>
                       <ul class="dropdown-menu">
                         '.$options.'
                       </ul>
                     </div> ';

                    return $html;
                })
                ->rawColumns([
                    'options',
                    'img',
                    'category_title',
                ])
                ->make(true);
        }

        $languages = Language::get();
        return view('master.blog_management.blog_category.index' , compact('languages'));
    }

    public function store(Request $request)
    {
         $validator = Validator::make($request->all(), [
             'title' =>  array('required', 'max:255','unique:blog_category_data'),
         ]);
         if ($validator->fails()) {  return response()->json(["errors" => $validator->errors()]); }

        $blog_cat = BlogCategory::create([]);
        $blogCat_data = BlogCategoryData::create([
            'category_id' => $blog_cat->id,
            'lang_id' => $request->lang_id,
            'title' => $request->title,
            'slug' => $request->slug,
            'meta_keyword' => $request->meta_keyword,
            'meta_description' => $request->meta_description,
            'img_description' => $request->img_description,
            'source_id' => null,
        ]);
        if ($request->hasFile('img'))
        {
            $image = $request->file('img');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = ( '/uploads/blog_category/'. $blogCat_data->id);
            if(!file_exists(public_path($destinationPath)))
                mkdir(public_path($destinationPath));
            $request->img->move(public_path($destinationPath), $filename);
            $blogCat_data->img = $destinationPath .'/'. $filename;
            $blogCat_data->save();
        }
        return response()->json("SUCCESS");
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' =>  array('required', 'max:255',Rule::unique('blog_category_data')->ignore($request->blog_cat_data_id)),
        ]);
        if ($validator->fails()) {  return response()->json(["errors" => $validator->errors()]); }
        $blog_cat_data = BlogCategoryData::findOrFail($request->blog_cat_data_id);
        $blog_cat_data->update([
            'lang_id' => $request->lang_id,
            'title' => $request->title,
            'slug' => $request->slug,
            'meta_keyword' => $request->meta_keyword,
            'meta_description' => $request->meta_description,
            'img_description' => $request->img_description,
        ]);
        if ($request->hasFile('img'))
        {
            $image = $request->file('img');
            if (File::exists(public_path($blog_cat_data->img))) {
                File::delete(public_path($blog_cat_data->img));
            }
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = '/uploads/blog_category/'. $blog_cat_data->id;
            $request->img->move(public_path($destinationPath), $filename);
            $blog_cat_data->img = $destinationPath .'/'. $filename;
            $blog_cat_data->save();
        }
        return response()->json("SUCCESS");
    }

    public function getLangValue(Request $request)
    {
        //dd($request->all());
        $rowData = BlogCategoryData::where('category_id',$request->catId)
            ->where('lang_id',$request->lang_id)
            ->first(['title','img','slug','meta_keyword','meta_description','img_description']);
        if (!empty($rowData))
        {
            return response()->json(['data' => $rowData]);
        }else {
            return response()->json(['data' => false]);
        }
    }

    public function storelangTranslation(Request $request)
    {
        //dd($request->all());
        $rowData = BlogCategoryData::where('category_id',$request->blog_cat_id)
            //->where('lang_id', $request->lang_id_data)
            ->where('source_id',"!=" , null)
            ->first();
        if ($rowData !== null)
        {
            $rowData->update([
                'title' => $request->title,
                'slug' => $request->slug,
                'meta_keyword' => $request->meta_keyword,
                'meta_description' => $request->meta_description,
                'img_description' => $request->img_description,
                'lang_id' => $request->lang_id_data,
            ]);
        }else {
            $parentRow = BlogCategoryData::where('category_id',$request->blog_cat_id)->where('source_id' , null)->first();
            $rowData = BlogCategoryData::create([
                'category_id' => $request->blog_cat_id,
                'title' => $request->title,
                'slug' => $request->slug,
                'meta_keyword' => $request->meta_keyword,
                'meta_description' => $request->meta_description,
                'img_description' => $request->img_description,
                'lang_id' => $request->lang_id_data,
                'source_id' => $parentRow->id,
            ]);
        }
        if ($request->hasFile('img'))
        {
            $image = $request->file('img');
            if (File::exists(public_path($rowData->img))) {
                File::delete(public_path($rowData->img));
            }
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = '/uploads/blog_category/'. $rowData->id;
            $request->img->move(public_path($destinationPath), $filename);
            $rowData->img = $destinationPath .'/'. $filename;
            $rowData->save();
        }
        return response()->json("SUCCESS");
    }

    public function delete($id)
    {
        //dd($id);
        $blog_category = BlogCategory::findOrFail($id);
        $blog_cat_data = BlogCategoryData::where('category_id', $id);
        foreach ($blog_cat_data->get() as $cat_data){
            if (File::exists(public_path($cat_data->img)))
            {
                File::delete(public_path($cat_data->img)); // delete file
                File::deleteDirectory(public_path('uploads/blog_category/').$cat_data->id); // delete folder else
            }
        }
        $blog_cat_data->delete();
        $blog_category->delete();
        return response(["data" => true]);
    }
}
