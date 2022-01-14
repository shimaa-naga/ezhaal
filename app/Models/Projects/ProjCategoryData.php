<?php


namespace App\Models\Projects;


use Illuminate\Database\Eloquent\Model;

class ProjCategoryData extends Model
{
    protected $table = 'projcategory_data';
    protected $fillable = ['category_id', 'title', 'lang_id','source_id','meta_keyword','meta_description','img_description'];
    public $timestamps = true;
    public function Children()
    {
       $f=  $this->Parent()->first();
       return $f->children();
    }
    public function Parent()
    {
        return $this->belongsTo(ProjCategories::class,"category_id","id");
    }

}
