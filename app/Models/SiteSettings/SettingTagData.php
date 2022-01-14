<?php


namespace App\Models\SiteSettings;
use Illuminate\Database\Eloquent\Model;

class SettingTagData extends Model
{
    protected $table = 'setting_tag_data';
    protected $fillable = ['lang_id',"tag_id", 'is_source', 'keywords','description',"title"];
    public $timestamps = true;

}
