<?php


namespace App\Models\Blogs;


use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    protected $table = 'blog_categories';
    public $timestamps = true;
    public function Data()
    {
        return $this->hasMany(BlogCategoryData::class,"category_id","id");
    }
    public function Source()
    {
        return $this->Data()->whereNull("source_id")->first();
    }
}
