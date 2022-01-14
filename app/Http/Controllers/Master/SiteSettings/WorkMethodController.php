<?php


namespace App\Http\Controllers\Master\SiteSettings;
use App\Http\Controllers\Controller;
use App\Language;
use App\Models\SiteSettings\WorkMethod;
use App\Models\SiteSettings\WorkMethodData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class WorkMethodController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            // $query = Footer::select("*")->orderByDesc('id');
            $query = WorkMethod::select("*")->orderBy('order', 'asc');

            return DataTables::eloquent($query)
                ->order(function ($query) {
                    $query->orderBy('order', 'asc');
                })
                ->addColumn('work_title', function ($query) {

                    return $query->Source()->title;
                })
                ->editColumn('created_at', function ($query) {
                    return $query->created_at = date('Y-m-d H:i:s', strtotime($query->created_at));
                })
                ->editColumn('icon', function ($query) {
                    $html = '<a href="#" class="btn btn-primary"><i class="'.$query->icon.'"></i></a>';
                    return $html;
                })
                ->editColumn('order', function ($query) {
                    $html = '<div class="pull-right">
                            <a href="javascript:void(0)" class="btn btn-icon sort_hight" data-id="' . $query['id'] . '" title="' . _i("Up") . '">
							<i class="fa fa-long-arrow-up"></i></a>' .$query->order. '
							<a href="javascript:void(0)" class="btn btn-icon sort_bottom" data-id="' . $query['id'] . '" title="' . _i("Down") . '">
							<i class="fa fa-long-arrow-down"></i></a>';
                    return $html;
                })
                ->addColumn('options', function ($query) {
                    $html = '
						<a href ="#" data-toggle="modal" data-target="#modal-edit" class="btn waves-effect waves-light btn-primary edit text-center" title="' . _i("Edit") . '"
						data-id="'.$query->id.'" data-order="'.$query->order.'" data-icon="'.$query->icon.'" data-title="'.$query->Source()->title.'"
						data-description="'.$query->Source()->description.'" data-lang="'.$query->Source()->lang_id.'">
							<i class="fa fa-edit"></i>
						</a>  &nbsp;' . '
                    	<form class="delete" action="' . route("master.work_method.destroy", $query->id) . '"  method="POST" id="delform" style="display: inline-block; right: 50px;" >
                    		<input name="_method" type="hidden" value="DELETE">
                    		<input type="hidden" name="_token" value="' . csrf_token() . '">
                    		<button type="submit" class="btn btn-danger" title=" ' . _i('Delete') . ' "> <span> <i class="fa fa-trash-o"></i></span></button>
                     	</form> &nbsp;';

                    $langs = Language::where("id", "!=", $query->Source()->lang_id)->get();
                    $options = '';
                    foreach ($langs as $lang) {
                        $options .= '<li ><a href="#" data-toggle="modal" data-target="#langedit" class="lang_ex" data-id="' . $query->id . '" data-lang="' . $lang->id . '" data-title="' . $lang->title . '"
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
                    'order',
                    'icon',
                    'work_title',
                ])
                ->make(true);
        }

        $languages = Language::get();
        return view('master.site_settings.work_method.index', compact('languages'));
    }

    public function store(Request $request)
    {
        //dd($request->all());
        $work_method = WorkMethod::create([
            'order' => $request->order,
            'icon' => $request->icon,
        ]);
        WorkMethodData::create([
            'title' => $request->title,
            'description' => $request->description,
            'lang_id' => $request->lang_id,
            'work_method_id' => $work_method->id,
            'source_id' => null,
        ]);

        return response()->json("SUCCESS");
    }

    public function update(Request $request)
    {
        // dd($request->all());
        $work_method = WorkMethod::findOrFail($request->work_method_id);
        $work_method->update([
            'order' => $request->order,
            'icon' => $request->icon,
        ]);
        $work_method_data = WorkMethodData::where('work_method_id', $work_method->id)->whereNull('source_id')->first();
        $work_method_data->update([
            'title' => $request->title,
            'description' => $request->description,
            'lang_id' => $request->lang_id,
        ]);

        return response()->json("SUCCESS");
    }

    public function getLangValue(Request $request)
    {
        $rowData = WorkMethodData::where('work_method_id', $request->id)
            ->whereNotNull('source_id')
            ->first(['title', 'description']);
        if (!empty($rowData)) {
            return response()->json(['data' => $rowData]);
        } else {
            return response()->json(['data' => false]);
        }
    }

    public function storelangTranslation(Request $request)
    {
        $rowData = WorkMethodData::where('work_method_id', $request->id)
            ->whereNotNull('source_id')
            ->first();
        if ($rowData !== null) {
            $validator = Validator::make($request->all(), [
                'title' =>  array('required', 'max:255', Rule::unique('work_method_data')->ignore($rowData->id)),
            ]);
            if ($validator->fails()) {
                return response()->json(["errors" => $validator->errors()]);
            }

            $rowData->update([
                'title' => $request->title,
                'description' => $request->description,
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'title' =>  array('required', 'max:255', 'unique:work_method_data'),
            ]);
            if ($validator->fails()) {
                return response()->json(["errors" => $validator->errors()]);
            }

            $rowParent = WorkMethodData::where('work_method_id', $request->id)->whereNull('source_id')->first();
            WorkMethodData::create([
                'title' => $request->title,
                'description' => $request->description,
                'lang_id' => $request->lang_id_data,
                'work_method_id' => $request->id,
                'source_id' => $rowParent->id,
            ]);
        }
        return response()->json("SUCCESS");
    }

    public function delete($id)
    {
        $work_method = WorkMethod::destroy($id);
        WorkMethodData::where('work_method_id', $id)->delete();
        return response(["data" => true]);
    }

    public function sort(Request $request)
    {
       // dd($request->all());
        if ($request->ajax()) {
            if ($request->row_sort_hightId) {
                $row_id = $request->row_sort_hightId;
                $work_method = WorkMethod::find($row_id);
                $next = WorkMethod::where('order', "<", $work_method->order)->orderByDesc("order")->first(["id","order"]);
                if($next!==null)
                {
                    $old =$work_method->order  ;
                    $work_method->order =$next->order;
                    $work_method->save();
                    $next->order =$old;
                    $next->save();
                    return response()->json(true);
                }

            } else {
               // dd($request->row_sort_bottomId);
                $row_id = $request->row_sort_bottomId;
                $work_method = WorkMethod::find($row_id);
                $prev = WorkMethod::where('order', ">", $work_method->order)->orderBy("order")->first(["id","order"]);
                if($prev!==null)
                {
                    $old =$work_method->order  ;
                    $work_method->order =$prev->order;
                    $work_method->save();
                    $prev->order =$old;
                    $prev->save();
                    return response()->json(true);
                }

            }
        }
    }
}
