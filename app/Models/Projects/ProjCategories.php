<?php


namespace App\Models\Projects;

use App\Help\Utility;
use Illuminate\Database\Eloquent\Model;

class ProjCategories extends Model
{
    protected $table = 'projcategories';
    protected $fillable = ['parent_id', "scope", "type", "published"];
    public $timestamps = true;

    public function Data()
    {
        return $this->hasMany(ProjCategoryData::class, "category_id", "id");
    }
    public function Attributes()
    {
        return $this->hasMany(ProjcategoryAttributes::class, "category_id", "id");
    }
    public function Projects()
    {
        return $this->belongsToMany(Projects::class, "project_category", "category_id", "project_id");
    }
    public function Attributes2()
    {
        return $this->hasMany(ProjcategoryAttributes2::class, "category_id", "id");
    }

    public function trans($code)
    {
        $data = $this->Data()->where("lang_id", function($q) use($code){
            return $q->select("id")->from("languages")->where("code",$code)->first();
        })->first();
        if ($data == null)
            $data = $this->Data()->first();
        return $data;

    }
    public function DataWithLang()
    {

        $data = $this->Data()->where("lang_id", Utility::websiteLang())->first();
        if ($data == null)
            $data = $this->Data()->first();
        return $data;
    }
    public function Source()
    {
        return $this->Data()->whereNull("source_id")->first();
    }
    public function children()
    {

        return $this->where("parent_id", $this->id)->get();
    }
    public function getImgAttribute()
    {
        $destinationPath = public_path("uploads/category/" . $this->id . ".png");
        if (file_exists($destinationPath))
            return asset("uploads/category/" . $this->id . ".png");
        return asset("uploads/category/cat.png");
    }
    public function parent()
    {

        return $this->hasOne(ProjCategories::class, "id", "parent_id")->first();
    }
}
