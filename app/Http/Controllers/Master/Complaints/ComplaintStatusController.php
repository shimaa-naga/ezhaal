<?php


namespace App\Http\Controllers\Master\Complaints;
use App\Help\Utility;
use App\Http\Controllers\Controller;
use App\Language;
use App\Models\Complaints\ComplaintStatus;
use App\Models\Complaints\ComplaintStatusData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class ComplaintStatusController extends Controller
{

    public function index()
    {
        if (request()->ajax()) {

            $query = ComplaintStatus::select("*")->orderByDesc('id');

            return DataTables::eloquent($query)

                ->addColumn('title', function ($query) {

                    return $query->Source()->title ;
                })
                ->editColumn('created_at', function ($query){
                    return $query->created_at = date('Y-m-d H:i:s', strtotime($query->created_at));
                })
                ->addColumn('options' ,function($query) {
                    $html = '
						<a href ="#" data-toggle="modal" data-target="#modal-edit" class="btn waves-effect waves-light btn-primary edit text-center" title="'._i("Edit").'" data-id="'.$query->id.'"
						data-title="'.$query->Source()->title.'" data-lang="'.$query->Source()->lang_id.'">
							<i class="fa fa-edit"></i>
						</a>  &nbsp;'.'
                    	<form class="delete" action="'.url("master/complaint/status/".$query->id).'"  method="POST" id="delform" style="display: inline-block; right: 50px;" >
                    		<input name="_method" type="hidden" value="DELETE">
                    		<input type="hidden" name="_token" value="' . csrf_token() . '">
                    		<button type="submit" class="btn btn-danger" title=" '._i('Delete').' "> <span> <i class="fa fa-trash-o"></i></span></button>
                     	</form> &nbsp;';
                    $html .= '</div>';

                    //$langs = Language::get();
                    $langs = Language::where("id","!=",$query->Source()->lang_id)->get();
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

                ])
                ->make(true);
        }

         $languages = Language::get();
        // $countries_data = CountryData::where('lang_id', Utility::getLang())->get();
        return view('master.complaints.status.index' , compact('languages'));
    }

    public function store(Request $request)
    {
        $item = ComplaintStatus::create();
        ComplaintStatusData::create([
            'title' => $request->title,
            'lang_id' => $request->lang_id,
            'status_id' => $item->id,
            'source_id' => null,
        ]);
        return response()->json("SUCCESS");
    }

    public function update(Request $request,$id)
    {


        $complaint_status_data = ComplaintStatusData::where('status_id',$id)->whereNull('source_id')->first();
        $complaint_status_data->update([
            'title' => $request->title,

        ]);
        return response()->json("SUCCESS");
    }

    public function getLangValue(Request $request)
    {
        $rowData = ComplaintStatusData::where('status_id',$request->id)

            ->whereNotNull('source_id')
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
        $rowData = ComplaintStatusData::where('status_id',$request->id)
           // ->where('lang_id', $request->lang_id_data)
            ->whereNotNull('source_id')
            ->first();
        if ($rowData !== null){
            $validator = Validator::make($request->all(), [
                'title' =>  array('required', 'max:255', Rule::unique('complaint_status_data')->ignore($rowData->id)),
            ]);
            if ($validator->fails()) {  return response()->json(["errors" => $validator->errors()]); }

            $rowData->update([
                'title' => $request->title,
            ]);
        }else{
            $validator = Validator::make($request->all(), [
                'title' =>  array('required', 'max:255','unique:complaint_status_data'),
            ]);
            if ($validator->fails()) {  return response()->json(["errors" => $validator->errors()]); }

            $rowParent = ComplaintStatusData::where('status_id', $request->id)->whereNull('source_id')->first();
         //   dd($rowParent);
            ComplaintStatusData::create([
                'title' => $request->title,
                'lang_id' => $request->lang_id_data,
                'status_id' => $request->id,
                'source_id' => $rowParent->id,
            ]);
        }
        return response()->json("SUCCESS");
    }

    public function destroy($id)
    {
        $city = ComplaintStatus::destroy($id);
        ComplaintStatusData::where('status_id', $id)->delete();
        return response(["data" => true]);
    }
}
