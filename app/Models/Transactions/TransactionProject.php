<?php


namespace App\Models\Transactions;
use Illuminate\Database\Eloquent\Model;

class TransactionProject extends Model
{
    protected $table = 'transaction_projects';
    protected $fillable = ['project_id', 'transaction_id'];
    public $timestamps = true;
}
