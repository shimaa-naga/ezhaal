<?php
namespace App\Help;

use App\Models\Skills\SkillsData;


class Skills
{
    public static function GetAll()
    {
        return SkillsData::where("lang_id" ,Utility::getWebsiteLangId())->get();
    }
}
