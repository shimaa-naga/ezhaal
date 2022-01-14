<?php

namespace App\Bll;

use App\Models\Projects\ProjCategories;
use App\Models\Projects\ProjCategoryData;

class ProjCategory
{
    public $created = null;
    public function create($request)
    {
        $projCategory = ProjCategories::create([
            'parent_id' => $request->parent_id,
            "published" => ($request->active != null) ? true : false,
            "scope" => ($request->input("scope") != null) ? "trusted" : "all",

        ]);
        $this->created = $projCategory;
        ProjCategoryData::create([
            'category_id' => $projCategory->id,
            'lang_id' => $request->lang_id,
            'title' => $request->title,
            "meta_keyword" => $request->meta_keyword,
            "meta_description" => $request->meta_description,
            "img_description" => $request->img_description,

        ]);

        if ($request->parent_id != null) {
            $parent = ProjCategories::find($request->parent_id);
            if ($parent != null)
                $this->addAttributes($parent);
        }
    }
    private function addAttributes($projCategory)
    {

        foreach ($projCategory->Attributes as $attr) {
            $new_attr = $attr->replicate();
            $new_attr->category_id = $projCategory->id;
            $new_attr->save();
            foreach ($attr->data as $data) {
                $new_data = $data->replicate();
                $new_data->item_id = $new_attr->id;
                $new_data->save();
            }
        }
        foreach ($projCategory->Attributes2 as $attr) {
            $new_attr = $attr->replicate();
            $new_attr->category_id = $projCategory->id;
            $new_attr->save();
            foreach ($attr->data as $data) {
                $new_data = $data->replicate();
                $new_data->item_id = $new_attr->id;
                $new_data->save();
            }
        }
    }
}
