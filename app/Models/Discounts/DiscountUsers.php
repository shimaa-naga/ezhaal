<?php


namespace App\Models\Discounts;

use App\User;
use Illuminate\Database\Eloquent\Model;

class DiscountUsers extends Model
{
    protected $table = 'discount_users';
    protected $fillable = ['discount_id', 'user_id', 'operations'];
    public $timestamps = true;
    public function User()
    {
        return $this->hasOne(User::class,  "user_id","id");
    }
}
