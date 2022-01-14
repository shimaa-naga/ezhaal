<?php


namespace App\Models\Financial;
use Illuminate\Database\Eloquent\Model;

class FinancialSettingUsers extends Model
{
    protected $table = 'financial_setting_users';
    protected $fillable = ['provider_limit', 'financial_setting_id', 'user_id'];
    public $timestamps = true;
}
