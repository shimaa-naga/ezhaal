<?php

namespace App\Help;

use App\Models\Projects\ProjectBids;
use App\Notifications\BidAccepted;
use App\Notifications\BidCompleted;
use App\Notifications\FreelancerApplied;
use App\Notifications\FreelancerRejected;
use Spatie\Permission\Models\Role;

class Notification
{
    public static function getMasterNotifications()
    {
        $role_name = Settings::GetOnrequestGroup();

        if (auth("master")->user()->hasRole($role_name)) {

            return Role::where("name", $role_name)->first()->notifications;
        }
        return[];
    }
    public static function Get($notification, $br = " ")
    {
        switch ($notification->type) {
            case FreelancerApplied::class:
                $bid = ProjectBids::find($notification->data["bid_id"]);
                $extra = "";
                $id = "";
                if ($bid != null) {
                    $extra = $bid->Project()->title;
                    $id = $bid->Project()->id;
                }
                return "<a href='/dash/project/" . $id . "'>" . $notification->data["email"] . $br . _i("applied to") . " " . $extra . "</a>";
            case FreelancerRejected::class:
                $bid = ProjectBids::find($notification->data["bid_id"]);
                $extra = "";
                if ($bid != null)
                    $extra = $bid->Project()->title;
                return "Your bid is " . _i("Rejected") . " for " . $extra;
            case BidAccepted::class:
                $bid = ProjectBids::find($notification->data["bid_id"]);
                $extra = "";
                if ($bid != null)
                    $extra = $bid->Project()->title;
                return _i(" Your bid is accepted for ") . " " . $extra;
            case BidCompleted::class:
                $bid = ProjectBids::find($notification->data["bid_id"]);
                $extra = "";
                if ($bid != null)
                    $extra = $bid->Project()->title;
                return _i("Project is completed") . " " . $extra;
        }
    }
}
