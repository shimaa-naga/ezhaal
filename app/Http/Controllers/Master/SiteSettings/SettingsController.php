<?php

namespace App\Http\Controllers\Master\SiteSettings;

use App\Help\Constants\MimTypes;
use App\Help\Utility;
use App\Http\Controllers\Controller;

use App\Models\SiteSettings\Settings;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;
use Spatie\Sitemap\SitemapGenerator;

class SettingsController extends Controller
{
    protected function index(Request $request)
    {
        $settings = Settings::orderBy("id")->whereNotIn("key", ["nda", "on_request_role", "logo", "default_currency", "min_duration", "min_budget","intro"])->get();

        return view('master.site_settings.index', compact('settings'));
    }
    protected function trusted(Request $request)
    {
        $rules =  [
            'sign' => 'mimes:' . MimTypes::NDA,

        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->to("master/settings")->with("error", _i("Invalid file type"));
        }
        $destinationPath = Utility::PathCreate("app/uploads/trusted", true);
        $filename = $request->sign->getClientOriginalName();
        $request->sign->move(storage_path($destinationPath), $filename);
        $this->setSettingItem("nda", storage_path($destinationPath) . "/" . $filename);
        return redirect()->to("master/settings")->with("success", _i("NDA uploaded successfully"));
    }
    protected function maps(Request $request)
    {
        //  dd(config("app.url"));
           SitemapGenerator::create(config("app.url"))->writeToFile(public_path("/sitemap.xml"));
           return redirect()->to("master/settings")->with("success", _i("SiteMap generated successfully"));
    }
    protected function logo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sign' => "image",
        ]);
        if ($validator->fails()) {
            return redirect()->to("master/settings")->with("error", _i("Invalid logo file type"));
        }
        if ($request->del != null) {
            $this->setSettingItem("logo", "");
            return redirect()->to("master/settings")->with("success", _i("Logo removed successfully"));
        }
        if ($request->sign == null)
            return redirect()->to("master/settings")->with("error", _i("No image is uploaded"));

        $destinationPath = Utility::PathCreate("uploads");
        $filename = $request->sign->getClientOriginalName();
        $request->sign->move(public_path($destinationPath), $filename);
        $this->setSettingItem("logo", ($destinationPath) . "/" . $filename);
        return redirect()->to("master/settings")->with("success", _i("Logo uploaded successfully"));
    }
    protected function onrequest(Request $request)
    {

        $validator = Validator::make($request->all(), ["role" => "required"]);
        if ($validator->fails()) {
            return redirect()->to("master/settings")->withErrors($validator);
        }

        $this->setSettingItem("on_request_role", $request->role);
        return redirect()->to("master/settings")->with("success", _i("Saved successfully"));
    }

    protected function intro(Request $request)
    {
        $data =["title" => $request->input("title") , "intro" => $request->input("intro")];
        \App\Help\Settings::setSettingItem("intro", json_encode($data));
        return redirect()->back()->with('success', _i('Saved Successfully !'));
    }
    protected function store(Request $request)
    {
        foreach ($request->input("setting") as $key => $val) {
            if ($val != null) {
                \App\Help\Settings::setSettingItem($key, $val);
            }
        }
        return redirect()->back()->with('success', _i('Saved Successfully !'));
    }
}
