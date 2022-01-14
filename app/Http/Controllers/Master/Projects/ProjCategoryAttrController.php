<?php

namespace App\Http\Controllers\Master\Projects;

use App\Models\Projects\ProjcategoryAttributes;
use Illuminate\Http\Request;


class ProjCategoryAttrController extends MasterCategoryAttrController
{
    public function index($category, Request $request)
    {
        return $this->m_index($category, $request);
    }
    protected function store($category)
    {
        return $this->m_store($category);
    }
    protected function up($category, $id)
    {
        return $this->m_up($category, $id);
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
    protected function down($category, $id)
    {
        return $this->m_down($category, $id);
    }

    protected function destroy($category, $id)
    {
        //dd($id);
        ProjcategoryAttributes::destroy($id);
        return response(["data" => true]);
    }
    protected function save(Request $request)
    {
        return $this->m_save($request);
    }

    protected function show($category, $id)
    {
        return $this->m_show($id);
    }
}
