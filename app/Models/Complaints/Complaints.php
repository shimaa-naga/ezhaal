<?php


namespace App\Models\Complaints;


use App\Help\Utility;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Complaints extends Model
{
    protected $table = 'complaints';
    protected $fillable = ['type_id', 'status_id', 'created'];
    public $timestamps = true;

    // to get status data value
    public function status()
    {
        return $this->hasOne(ComplaintStatusData::class, "status_id", "status_id");
    }
    public function Details()
    {
        return $this->hasMany(ComplaintDetails::class, "complaint_id", "id");
    }
    public function authorDetails()
    {
        return $this->hasMany(ComplaintDetails::class, "complaint_id", "id")->whereNull("reply_id");
    }
    public function History()
    {
        return $this->hasMany(ComplaintStatusHistory::class, "complaint_id", "id");
    }
    public function statusDataWithLang()
    {
        return $this->status()->where("lang_id", Utility::websiteLang())->first();
    }
    public function replies()
    {
        return DB::select("SELECT id,complaint_id,by_id,created_at,0 as status_id,description FROM complaint_details  where complaint_id=" . $this->id . " union (select id,complaint_id,by_id,created_at,status_id,'status update'  from complaint_status_history where complaint_id=" . $this->id . ") order by created_at desc");
    }
}
