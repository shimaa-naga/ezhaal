<?php


namespace App\Models\Blogs;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Blogs extends Model
{
    protected $table = 'blogs';
    protected $fillable = ['category_id','by_id','published','created'];
    public $timestamps = true;
    public function Data()
    {
        return $this->hasMany(BlogData::class,"blog_id","id");
    }
    public function Comments()
    {
        return $this->hasMany(BlogComment::class,"blog_id","id");
    }

    public function ByUser()
    {
        return $this->hasOne(User::class,"id","by_id");
    }


    public function Source()
    {
        return $this->Data()->whereNull("source_id")->first();
    }
}
