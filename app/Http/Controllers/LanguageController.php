<?php


namespace App\Http\Controllers;


use App\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class LanguageController extends Controller
{
    public function getLang(Request $request)
    {
        $lang = Language::where('id', $request->input('lang_id'))->first();
        if ($lang){
            return Response::json($lang->title);
        }
    }
}
