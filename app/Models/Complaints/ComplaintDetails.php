<?php


namespace App\Models\Complaints;

use App\User;
use Illuminate\Database\Eloquent\Model;

class ComplaintDetails extends Model
{
    protected $table = 'complaint_details';
    protected $fillable = ['complaint_id','by_id','reply_id','title','description','created'];
    public $timestamps = true;

    public function attachments()
    {
        return $this->hasMany(ComplaintAttachments::class,"complaint_id","id");
    }
    public function By()
    {
        return $this->hasOne(User::class,"id","by_id");
    }
    public function Parent()
    {
        return $this->belongsTo(Complaints::class,"complaint_id","id");
    }
}
