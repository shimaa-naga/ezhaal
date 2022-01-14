<?php


namespace App\Models\Blogs;


use Illuminate\Database\Eloquent\Model;

class BlogComment extends Model
{
    protected $table = 'blog_comments';
    protected $fillable = ['blog_id','user_id','comment','published'];
    public $timestamps = true;
}
