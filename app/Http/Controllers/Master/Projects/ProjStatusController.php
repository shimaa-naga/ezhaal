<?php


namespace App\Http\Controllers\Master\Projects;
use App\Help\Utility;
use App\Http\Controllers\Controller;
use App\Language;
use App\Models\Projects\ProjStatus;
use App\Models\Projects\ProjStatusData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class ProjStatusController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $query = ProjStatus::select("*")->orderByDesc('id');
            return DataTables::eloquent($query)
                ->editColumn('created_at', function ($query){
                    return $query->created_at = date('Y-m-d H:i:s', strtotime($query->created_at));
                })
                ->addColumn('options' ,function($query) {
                    $html = '
                    <a href ="#" data-toggle="modal" data-target="#modal-edit" class="btn waves-effect waves-light btn-primary edit text-center" title="'._i("Edit").'"
						data-statusid="'.$query->id.'" data-title="'.$query->title.'" >
							<i class="fa fa-edit"></i>
						</a>  &nbsp;'.'
                    	<form class="delete" action="'.route("master.proj_status.destroy",$query->id) .'"  method="POST" id="delform" style="display: inline-block; right: 50px;" >
                    		<input name="_method" type="hidden" value="DELETE">
                    		<input type="hidden" name="_token" value="' . csrf_token() . '">
                    		<button type="submit" class="btn btn-danger" title=" '._i('Delete').' "> <span> <i class="fa fa-trash-o"></i></span></button>
                     	</form> &nbsp;';
                    $html .= '</div>';
                    return $html;
                })
                ->rawColumns([
                    'options',
                ])
                ->make(true);
        }
        return view('master.projects.proj_status.index');
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' =>  array('required', 'max:255','unique:proj_status'),
        ]);
        if ($validator->fails()){
            return response()->json(["errors" => $validator->errors()]);
        }
        $status = ProjStatus::create(['title' => $request->title]);
        return response()->json("SUCCESS");
    }


    public function update(Request $request)
    {
        $status = ProjStatus::findOrFail($request->row_id);
        $validator = Validator::make($request->all(), [
            'title' =>  array('required', 'max:255', Rule::unique('proj_status')->ignore($status->id)),
        ]);
        if ($validator->fails()){
            return response()->json(["errors" => $validator->errors()]);
        }
        $status->update([
            'title' => $request->title,
        ]);
        return response()->json("SUCCESS");
    }

    public function delete($id)
    {
        $query = ProjStatus::destroy($id);
        return response(["data" => true]);
    }



}
