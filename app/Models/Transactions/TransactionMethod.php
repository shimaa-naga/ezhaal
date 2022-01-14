<?php


namespace App\Models\Transactions;
use Illuminate\Database\Eloquent\Model;

class TransactionMethod extends Model
{
    protected $table = 'transaction_methods';
    protected $fillable = ['title', 'code'];
    public $timestamps = true;
}
