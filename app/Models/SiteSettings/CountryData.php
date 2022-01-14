<?php


namespace App\Models\SiteSettings;
use Illuminate\Database\Eloquent\Model;

class CountryData extends Model
{
    protected $table = 'country_data';
    protected $fillable = ['country_id','lang_id','title'];
    public $timestamps = false;
}
