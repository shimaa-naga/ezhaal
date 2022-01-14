<?php

namespace App;


use App\Help\Constants\UserType;


class WebsiteUser
{
    public static function all()
    {

        return User::where("guard", "web")->where("account_type",UserType::USER);

    }
    public static function allCompanies()
    {
        //return Role::findByName(Roles::COMPANY)->users();
        return User::where("guard", "web")->where("account_type",UserType::COMPANY);
    }
    public static function allUsers()
    {
        //return Role::findByName(Roles::COMPANY)->users();
        return User::where("guard", "web")->where("account_type",UserType::USER);
    }
    public static function Freelancers()
    {
      return   User::where("account_type",UserType::USER)->whereIn("id",function($q){
            return $q->from("project_bids")->select("freelancer_id")->groupBy("freelancer_id");
        });
    }
    public static function Providers()
    {
       return User::where("account_type",UserType::USER)->whereIn("id",function($q){
            return $q->from("projects")->select("owner_id")->groupBy("owner_id");
        });
    }

}
