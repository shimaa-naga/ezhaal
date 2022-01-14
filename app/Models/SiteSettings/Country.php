<?php


namespace App\Models\SiteSettings;


use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = 'countries';
    protected $fillable = ['code','logo'];
    public $timestamps = true;
}
