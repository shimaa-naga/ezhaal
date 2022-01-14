<?php


namespace App\Http\Controllers\Master;


use App\Help\Utility;
use App\Http\Controllers\Controller;
use App\Language;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use PhpParser\Builder\Function_;
use Spatie\Sitemap\SitemapGenerator;
use stdClass;
use Xinax\LaravelGettext\Facades\LaravelGettext;

class DashboardController extends Controller
{

    private function GetData($collection)
    {
        $labels = array_pluck($collection, "title");
        $data = array_pluck($collection, "count");
        $obj = new stdClass;
        $obj->labels = $labels;
        $obj->data = $data;
        $arr = [];
        for ($i = 0; $i < count($labels); $i++) {
            $arr[] = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
        }
        $obj->colors = $arr;
        return $obj;
    }
    protected  function index()
    {


        $status = DB::select('select \'count\',title  from  (SELECT status_id,count(id) FROM complaints group by id,status_id) as a
        inner join complaint_status_data on complaint_status_data.status_id=a.status_id and source_id is null');
        $complaint_status = $this->GetData($status);

        $types = DB::select('select \'count\',title  from  (SELECT type_id,count(id) FROM complaints group by id,type_id) as a
        inner join complaint_type_data on complaint_type_data.type_id=a.type_id and source_id is null');
        $complaint_types = $this->GetData($types);

        $complaint_dates = DB::select("SELECT  count(*),CONCAT(extract(month from created_at) ,'-',extract(year from created_at) ) as title  from complaints group by title");
        $complaint_dates = $this->GetData($complaint_dates);

         $project_dates = DB::select("SELECT  count(*) ,CONCAT(extract(month from created_at) ,'-',extract(year from created_at) )  title from projects group by CONCAT(extract(month from created_at) ,'-',extract(year from created_at) )");
         $project_dates = $this->GetData($project_dates);

         $project_status =DB::select("select 'count',title  from  (SELECT status_id,count(id) FROM projects group by status_id) as a inner join proj_status on proj_status.id=a.status_id");
         $project_status = $this->GetData($project_status);


        return view('master.home', compact("complaint_types", "complaint_status","complaint_dates","project_dates","project_status"));
    }

    public function changeMasterLang($locale = null)
    {
        App::setLocale($locale);
        // dd($locale);
        LaravelGettext::setLocale($locale);
        session()->put('locale', $locale);
        $language = Language::where('code', $locale)->first();
        if ($language != null) {
            session()->put('lang_id', $language['id']);
        }
        return redirect()->back();
    }
}
