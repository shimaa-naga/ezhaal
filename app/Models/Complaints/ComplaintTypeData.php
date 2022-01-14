<?php


namespace App\Models\Complaints;

use Illuminate\Database\Eloquent\Model;

class ComplaintTypeData extends Model
{
    protected $table = 'complaint_type_data';
    protected $fillable = ['type_id','lang_id','title',"source_id"];
    //public $timestamps = false;
}
