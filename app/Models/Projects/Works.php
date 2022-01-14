<?php

namespace App\Models\Projects;

use Illuminate\Database\Eloquent\Model;

class Works extends Model
{
    //
    protected $table = 'bid_work_attachemnets';
    protected $fillable = ['file', 'description', 'bid_id', 'created'];
    public $timestamps = true;
    public function Bid()
    {
        return $this->belongsTo(ProjectBids::class, "bid_id", "id");
    }

}
