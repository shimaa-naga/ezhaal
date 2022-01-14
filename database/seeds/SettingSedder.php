<?php

use App\Models\SiteSettings\Settings;
use Illuminate\Database\Seeder;

class SettingSedder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $items =[
            ["title" => "facebook","key"=> "facebook","value" => ""],
            ["title" => "Phone","key"=> "phone","value" => ""],
            ["title" => "Mobile","key"=> "mobile","value" => ""],
            ["title" => "Default website currency","key"=> "default_currency","value" => ""],
            ["title" => "Minimum project budget","key"=> "min_budget","value" => ""],
            ["title" => "Minimum project duration","key"=> "min_duration","value" => ""],
    ];
        Settings::insert($items);
    }
}
