<?php


namespace App\Models\SiteSettings;

use App\Help\Utility;
use Illuminate\Database\Eloquent\Model;

class Footer extends Model
{
    protected $table = 'footers';
    protected $fillable = ['order'];
    public $timestamps = true;

    public function Data()
    {
        return $this->hasMany(FooterData::class, "footer_id", "id");
    }

    public function Source()
    {
        return $this->Data()->whereNull("source_id")->first();
    }

    public function Lang()
    {
        $item = $this->Data()->where("lang_id", Utility::websiteLang())->first();
        if ($item == null)
            $item = $this->Data()->first();
        return $item;
    }
}
