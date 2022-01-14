<?php


namespace App\Models\SiteSettings;


use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'cities';
    protected $fillable = ['country_id'];
    public $timestamps = true;

    public function Data()
    {
        return $this->hasMany(CityData::class,"city_id","id");
    }

    public function Source()
    {
        return $this->Data()->whereNull("source_id")->first();
    }
}
