<?php


namespace App\Models\SiteSettings;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    protected $table = 'settings';
    protected $fillable = ['key', 'title', 'value'];
    public $timestamps = false;

}
