<?php


namespace App\Models\Projects;


use Illuminate\Database\Eloquent\Model;

class ProjectCategory extends Model
{
    protected $table = 'project_category';
    protected $fillable = ['project_id', 'category_id'];
    public $timestamps = true;
}
