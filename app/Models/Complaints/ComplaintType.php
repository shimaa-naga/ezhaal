<?php


namespace App\Models\Complaints;


use Illuminate\Database\Eloquent\Model;

class ComplaintType extends Model
{
   // protected $guarded = [];
    protected $table = 'complaint_types';
    public function Data()
    {
        return $this->hasMany(ComplaintTypeData::class,"type_id","id");
    }

    public function Source()
    {
        return $this->Data()->whereNull("source_id")->first();
    }
}
