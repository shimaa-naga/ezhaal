<?php


namespace App\Models\Discounts;

use App\Models\Transactions\Transaction;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $table = 'discounts';
    protected $fillable = ['title', 'price', 'type', 'enabled', "module", "user_type"];
    public $timestamps = true;

    public function Users()
    {
        return $this->belongsToMany(User::class, "discount_users", "discount_id", "user_id");
    }
    public function Transaction()
    {
        return $this->hasMany(Transaction::class, "discount_id");
    }
    public function Details()
    {
        return $this->hasOne(DiscountDetails::class, "discount_id");
    }
    public function getTimesAttribute()
    {
        $obj = $this->Details()->first();

        if ($obj == null)
            return 1;
        return $obj->times;
    }
    public function getCounterAttribute()
    {
        $obj = $this->Details()->first();

        if ($obj == null)
            return 1;
        return $obj->counter;
    }
    public function getFromdateAttribute()
    {
        $obj = $this->Details()->first();
        if ($obj == null)
            return "";
            return \Carbon\Carbon::parse($obj->from_date)->format('d-m-Y');

    }
    public function getTodateAttribute()
    {
        $obj = $this->Details()->first();
        if ($obj == null)
            return "";
            return \Carbon\Carbon::parse($obj->to_date)->format('d-m-Y');

    }
}
