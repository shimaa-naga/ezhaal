<?php


namespace App\Models\Affiliates;
use Illuminate\Database\Eloquent\Model;

class Affiliate extends Model
{
    protected $table = 'affiliates';
    protected $fillable = ['title', 'amount', 'code'];
    public $timestamps = true;
}
