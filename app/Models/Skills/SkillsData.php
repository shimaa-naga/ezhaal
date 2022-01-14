<?php


namespace App\Models\Skills;


use Illuminate\Database\Eloquent\Model;

class SkillsData extends Model
{
    protected $table = 'skill_data';
    protected $fillable = ['skill_id','lang_id','title'];
    public $timestamps = true;
}
