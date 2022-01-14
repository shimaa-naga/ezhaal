<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Xinax\LaravelGettext\Facades\LaravelGettext;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

       // (LaravelGettext::getLocale());
        if (Session::has('locale') && session("locale") !=null) {
            App::setLocale(session('locale'));
            LaravelGettext::setLocale(session('locale'));
        } else {
            $userLangs = preg_split('/,|;/', Request::header('Accept-Language'));
            $default = "";
            foreach (LaravelGettext::getSupportedLocales() as $lang) {
                if (in_array($lang, $userLangs)) {

                    App::setLocale($lang);
                    LaravelGettext::setLocale($lang);
                    Session::put('locale', $lang);
                    $default = $lang;

                    break;
                }
            }

            if ($default == "") {
                Session::put('locale', config('app.locale'));
                LaravelGettext::setLocale(config('app.locale'));
            }
        }
        return $next($request);
    }
}
