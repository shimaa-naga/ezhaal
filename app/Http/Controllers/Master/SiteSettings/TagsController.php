<?php

namespace App\Http\Controllers\Master\SiteSettings;

use App\Help\Constants\MimTypes;
use App\Help\Utility;
use App\Http\Controllers\Controller;
use App\Language;
use App\Models\SiteSettings\Settings;
use App\Models\SiteSettings\SettingTagData;
use App\Models\SiteSettings\SettingTags;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class TagsController extends Controller
{

    protected function index()
    {
        if (request()->ajax()) {
            $query = SettingTagData::join("setting_tags", "setting_tags.id", "setting_tag_data.tag_id")
                ->where("is_source", true)->select("setting_tag_data.id as data_id", 'setting_tags.id', "route", "keywords", "description", "lang_id", "page_code","title")->orderByDesc('id');
            return DataTables::eloquent($query)

                ->addColumn('options', function ($query) {
                    $html = '
                    <a href ="#" data-toggle="modal" data-target="#modal-edit" class="btn waves-effect waves-light btn-primary edit text-center " title="' . _i("Edit") . '"
						data-id="' . $query->id . '" data-pagecode="' . $query->page_code . '" data-meta="' . $query->keywords . '" data-title="' . $query->title . '" data-lang="' . $query->lang_id . '" data-description="' . $query->description . '" data-route="' . $query->route . '">
					<i class="fa fa-edit"></i> </a> &nbsp;
                    <form action="tags/' . $query->id . '"  method="POST"  style="display: inline-block; right: 50px;" class="delform">
                    		<input name="_method" type="hidden" value="DELETE">
                    		<input type="hidden" name="_token" value="' . csrf_token() . '">
                    		<button type="submit" class="btn btn-danger" title=" ' . _i('Delete') . ' "> <span> <i class="fa fa-trash-o"></i></span></button>
                     </form> &nbsp; ';

                    $langs = Language::where("id", "!=", $query->lang_id)->get();
                    $options = '';
                    foreach ($langs as $lang) {
                        $options .= '<li ><a href="#" data-toggle="modal" data-target="#langedit" class="lang_ex" data-id="' . $query->id . '" data-lang_id="' . $lang->id . '"
                        style="display: block; padding: 5px 10px 10px;">' . $lang->title . '</a></li>';
                    }
                    $html = $html . '
                     <div class="btn-group">
                       <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown"  title=" ' . _i('Translation') . ' ">
                         <span class="fa fa-cogs"></span>
                       </button>
                       <ul class="dropdown-menu">
                         ' . $options . '
                       </ul>
                     </div> ';
                    return $html;
                })
                ->rawColumns([
                    'options',
                ])
                ->make(true);
        }
        $languages = Language::get();
        return view('master.site_settings.tags.index', compact('languages'));
    }
    protected function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'page_code' =>  array('required', 'max:255', 'unique:setting_tags'),
        ]);
        if ($validator->fails()) {
            return response()->json(["errors" => $validator->errors()]);
        }

        $source = SettingTags::create([
            'page_code' => $request->page_code,
            'route' => $request->route,
        ]);

        SettingTagData::create([
            'lang_id' => $request->lang_id,
            'tag_id' => $source->id,
            'keywords' => $request->meta,
            'title' => $request->title,

            "is_source" => true,
            'description' => $request->description
        ]);

        return response()->json("SUCCESS");
    }
    protected function show(Request $request, $id)
    {
        if ($request->ajax()) {
            $find =  SettingTagData::where("tag_id", $id)->where("lang_id", $request->lang_id)->first();
            if ($find == null)
                return response()->json([], 404);
            return response()->json($find, 200);
        }
    }
    protected function trans(Request $request, $id)
    {
        if ($request->ajax()) {
            $find =  SettingTagData::where("tag_id", $request->data_id)->where("lang_id", $request->lang_id)->first();
            if ($find == null) {
                SettingTagData::create([
                    'lang_id' => $request->lang_id,
                    'tag_id' => $request->data_id,
                    'keywords' => $request->keywords,
                    'title' => $request->title,

                    "is_source" => false,
                    'description' => $request->description
                ]);
            } else {
                $find->update([
                    'keywords' => $request->keywords,
                    'title' => $request->title,

                    'description' => $request->description
                ]);
            }
            return response()->json("SUCCESS");
        }
    }
    protected function update(Request $request)
    {

        $tag = SettingTags::findOrFail($request->row_id);
        $validator = Validator::make($request->all(), [
            'page_code' =>  array('required', 'max:255', Rule::unique('setting_tags')->ignore($tag->id)),
        ]);
        if ($validator->fails()) {
            return response()->json(["errors" => $validator->errors()]);
        }
        $tag->update([
            'page_code' => $request->page_code,
            'route' => $request->route,

        ]);
        $data =  $tag->Source();
        $data->update([
            'lang_id' => $request->lang_id,
            'keywords' => $request->keywords,
            'title' => $request->title,
            'description' => $request->description
        ]);
        return response()->json("SUCCESS");
    }
    protected function destroy($id)
    {
        SettingTags::destroy($id);
        return response(["data" => true]);
    }
}
