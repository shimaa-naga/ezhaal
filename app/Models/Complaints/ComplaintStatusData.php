<?php


namespace App\Models\Complaints;


use Illuminate\Database\Eloquent\Model;

class ComplaintStatusData extends Model
{
    protected $table = 'complaint_status_data';
    protected $fillable = ['status_id','lang_id','title',"source_id"];
    public $timestamps = false;
}
