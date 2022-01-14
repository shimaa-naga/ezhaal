<?php


namespace App\Models\Projects;

use Illuminate\Database\Eloquent\Model;

class BidAttachements extends Model
{
    protected $table = 'bid_attachements';
    protected $fillable = ['bid_id', 'attachment'];
    public $timestamps = true;
    public function getfileAttribute()
    {
        return $this->attachment;
    }
}
