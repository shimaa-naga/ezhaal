<?php


namespace App\Models\Projects;


use Illuminate\Database\Eloquent\Model;

class ProjCategoryAttributes2Data extends Model
{
    protected $table = 'projcategory_attributes2_data';
    protected $fillable = ['title', 'options', 'item_id', 'lang_id','placeholder'];
    public $timestamps = false;
    protected $casts = [
        'options' => 'array',
    ];
}
