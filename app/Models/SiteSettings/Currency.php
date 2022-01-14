<?php


namespace App\Models\SiteSettings;


use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    //protected $table = 'cities';
    protected $fillable = ['code',"rate",'active'];
    public $timestamps = true;


}
