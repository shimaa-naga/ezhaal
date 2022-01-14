<?php


namespace App\Models\Transactions;


use Illuminate\Database\Eloquent\Model;

class TransactionCommission extends Model
{
    protected $table = 'transaction_commission';
    protected $fillable = ['transaction_id', 'commission_id', 'amount'];
    public $timestamps = true;
}
