<?php


namespace App\Http\Controllers\Website;

use App\Help\Constants\ProjectStatus;
use App\Help\Utility;
use App\Http\Controllers\Controller;
use App\Language;
use App\Mail\MasterForgetPassword;
use App\Models\Blogs\Blogs;
use App\Models\Projects\Projects;
use App\Models\SiteSettings\Contacts;
use App\Models\SiteSettings\Currency;
use App\Models\SiteSettings\Sliders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Mail;
use Xinax\LaravelGettext\Facades\LaravelGettext;

class HomeController extends Controller
{

    public function home()
    {

        //dd(App::getLocale())//;
        $sliders = Sliders::leftJoin('sliders_data', 'sliders_data.slider_id', 'sliders.id')
            ->select('sliders.id', 'sliders.image', 'sliders.url', 'sliders_data.title', 'sliders_data.description')
            ->where('sliders.status', 1)
            ->where('sliders_data.lang_id', Utility::websiteLang())
            ->get();
        //dd($sliders, Utility::websiteLang());
        $blogs = Blogs::join('blogs_data', 'blogs_data.blog_id', 'blogs.id')
            ->select('blogs_data.*')
            ->where('blogs.published', 1)
            ->where('blogs_data.lang_id', Utility::websiteLang())
            ->orderByDesc('blogs.id')->take(6)
            ->get();


        $limit = 4;
        $projects = Projects::leftJoin('proj_status', 'proj_status.id', 'projects.status_id')
            ->where('proj_status.title', ProjectStatus::PUBLISHED)
            ->select('projects.*')->orderByDesc('projects.id');
        $projects = $projects->paginate($limit);


        return view('website.home', compact('sliders', 'blogs', 'projects'));
    }
    protected function getProjects()
    {
        $limit = 4;
        $projects = Projects::leftJoin('proj_status', 'proj_status.id', 'projects.status_id')
            ->where('proj_status.title', ProjectStatus::PUBLISHED)
            ->select('projects.*')->orderByDesc('projects.id');
        if (request()->ajax()) {

            $projects = $projects->paginate($limit);
            return view('website.home.projects_ajax', compact('projects'))->render();
        }
    }

    public function changeWebsiteLang($locale = null)
    {

        App::setLocale($locale);
        // dd($locale);
        LaravelGettext::setLocale($locale);

        session()->put('locale', $locale);
        $language = Language::where('code', $locale)->first();
        if ($language != null) {
            session()->put('siteLang', $language['id']);
        }
        return redirect()->back();
    }

    public function changeWebsiteCurrency($currency = null)
    {
        if ($currency == null) {
            $currency_id = Currency::where('active', 1)->first()->id;
        } else {
            $currency_id = $currency;
        }
        $minutes = 525948;
        Cookie::queue(Cookie::make('currency_id', $currency_id, $minutes));
        //        dd(Cookie::get('currency_id'));
        return redirect()->back();
    }

    public function store_contact(Request $request)
    {
        $rules = [
            'name' => ['required', 'string', 'max:150', 'min:3'],
            'email' => ['required', 'string', 'email', 'max:100'],
            'subject' => ['required'],
            'message' => ['required', 'string', 'min:10']
        ];

        $validator = validator()->make($request->all(), $rules);
        if ($validator->fails())
            return redirect()->back()->withErrors($validator)->withInput();
        $contact = Contacts::create([
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
        ]);

        return redirect()->back()->with('success', _i('Send Successfully'));
    }
}
