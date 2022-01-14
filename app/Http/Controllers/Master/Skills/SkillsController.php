<?php


namespace App\Http\Controllers\Master\Skills;
use App\Help\Utility;
use App\Http\Controllers\Controller;
use App\Language;
use App\Models\Skills\Skills;
use App\Models\Skills\SkillsData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class SkillsController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $query = Skills::select("*")->orderByDesc('id');
            return DataTables::eloquent($query)
                ->addColumn('skill_title', function ($query) {
                    $query_data = SkillsData::where('skill_id', $query->id)->where('lang_id', Utility::getLang())->first();
                    return $query_data != null ? $query_data->title : '<a href="#" class="btn btn-round btn-xs btn-default"> '._i('Skill not translated yet').'</a>' ;
                })
                ->editColumn('created_at', function ($query){
                    return $query->created_at = date('Y-m-d H:i:s', strtotime($query->created_at));
                })
                ->addColumn('options' ,function($query) {
                    $html = '
                    	<form class="delete" action="'.route("master.skills.destroy",$query->id) .'"  method="POST" id="delform" style="display: inline-block; right: 50px;" >
                    		<input name="_method" type="hidden" value="DELETE">
                    		<input type="hidden" name="_token" value="' . csrf_token() . '">
                    		<button type="submit" class="btn btn-danger" title=" '._i('Delete').' "> <span> <i class="fa fa-trash-o"></i></span></button>
                     	</form> &nbsp;';
                    $html .= '</div>';

                    $langs = Language::get();
                    $options = '';
                    foreach ($langs as $lang) {
                        $options .= '<li ><a href="#" data-toggle="modal" data-target="#langedit" class="lang_ex" data-id="'.$query->id.'" data-lang="'.$lang->id.'" data-title="'.$lang->title.'"
                        style="display: block; padding: 5px 10px 10px;">'.$lang->title.'</a></li>';
                    }
                    $html = $html.'
                     <div class="btn-group">
                       <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown"  title=" '._i('Translation').' ">
                         <span class="fa fa-cogs"></span>
                       </button>
                       <ul class="dropdown-menu">
                         '.$options.'
                       </ul>
                     </div> ';

                    return $html;
                })
                ->rawColumns([
                    'options',
                    'skill_title',
                ])
                ->make(true);
        }

        $languages = Language::get();
        return view('master.skills.index' , compact('languages'));
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' =>  array('required', 'max:255','unique:skill_data'),
        ]);
        if ($validator->fails()) {  return response()->json(["errors" => $validator->errors()]); }
        $skill = Skills::create([]);
        $skill_data = SkillsData::create([
            'skill_id' => $skill->id,
            'title' => $request->title,
            'lang_id' => $request->lang_id ?? Utility::getLang(),
        ]);
        return response()->json("SUCCESS");
    }

    public function getLangValue(Request $request)
    {
        $rowData = SkillsData::where('skill_id',$request->id)
            ->where('lang_id',$request->lang_id)
            ->first(['title']);
        if (!empty($rowData))
        {
            return response()->json(['data' => $rowData]);
        }else{
            return response()->json(['data' => false]);
        }
    }

    public function storelangTranslation(Request $request)
    {
        $rowData = SkillsData::where('skill_id',$request->id)
            ->where('lang_id', $request->lang_id_data)
            ->first();
        if ($rowData !== null){
            $validator = Validator::make($request->all(), [
                'title' =>  array('required', 'max:255', Rule::unique('skill_data')->ignore($rowData->id)),
            ]);
            if ($validator->fails()) {  return response()->json(["errors" => $validator->errors()]); }

            $rowData->update([
                'title' => $request->title,
            ]);
        }else{
            $validator = Validator::make($request->all(), [
                'title' =>  array('required', 'max:255','unique:complaint_type_data'),
            ]);
            if ($validator->fails()) {  return response()->json(["errors" => $validator->errors()]); }

            SkillsData::create([
                'skill_id' => $request->id,
                'title' => $request->title,
                'lang_id' => $request->lang_id_data,
            ]);
        }
        return response()->json("SUCCESS");
    }

    public function delete($id)
    {
        $query = Skills::destroy($id);
        return response(["data" => true]);
    }
}
