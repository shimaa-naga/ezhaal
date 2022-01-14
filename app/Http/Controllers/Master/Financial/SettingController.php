<?php

namespace App\Http\Controllers\Master\Financial;

use App\Http\Controllers\Controller;
use App\Models\Financial\FinancialSettings;
use App\Models\SiteSettings\Settings;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index(Request $request)
    {

        $settings = FinancialSettings::first();
        if ($request->method() == "POST") {
            if ($settings != null) {
                $settings->update([
                    'transfer_minimum_amount' => $request->transfer,
                    'holding_days' => $request->holding,

                ]);
            } else {
                $settings = FinancialSettings::create([
                    'facebook_id' => $request->transfer,
                    'mobile' => $request->holding,
                ]);
            }
            foreach ($request->input("setting") as $key => $val) {
                if ($val != null) {
                    \App\Help\Settings::setSettingItem($key, $val);
                }
            }
        }
        if ($settings == null)
            $settings = new FinancialSettings();

        if ($request->method() == "POST") {
            return back()->with('success', _i('Saved Successfully !'));
        }
        $globalsettings = Settings::orderBy("id")->whereIn("key", ["default_currency", "min_duration", "min_budget"])->get();

        return view('master.financial.setting.index', compact('settings', 'globalsettings'));
    }
}
