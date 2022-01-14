<?php


namespace App\Models\Skills;


use Illuminate\Database\Eloquent\Model;

class UsersSkills extends Model
{
    protected $table = 'users_skills';
    protected $fillable = ['skill_id','user_id'];
    public $timestamps = true;
}
