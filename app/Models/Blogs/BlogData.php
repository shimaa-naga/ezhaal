<?php


namespace App\Models\Blogs;


use Illuminate\Database\Eloquent\Model;

class BlogData extends Model
{
    protected $table = 'blogs_data';
    protected $fillable = [
        'blog_id', 'lang_id', 'title', 'slug', 'img', 'content', 'meta_keyword', 'meta_description', 'img_description',
        'source_id'
    ];
    public $timestamps = true;
    public function Blog()
    {
        return $this->belongsTo(Blogs::class, "blog_id", "id");
    }
    public function getCategoryIdAttribute()
    {

        $f =   $this->Blog()->first();

        if ($f != null)
            return $f->category_id;

    }
    public function getPublishedAttribute()
    {

        $f =   $this->Blog()->first();

        if ($f != null)
            return $f->published;

    }
    public function getCreatedAttribute()
    {

        $f =   $this->Blog()->first();

        if ($f != null)
            return $f->created;

    }
}
