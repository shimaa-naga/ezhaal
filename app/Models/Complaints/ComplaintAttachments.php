<?php


namespace App\Models\Complaints;


use Illuminate\Database\Eloquent\Model;

class ComplaintAttachments extends Model
{
    protected $table = 'complaint_attachments';
    protected $fillable = ['complaint_id','file','file_type','created'];
    public $timestamps = false;
}
