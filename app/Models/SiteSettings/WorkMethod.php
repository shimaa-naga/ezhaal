<?php


namespace App\Models\SiteSettings;


use App\Help\Utility;
use Illuminate\Database\Eloquent\Model;

class WorkMethod extends Model
{
    protected $table = 'work_methods';
    protected $fillable = ['order','icon'];
    public $timestamps = true;

    public function Data()
    {
        return $this->hasMany(WorkMethodData::class,"work_method_id","id");
    }

    public function Source()
    {
        return $this->Data()->whereNull("source_id")->first();
    }

    public function Lang()
    {
        return $this->Data()->where("lang_id", Utility::websiteLang())->first();
    }
}
