<?php

namespace App\Help;

use App\Models\Complaints\ComplaintDetails;
use App\Models\Complaints\Complaints as ComplaintsModel;
use App\Models\Complaints\ComplaintStatusData;



class Complaints
{
    public static function getStatusTitle($status_id, $lang_id)
    {
        $find = ComplaintStatusData::where('status_id', $status_id)->where('lang_id', $lang_id)->first();
        if ($find == null) {
            ComplaintStatusData::where('status_id', $status_id)->first();
        }
        if ($find != null)
            return $find->title;
    }
    public static function getOpenedTickets()
    {
       return ComplaintsModel::latest()->take(5)->get();
    }
}
