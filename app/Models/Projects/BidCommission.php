<?php


namespace App\Models\Projects;
use Illuminate\Database\Eloquent\Model;

class BidCommission extends Model
{
    protected $table = 'bid_commission';
    protected $fillable = ['bid_id', 'commission_id', 'amount'];
    public $timestamps = true;
}
