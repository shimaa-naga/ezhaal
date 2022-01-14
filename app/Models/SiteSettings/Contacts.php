<?php


namespace App\Models\SiteSettings;
use Illuminate\Database\Eloquent\Model;

class Contacts extends Model
{
    protected $table = 'contacts';
    protected $fillable = ['name','email','subject','message'];
    public $timestamps = true;
}
