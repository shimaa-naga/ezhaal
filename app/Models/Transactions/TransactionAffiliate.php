<?php


namespace App\Models\Transactions;
use Illuminate\Database\Eloquent\Model;

class TransactionAffiliate extends Model
{
    protected $table = 'transaction_affiliate';
    protected $fillable = ['affiliate_id', 'transaction_id'];
    public $timestamps = true;
}
