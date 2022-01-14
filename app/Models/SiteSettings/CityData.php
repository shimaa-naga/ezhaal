<?php


namespace App\Models\SiteSettings;


use Illuminate\Database\Eloquent\Model;

class CityData extends Model
{
    protected $table = 'city_data';
    protected $fillable = ['city_id','lang_id','title','source_id'];
    public $timestamps = false;
}
