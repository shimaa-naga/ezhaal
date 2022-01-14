<?php


namespace App\Models\SiteSettings;
use Illuminate\Database\Eloquent\Model;

class SettingTags extends Model
{
    protected $table = 'setting_tags';
    protected $fillable = [ 'page_code','route'];
    public $timestamps = true;
    public function Data()
    {
        return $this->hasMany(SettingTagData::class,"tag_id","id");
    }
    public function Source()
    {
        return $this->Data()->where("is_source",true)->first();
    }
}
