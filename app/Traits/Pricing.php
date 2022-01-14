<?php

namespace App\Traits;

use App\Help\Constants\DiscountModule;
use App\Help\Constants\UserType;
use App\Models\Discounts\Discount;
use App\Models\SiteSettings\Commissions;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

trait Pricing
{
    public function GetCommissionJSEquation($category = "")
    {
        $all = Commissions::all();
        $equation = 0;
        foreach ($all as $item) {
            if ($item->category_id != null) {
                if ($item->category_id === $category) {

                    if ($item->type == "perc") {
                        $equation .= "+price*(" . $item->price . "/100)";
                    } else {
                        $equation .= "+" . $item->price;
                    }
                }
            } else {
                if ($item->type == "perc") {
                    $equation .= "+price*(" . $item->price . "/100)";
                } else {
                    $equation .= "+" . $item->price;
                }
            }
        }
        return $equation;
    }

    public function GetCommission($price, $category = "")
    {
        $all = Commissions::all();
        $sum = 0;
        foreach ($all as $item) {
            if ($item->category_id != null) {
                if ($category != null &&  $item->category_id == $category) {
                    if ($item->type == "perc") {
                        $sum += $price * $item->price / 100;
                    } else {
                        $sum +=   $item->price;
                    }
                }
            } else {
                if ($item->type == "perc") {
                    $sum += $price * $item->price / 100;
                } else {
                    $sum += $item->price;
                }
            }
        }
        return ceil($sum);
    }
    public function GetDiscountJSEquation()
    {
        $discount = $this->GetDiscount();
        $equation = 0;
        if ($discount == null) {
            return $equation;
        }
        if ($discount->type == "perc") {
            $equation = "price*(" . $discount->price . "/100)";
        } else {
            $equation =  $discount->price;
        }
        return $equation;
    }
    public function GetDiscount()
    {
        if (!Auth::check())
            return null;
        $all = Discount::where("enabled", "1")->whereNotIn("id", function ($q) {
            $q->from("transactions")->whereNotNull("discount_id")->where("user_id", auth("web")->id())->select("discount_id");
        })->get();
        $best_discount = null;
        foreach ($all as $discount) {
            //if ($discount->user_type == null || $discount->user_type == auth("web")->user()->account_type) {
            switch ($discount->module) {
                case DiscountModule::SPECIFIC_USER:
                    if ($discount->Users()->where("user_id", auth("web")->user()->id)->first() != null)
                        if ($discount->counter > 0) {
                            if ($best_discount == null || $best_discount->price < $discount->price)
                                $best_discount = $discount;
                        }
                    break;
                case DiscountModule::PER_DATE:
                    $today = Carbon::now();
                    $from = Carbon::parse($discount->from_date);
                    $to = Carbon::parse($discount->to_date);
                    // dd($today->greaterThanOrEqualTo($from),$from ,$to);
                    if ($today->greaterThanOrEqualTo($from) && $today->lessThanOrEqualTo($to)) {

                        if ($discount->user_type == null || $discount->user_type == auth("web")->user()->account_type || $discount->Users()->where("id", auth("web")->user()->id)->first() != null) {

                            if ($best_discount == null || $best_discount->price < $discount->price)
                                $best_discount = $discount;
                        }
                    }
                    break;
                case DiscountModule::PER_USERS:
                    if ($discount->counter > 0) {
                        if ($best_discount == null || $best_discount->price < $discount->price)
                            $best_discount = $discount;
                    }
                    break;
                case DiscountModule::PER_USER_OPERATIONS:
                    if (count(auth("web")->user()->bids()->get()) >= $discount->times || count(auth("web")->user()->projects()->get()) >= $discount->times) {
                        if ($best_discount == null || $best_discount->price < $discount->price)
                            $best_discount = $discount;
                    }
                    break;
            }

            // }
        }
        if ($best_discount != null && $best_discount->Transaction()->where("user_id", auth("web")->id())->first() == null)
            return $best_discount;
        return null;
    }
}
