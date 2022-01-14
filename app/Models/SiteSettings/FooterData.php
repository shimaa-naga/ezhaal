<?php


namespace App\Models\SiteSettings;
use Illuminate\Database\Eloquent\Model;

class FooterData extends Model
{
    protected $table = 'footer_data';
    protected $fillable = ['lang_id','footer_id','source_id','title','content'];
    public $timestamps = true;
}
