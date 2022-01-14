<?php


namespace App\Models\Projects;


use Illuminate\Database\Eloquent\Model;

class ProjectAttributes extends Model
{
    protected $table = 'project_attributes';
    protected $fillable = ['project_id', 'attribute_id', 'value'];
    public $timestamps = true;
}
