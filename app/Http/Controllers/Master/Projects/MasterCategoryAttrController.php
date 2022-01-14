<?php

namespace App\Http\Controllers\Master\Projects;

use App\Http\Controllers\Controller;
use App\Models\Projects\ProjCategories;
use App\Models\Projects\ProjcategoryAttributes;
use App\Models\Projects\ProjcategoryAttributes2;
use App\Models\Projects\ProjCategoryAttributes2Data;
use App\Models\Projects\ProjCategoryAttributesData;
use Illuminate\Http\Request;
use Xinax\LaravelGettext\Facades\LaravelGettext;

class MasterCategoryAttrController extends Controller
{
    protected function m_index($category, Request $request, $ver2 = false)
    {
        $categoryEntity = ProjCategories::find($category);
        if ($categoryEntity == null)
            return view("master.notfound", ["msg" => _i("Not Found")]);

        if ($ver2 == true) {
            $find = ProjcategoryAttributes2::where("category_id", $category)->orderByRaw("CAST(sort as UNSIGNED) ASC");
        } else
            $find = ProjcategoryAttributes::where("category_id", $category)->orderByRaw("CAST(sort as UNSIGNED) ASC");
        if ($request->query("type") != null)
            $find = $find->where("module", "service");
        else
            $find = $find->where("module", "project");

        $find = $find->get();

        if (request()->ajax()) {
            return response()->json($find, 200);
        }

        if ($ver2 == true)
            return view("master.projects.projCategoryAttr.index", ["items" => $find, "category" => $categoryEntity->source()->title, "attr" => 2]);

        return view("master.projects.projCategoryAttr.index", ["items" => $find, "category" => $categoryEntity->source()->title, "attr" => ""]);
    }
    protected function m_store($category, $ver2 = false)
    {

        $items = request()->input("items");
        $model = new ProjcategoryAttributes();
        $model_data = new ProjCategoryAttributesData();
        if ($ver2) {
            $model = new ProjcategoryAttributes2();
            $model_data = new ProjCategoryAttributes2Data();
        }
        $attr = $model::where("category_id", $category)->orderBy("sort")->get();
        $sort = 1;
        if (count($attr) > 0)
            $sort = $attr->last()->sort + 1;

        $obj = $model::create([
            'type' => (request()->input("type")),
            'required' => (boolval(request()->boolean("required")) == true) ? "1" : "0",
            'show_public' => (boolval(request()->boolean("private")) == true) ? "0" : "1",
            'front' => (boolval(request()->boolean("front")) == true) ? "0" : "1",
            'module' => (request()->query("type") == null) ? "project" : "service",
            'category_id' => $category,
            'sort' => $sort,
            'module' => (request()->query("type") == null) ? "project" : "service",
            "icon" => (request()->input("icon") == null) ? "" : request()->input("icon")
        ]);

        $model_data::create([
            'title' => request()->input("title"),
            "item_id" => $obj->id,
            "lang_id" => request()->input("lang_id"),
            "placeholder" => (request()->input("placeholder") == null) ? "" : request()->input("placeholder"),

            'options' => ($items),

        ]);

        return response()->json(["status" => "ok", "id" => $obj->id]);
    }
    protected function m_up($category, $id, $ver2 = false)
    {
        $model = new ProjcategoryAttributes();
        if ($ver2)
            $model = new ProjcategoryAttributes2();
        $item = $model::find($id);
        $prev = $model::where("category_id", $category)->where("type", "!=", "pay")->orderby("sort", "desc")->where("sort", "<", $item->sort)->first();
        if ($prev != null) {
            $prev_sort = $item->sort;
            $item->sort = $prev->sort;
            $item->save();
            $prev->sort = $prev_sort;
            $prev->save();
        }
        return response()->json(["status" => "ok"]);
    }
    protected function update($category)
    {
        $val = request()->input("val");
        $val = (strtolower($val) == "true") ? true : false;

        $item = ProjcategoryAttributes::where("category_id", $category)->where("type", "pay")->first();
        if ($item == null && $val === true) {

            ProjcategoryAttributes::create([
                'type' => "pay",
                'title' => "--",
                'required' => 0,
                'sort' => 0,
                "category_id" => $category
            ]);
        } else if ($item != null && $val === false) {
            $item =  ProjcategoryAttributes::where("type", "pay")->first();
            ProjcategoryAttributes::destroy($item->id);
            //dd(0);
        }

        return response()->json(["status" => "ok"]);
    }
    protected function m_down($category, $id, $ver2 = false)
    {
        $model = new ProjcategoryAttributes();
        $type ="project";
        if ($ver2)
        {
            $model = new ProjcategoryAttributes2();
            $type ="service";
        }
        $item = $model::find($id);
        $next = $model::where("sort", ">", $item->sort)
            ->where("category_id", $category)->where("module",$type)->orderby("sort")->first();
        if ($next != null) {
            $prev_sort = $item->sort;
            $item->sort = $next->sort;
            $item->save();
            $next->sort = $prev_sort;
            $next->save();
        }
        return response()->json(["status" => "ok"]);
    }


    protected function m_save(Request $request, $ver2 = false)
    {
        //dd($request->all());
        $model = new ProjcategoryAttributes();
        $model_data = new ProjCategoryAttributesData();
        if ($ver2) {
            $model = new ProjcategoryAttributes2();
            $model_data = new ProjCategoryAttributes2Data();
        }
        if ($request->input("data_id") != null) {
            //update
            $find = $model_data::find($request->input("data_id"));
            if ($find == null) {
                $model_data::create([
                    "item_id" => $request->input("id"),
                    "title" => $request->input("edit_title"),
                    "options" => explode("\r\n", $request->input("edit_opt")),
                    'placeholder' => $request->input("edit_placeholder")?:"",
                    "lang_id" => $request->input("lang_id")
                ]);
            } else {
                $find->title = $request->input("edit_title");
                $find->placeholder = $request->input("edit_placeholder")?:"";

                $find->options = explode("\r\n", $request->input("edit_opt"));
                $find->save();
            }
        } else {
            //insert data
            $model_data::create([
                "item_id" => $request->input("id"),
                "title" => $request->input("edit_title"),
                "placeholder" => $request->input("edit_placeholder")?:"",
                "options" => explode("\r\n", $request->input("edit_opt")),
                "lang_id" => $request->input("lang_id")
            ]);
        }
        $find = $model::find($request->input("id"));
        $find->front = ($request->input("edit_front") != null) ? 1 : 0;
        $find->required = ($request->input("edit_required") != null) ? 1 : 0;
        $find->show_public = ($request->input("edit_private") == null) ? 1 : 0;
        $find->icon = $request->input("icon")?: "" ;

        $find->save();
        return back()->with("success", _i("Updated successfully"));
    }

    protected function m_show($id, $ver2 = false)
    {

        $find = ProjcategoryAttributes::find($id);

        if ($ver2 == true)
            $find = ProjcategoryAttributes2::find($id);


        $data = $find->data()->where("lang_id",request()->query("lang"))->first();

        return  response()->json(["item" => $find, "details" => $data]);
    }
}
