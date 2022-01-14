<?php


namespace App\Models\SiteSettings;


use Illuminate\Database\Eloquent\Model;

class SlidersData extends Model
{
    protected $table = 'sliders_data';
    protected $fillable = ['slider_id','lang_id','title','description'];
    public $timestamps = false;
}
