<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Companies extends Model
{
    //
    protected $table = 'companies';
    protected $fillable = ['user_id', 'cr_number', 'name', 'address', 'logo'];
    public $timestamps = true;
    public function MasterAccount()
    {
        return $this->hasOne(User::class, "id", "user_id");
    }
}
