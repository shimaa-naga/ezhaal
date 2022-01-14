<?php


namespace App\Models\Affiliates;
use Illuminate\Database\Eloquent\Model;

class AffiliateUsers extends Model
{
    protected $table = 'affiliate_users';
    protected $fillable = ['user_id', 'affiliate_id'];
    public $timestamps = true;
}
