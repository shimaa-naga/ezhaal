<?php


namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class TrustedUser extends Model
{
    protected $table = 'trusted_users';
    protected $fillable = ['user_id', 'file', 'description', 'status'];
    public $timestamps = true;
    protected $attributes = [
        'description' => "",
    ];
    public function User()
    {
        return $this->hasOne(User::class, "id", "user_id");
    }

}
