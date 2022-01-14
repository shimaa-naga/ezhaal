<?php

namespace App\Help;

use App\Models\SiteSettings\Settings as SiteSettingsModel;

class Settings
{
    public static function setSettingItem($key, $val)
    {
        $find = SiteSettingsModel::where("key", $key)->first();
        if ($find == null) {
            SiteSettingsModel::create(
                [
                    "key" => $key,
                    "title" => $key,
                    "value" => $val
                ]
            );
        } else {
            $find->update([
                "value" => $val
            ]);
        }
    }
    public static function get($key,  $default)
    {
        $find = SiteSettingsModel::where("key", $key)->first();
        if ($find == null)
            return $default;
        return $find->value;
    }
    public static function getDuration()
    {
        return self::get("min_duration",3);
    }
    public static function getBudget()
    {
        return self::get("min_budget",10);
    }
    public static function getCurrency()
    {
        return self::get("default_currency","usd");
    }
    public static function GetNdaFile()
    {
        return self::get("nda","notfound");
    }
    public static function GetLogo()
    {
        return self::get("logo","notfound");
    }
    public static function GetOnrequestGroup()
    {
        return self::get("on_request_role","");
    }
    public static function GetIntro()
    {
        return json_decode(self::get("intro","{}"));
    }
}
