<?php

namespace App\Models\Security;

use Illuminate\Database\Eloquent\Model;

class PermissionData extends Model
{
   // protected $guarded = [];
    protected $table = 'permission_data';
    protected $fillable = ['title','permission_id','lang_id'];
    public $timestamps = true;
}
