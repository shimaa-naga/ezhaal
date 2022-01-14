<?php

namespace App;

use App\Help\Constants\UserType;

class Companies
{

    public static function all()
    {

        return  User::join("companies","users.id","user_id")->select("users.id","companies.id as company_id","cr_number","companies.name","active","logo","email","companies.created_at","image");
    }

    public static function Buyers()
    {
        return self::all()->whereIn("users.id", function ($q) {
            return $q->from("project_bids")->select("freelancer_id")->groupBy("freelancer_id");
        });
    }
    public static function Providers()
    {
        return self::all()->whereIn("users.id", function ($q) {
            return $q->from("projects")->select("owner_id")->groupBy("owner_id");
        });
    }
}
