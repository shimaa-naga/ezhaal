<?php


namespace App\Models\Projects;

use App\Help\Utility;
use App\Language;
use Illuminate\Database\Eloquent\Model;
// 1. To specify package’s class you are using
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Support\Facades\DB;

class ProjcategoryAttributes extends Model
{
    // use Translatable; // 2. To add translation methods
    // public $translatedAttributes = ['title', 'options'];

    protected $table = 'projcategory_attributes';
    protected $fillable = ['type', 'required','show_public', 'category_id', 'sort','front','module','icon'];
    public $timestamps = true;

    public function trans($code)
    {
        $find = $this->data()->where("lang_id",function($q)use ($code){
            return $q->from("languages")->where("code",$code)->select("id");
        })->first();
        if($find==null)
            $find= $this->data()->first();

       return $find     ;
    }
    public function data()
    {
        return $this->hasMany(ProjCategoryAttributesData::class, "item_id", "id");
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
