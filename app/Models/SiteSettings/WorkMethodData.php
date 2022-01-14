<?php


namespace App\Models\SiteSettings;


use Illuminate\Database\Eloquent\Model;

class WorkMethodData extends Model
{
    protected $table = 'work_method_data';
    protected $fillable = ['lang_id','work_method_id','source_id','title','description'];
    public $timestamps = true;
}
