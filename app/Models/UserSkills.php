<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class UserSkills extends Model
{
    protected $table = 'user_info';
    protected $fillable = ['user_id', 'category_id'];
    public $timestamps = true;
}
