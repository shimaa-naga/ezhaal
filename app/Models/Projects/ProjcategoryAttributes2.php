<?php


namespace App\Models\Projects;

use App\Help\Utility;
use Illuminate\Database\Eloquent\Model;


class ProjcategoryAttributes2 extends Model
{
    protected $table = 'projcategory_attributes2';
    protected $fillable = ['type', 'required','show_public', 'category_id', 'sort','front','module','icon'];
    public $timestamps = true;


    public function data()
    {
        return $this->hasMany(ProjCategoryAttributes2Data::class, "item_id", "id");
    }
    public function trans($code)
    {
        return $this->data()->where("lang_id",function($q)use ($code){
            return $q->from("languages")->where("code",$code)->select("id");
        })->first();
    }

    // public function getTitleAttribute()
    // {
    //     $find = $this->data()->first();
    //     if ($find == null)
    //         return "";
    //     return $find->title;
    // }
    // public function getOptionsAttribute()
    // {
    //     $find = $this->data()->first();
    //     if ($find == null)
    //         return "";
    //     return $find->options;
    // }
}
