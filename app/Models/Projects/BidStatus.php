<?php


namespace App\Models\Projects;
use Illuminate\Database\Eloquent\Model;

class BidStatus extends Model
{
    protected $table = 'bid_status';
    protected $fillable = ['title'];
    public $timestamps = true;
}
