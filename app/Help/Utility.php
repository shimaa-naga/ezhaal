<?php


namespace App\Help;


use App\Models\Blogs\Blogs;
use App\Models\Complaints\ComplaintDetails;
use App\Models\Projects\ProjCategories;
use App\Models\Projects\ProjCategoryData;
use App\Models\Projects\Projects;
use App\Models\SiteSettings\Currency;
use App\Models\SiteSettings\Footer;
use App\Models\SiteSettings\Messages;

use App\Models\SiteSettings\WorkMethod;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Xinax\LaravelGettext\Facades\LaravelGettext;

class Utility
{
    public const DefaultCurrency = "USD";
    public static function PathCreate($destinationPath, $private = false)
    {
        $folders = explode("/", $destinationPath);
        $old = "";
        foreach ($folders as $folder) {
            $old = $old . "/" . $folder;

            if ($private) {
                $path = storage_path($old);
            } else {
                $path = public_path($old);
            }

            if (!file_exists($path))
                mkdir($path);
        }
        return $old;
    }


    public static function getLang($locale = null)
    {
        if (!$locale && session()->has('lang_id'))
            return session()->get('lang_id');
        $locale = $locale ?? session('locale');

        //        $locale = empty($locale) ? config('app.locale') : $locale;
        $locale = empty($locale) ?  env('APP_LOCALE') : $locale;
        $language = \App\Language::where('code', $locale)->first();
        if ($language == null) {
            $language = \App\Language::first();
            session()->put('lang_id', $language->id);
            return $language->id;
        } else {
            session()->put('lang_id', $language->id);
            return $language->id;
        }
    }
    public static function getMasterLang()
    {
        $locale =  session('locale');
        $locale = empty($locale) ? env('APP_LOCALE') : $locale;
        $language = \App\Language::where('code', $locale)->first();
        if ($language == null) {
            $language = \App\Language::first();
        }
        return $language;
    }
    public static function getLangCode($locale = null)
    {
        $locale =  session('locale');
        $locale = empty($locale) ? env('APP_LOCALE') : $locale;
        if ($locale != null) {
            // App::setLocale($locale);
            // LaravelGettext::setLocale( $locale);
            return $locale;
        }

        $language = \App\Language::where('code', $locale)->first();
        if ($language == null) {
            $language = \App\Language::first();
            session()->put('lang_code', $language->code);
            $locale = $language->code;
            // App::setLocale($locale);
            // LaravelGettext::setLocale( $locale);
            return $locale;
        }
    }

    public static function websiteLang($locale = null)
    {
        if (!$locale && session()->has('siteLang')) return session()->get('siteLang');
        $locale = $locale ?? session('locale');
        $locale = empty($locale) ? env('APP_LOCALE') : $locale;
        $language = \App\Language::where('code', $locale)->first();
        if ($language == null) {
            $language = \App\Language::first();
            return $language->id;
        } else {
            session()->put('siteLang', $language->id);
            return $language->id;
        }
    }
    public static function getWebsiteLang()
    {
        $locale =  session('locale');
        $locale = empty($locale) ? env('APP_LOCALE') : $locale;
        $language = \App\Language::where('code', $locale)->first();
        if ($language == null) {
            $language = \App\Language::first();
        }
        return $language;
    }
    public static function getWebsiteLangId()
    {
        $locale =  session('siteLang');

        if ($locale == null) {
            $locale = \App\Language::first()->id;
        }
        return $locale;
    }
    public static function getWebsiteCurrency()
    {
        $currency_id = Cookie::get('currency_id');

        if ($currency_id == null || !is_numeric($currency_id)) {
            return Currency::where("active", "1")->first();
        } else
            return Currency::find($currency_id);
    }
    public static function getCategories($type)
    {
        $obj = new Category();
        $obj->publish = 1;
        $obj->without_parents = true;
        return  $obj->selectTreeArray($type);
    }
    public static function getParentCategories($type)
    {
        // $collection = ProjCategories::whereNull('parent_id')->where("published", 1);
        // return $collection->get();

        $result =  ProjCategoryData::where("lang_id", self::websiteLang())->join("projcategories", "projcategories.id", "projcategory_data.category_id")->where("projcategories.type", $type)->whereIn("projcategories.id", function ($q) {
            return $q->from("projcategory_attributes")->select("category_id")->where("show_public", 1);
        })->select("projcategories.id", "title")->get()->toArray();
        array_walk($result, function (&$item) {

            $f = "uploads/category/" . $item["id"] . ".png";
            $file = public_path($f);
            if (file_exists($file)) {
                $item["imageUrl"] = asset($f);
            } else {
                $item["imageUrl"] = asset("uploads/category/cat.png");
            }
        });

       // dd($result);
        return $result;
        $obj = new Category();
        $obj->publish = 1;
        dd($obj->getParentsArray(), $result);
        return  $obj->getParentsArray();
    }
    public static function getCategoriesWithType($type)
    {
        $obj = new Category();
        $obj->publish = 1;
        return $obj->getTreeArray($type);
        // return ProjCategoryData::join("projcategories", "projcategories.id", "category_id")
        //     ->where("lang_id", self::getWebsiteLangId())->where("projcategories.type", $type)->whereNull("parent_id")->where("published",1)->get();
    }

    public static function getBlogs()
    {
        $blogs = Blogs::leftJoin('blogs_data', 'blogs_data.blog_id', 'blogs.id')
            ->select('blogs_data.title', 'blogs_data.blog_id')
            ->where('blogs.published', 1)
            ->where('blogs_data.lang_id', Utility::websiteLang())
            ->orderByDesc('blogs.id')->take(7)
            //->latest()->take(3)
            ->get();
        return $blogs;
    }

    public static function getCurrency()
    {
        $currencies = Currency::where('active', 1)->get();
        return $currencies;
    }

    public static function getFooter()
    {
        $footers = Footer::orderBy('order', 'asc')->get();
        return $footers;
    }

    public static function ticketCount()
    {
        $tickets = ComplaintDetails::where('by_id', auth()->guard('web')->user()->id)
            ->whereNull('reply_id')->count();
        return $tickets;
    }
    public static function messageCount()
    {
        $sub = Messages::groupBy('message_id')
            ->where('to_user', auth()->guard('web')->user()->id)
            ->select("message_id", DB::raw('MAX(id) AS max_id'));

        $messages = Messages::joinSub($sub, "sub", function ($join) {
            $join->on('messages.id', '=', 'sub.max_id');
        });

        return $messages->get()->count();
    }

    public static function messageUnReadCount()
    {
        $messages = Messages::where('to_user', auth()->guard('web')->user()->id)->whereNull('read_at')->count();
        return $messages;
    }

    public static function projectCount()
    {
        $projects = Projects::where("owner_id", auth("web")->user()->id)->count();
        return $projects;
    }

    public static function workMethod()
    {
        $query = WorkMethod::join("work_method_data", "work_methods.id", "work_method_data.work_method_id")
            ->where("lang_id", self::getWebsiteLangId())

            ->orderBy('order', 'asc')->get();
        return $query;
    }
}
