<?php


namespace App\Models\Discounts;
use Illuminate\Database\Eloquent\Model;

class DiscountDetails extends Model
{
    protected $table = 'discount_details';
    protected $fillable = ['discount_id', 'from_date', 'to_date', 'counter','times'];
    public $timestamps = true;
}
