<?php


namespace App\Models\Projects;


use Illuminate\Database\Eloquent\Model;

class ProjectAttachments extends Model
{
    protected $table = 'project_attachments';
    protected $fillable = ['project_id', 'file', 'file_type', 'created'];
    public $timestamps = true;
}
