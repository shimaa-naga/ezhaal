<?php


namespace App\Models\Projects;


use Illuminate\Database\Eloquent\Model;

class ProjectRate extends Model
{
    protected $table = 'project_rate';
    protected $fillable = ['project_id', 'stars', 'comment'];
    public $timestamps = true;
}
