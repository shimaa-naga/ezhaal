<?php


namespace App\Http\Controllers\Master\Projects;

use App\Bll\ProjCategory;
use App\Help\Category;
use App\Help\Utility;
use App\Http\Controllers\Controller;
use App\Language;
use App\Models\Projects\ProjCategories;
use App\Models\Projects\ProjCategoryData;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use ProjcategoryAttributesData;

class ProjCategoryController extends Controller
{
    public function index()
    {
        $limit = 10;
        $query = ProjCategories::whereNull("parent_id");
        $languages = Language::get();
        $parents = $query->paginate($limit);
        if (request()->ajax()) {
            return view('master.projects.proj_category.ajax_index', compact('parents', 'languages'))->render();
        }

        return view('master.projects.proj_category.index', compact('parents', 'languages'));
    }

    protected function get_parent()
    {
       // dd(0);
        $parents = Utility::getParentCategories();
        return response()->json($parents);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' =>  array('required', 'max:255'),
            'img' => 'mimes:png',
        ]);
        if ($validator->fails()) {
            return response()->json(["errors" => $validator->errors()]);
        }

        $item = new ProjCategory();
        $item->create($request);

        if ($request->file("img") != null) {

            $destinationPath = Utility::PathCreate("uploads/category/");
            $filename =  $item->created->id . ".png";
            $request->file("img")->move(public_path($destinationPath), $filename);
        }

        return response()->json("SUCCESS");
    }

    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' =>  array('required', 'max:255'),
            'img' => 'mimes:jpg,jpeg,png',
        ]);
        if ($validator->fails()) {
            return response()->json(["errors" => $validator->errors()]);
        }

        $projCategory = ProjCategories::findOrFail($request->row_id);
        $projCategory->update([
            'parent_id' => $request->parent_id,
            "published" => ($request->active != null) ? 1 : 0,
            "scope" => ($request->input("scope") != null) ? "trusted" : "all"
        ]);
        Category::UpdateRecursive($projCategory, [
            "published" => ($request->active != null) ? 1 : 0,
            "scope" => ($request->input("scope") != null) ? "trusted" : "all"
        ]);
        $data = $projCategory->source();
        $data->title = $request->title;
        $data->meta_keyword = $request->meta_keyword;
        $data->meta_description = $request->meta_description;
        $data->img_description = $request->img_description;

        $data->save();

        if ($request->file("img") != null) {
            $destinationPath = Utility::PathCreate("uploads/category/");
            $filename =  $projCategory->id . ".png";
            $request->file("img")->move(public_path($destinationPath), $filename);
        }
        return response()->json("SUCCESS");
    }

    public function getLangValue(Request $request)
    {
       //  dd($request->all());
        $rowData =ProjCategoryData::where("lang_id", $request->lang_id)->where('category_id', $request->category_id)->first();
        //ProjCategoryData::where('category_id',$request->category_id)
        //  ->where('lang_id',$request->lang_id)
        //->first(['title']);
        if (!empty($rowData)) {
            return response()->json(['data' => $rowData]);
        } else {
            return response()->json(['data' => false]);
        }
    }

    public function storelangTranslation(Request $request)
    {
       // dd($request->all());
        $source = ProjCategoryData::where("lang_id", "!=",$request->lang_id_data)->where("category_id", $request->category_id)->first();
        //dd($source);
        $rowData = ProjCategoryData::where("lang_id", $request->lang_id_data)->where("category_id", $request->category_id)->first();
         //dd($source,$request->category_id);
        if ($rowData !== null) {
            $rowData->update([
                'title' => $request->title,
                'meta_keyword' => $request->meta_keyword,
                'meta_description' => $request->meta_description,
                'img_description' => $request->img_description,
                //'source_id' => $request->category_id
            ]);
        } else {
            $rowData = ProjCategoryData::create([
                'category_id' => $request->category_id,
                'title' => $request->title,
                'meta_keyword' => $request->meta_keyword,
                'meta_description' => $request->meta_description,
                'img_description' => $request->img_description,

                'lang_id' => $request->lang_id_data,
                'source_id' => $source->id
            ]);
        }
        return response()->json("SUCCESS");
    }

    public function delete($id)
    {
        ProjCategories::destroy($id);
        $destinationPath = public_path("uploads/category/" . $id . ".png");
        if (file_exists($destinationPath))
            unlink($destinationPath);
        return response(["data" => true]);
    }
}
