<?php


namespace App\Models\Affiliates;
use Illuminate\Database\Eloquent\Model;

class AffiliateSettings extends Model
{
    protected $table = 'affiliates_settings';
    protected $fillable = ['affiliate_id', 'code', 'user_id', 'target_user_id'];
    public $timestamps = true;
}
