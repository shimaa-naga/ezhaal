<?php


namespace App\Models\Transactions;
use Illuminate\Database\Eloquent\Model;

class TransactionRequest extends Model
{
    protected $table = 'transaction_requests';
    protected $fillable = ['freelancer_id', 'project_id', 'bid_id', 'price', 'created', 'note'];
    public $timestamps = true;
}
