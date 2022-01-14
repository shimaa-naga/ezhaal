<?php


namespace App\Models\Blogs;


use Illuminate\Database\Eloquent\Model;

class BlogUrl extends Model
{
    protected $table = 'blog_urls';
    protected $fillable = ['blog_id','url'];
    public $timestamps = true;
}
