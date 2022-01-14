<?php


namespace App\Models\Security;

use Illuminate\Database\Eloquent\Model;

class RoleData extends Model
{
    protected $table = 'role_data';
    protected $fillable = ['title','role_id','lang_id'];
    public $timestamps = false;
}
