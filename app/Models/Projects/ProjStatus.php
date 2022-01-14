<?php


namespace App\Models\Projects;


use Illuminate\Database\Eloquent\Model;

class ProjStatus extends Model
{
    protected $table = 'proj_status';
    protected $fillable = ['title'];
    public $timestamps = true;
}
