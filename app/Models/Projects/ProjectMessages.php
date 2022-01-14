<?php


namespace App\Models\Projects;


use Illuminate\Database\Eloquent\Model;

class ProjectMessages extends Model
{
    protected $table = 'project_messages';
    protected $fillable = ['project_id', 'user_id', 'created', 'message'];
    public $timestamps = true;
}
