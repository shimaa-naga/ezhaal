<?php


namespace App\Models\Complaints;
use Illuminate\Database\Eloquent\Model;

class ComplaintStatusHistory extends Model
{
    protected $table = 'complaint_status_history';
    protected $fillable = ['complaint_id','status_id','by_id','created'];
    public $timestamps = true;
}
