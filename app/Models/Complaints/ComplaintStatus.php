<?php


namespace App\Models\Complaints;


use Illuminate\Database\Eloquent\Model;

class ComplaintStatus extends Model
{
    protected $guarded = [];
    protected $table = 'complaint_status';
    public function Data()
    {
        return $this->hasMany(ComplaintStatusData::class,"status_id","id");
    }

    public function Source()
    {
        return $this->Data()->whereNull("source_id")->first();
    }
}
