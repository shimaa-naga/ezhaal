<?php


namespace App\Models\SiteSettings;


use Illuminate\Database\Eloquent\Model;

class Sliders extends Model
{
    protected $table = 'sliders';
    protected $fillable = ['status','image','url'];
    public $timestamps = true;
}
