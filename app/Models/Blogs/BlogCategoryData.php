<?php


namespace App\Models\Blogs;


use Illuminate\Database\Eloquent\Model;

class BlogCategoryData extends Model
{
    protected $table = 'blog_category_data';
    protected $fillable = [
        'category_id', 'lang_id', 'title', 'img', 'slug', 'meta_keyword', 'meta_description', 'img_description',
        'source_id'
    ];
    public $timestamps = true;
    // public function getSlugAttribute()
    // {
    //     if ($this->slug == null)
    //         return $this->title;
    // }
}
