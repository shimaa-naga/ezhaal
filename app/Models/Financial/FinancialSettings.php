<?php


namespace App\Models\Financial;

use Illuminate\Database\Eloquent\Model;

class FinancialSettings extends Model
{
    protected $table = 'financial_settings';
    protected $fillable = ['transfer_minimum_amount', 'holding_days', 'provider_limit'];
    public $timestamps = true;


}
