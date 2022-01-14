<?php


namespace App\Models\Projects;


use Illuminate\Database\Eloquent\Model;

class ProjCategoryAttributesData extends Model
{
    protected $table = 'projcategory_attributes_data';
    protected $fillable = ['title', 'options', 'item_id', 'lang_id','placeholder'];
    public $timestamps = false;
    protected $casts = [
        'options' => 'array',
    ];
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
