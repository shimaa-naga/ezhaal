<?php


namespace App\Http\Controllers\Master\SiteSettings;

use App\Help\Utility;
use App\Http\Controllers\Controller;
use App\Language;
use App\Models\SiteSettings\Footer;
use App\Models\SiteSettings\FooterData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class FooterController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            // $query = Footer::select("*")->orderByDesc('id');
            $query = Footer::select("*")->orderBy('order', 'asc');

            return DataTables::eloquent($query)
                ->order(function ($query) {
                    $query->orderBy('order', 'asc');
                })
                ->addColumn('footer_title', function ($query) {

                    return $query->Source()->title;
                })
                ->editColumn('created_at', function ($query) {
                    return $query->created_at = date('Y-m-d H:i:s', strtotime($query->created_at));
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
						<a href ="#" data-toggle="modal" data-target="#modal-edit" class="btn waves-effect waves-light btn-primary edit text-center" title="' . _i("Edit") . '" data-id="' . $query->id . '" >
							<i class="fa fa-edit"></i>
						</a>  &nbsp;' . '
                    	<form class="delete" action="' . route("master.footer.destroy", $query->id) . '"  method="POST" id="delform" style="display: inline-block; right: 50px;" >
                    		<input name="_method" type="hidden" value="DELETE">
                    		<input type="hidden" name="_token" value="' . csrf_token() . '">
                    		<button type="submit" class="btn btn-danger" title=" ' . _i('Delete') . ' "> <span> <i class="fa fa-trash-o"></i></span></button>
                     	</form> &nbsp;';
                    //$html .= '</div>';

                    //$langs = Language::get();
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
                    'footer_title',
                ])
                ->make(true);
        }

        $languages = Language::get();
        return view('master.site_settings.footer.index', compact('languages'));
    }

    public function store(Request $request)
    {
        //dd($request->all());
        $footer = Footer::create([
            'order' => $request->order,
        ]);
        FooterData::create([
            'title' => $request->title,
            // 'content' => $request->content_add,
            'content' => $request->get('content_add'),
            'lang_id' => $request->lang_id,
            'footer_id' => $footer->id,
            'source_id' => null,
        ]);

        return response()->json("SUCCESS");
    }

    public function update(Request $request)
    {
        // dd($request->all());
        $footer = Footer::findOrFail($request->footer_id);
        $footer->update([
            'order' => $request->order,
        ]);
        $footer_data = FooterData::where('footer_id', $footer->id)->whereNull('source_id')->first();
        $footer_data->update([
            'title' => $request->title,
            //'content' => $request->content_edit,
            'content' => $request->get('content_edit'),
            'lang_id' => $request->lang_id,
        ]);

        return response()->json("SUCCESS");
    }

    public function getLangValue(Request $request)
    {
        $rowData = FooterData::where('footer_id', $request->id)
            ->whereNotNull('source_id')
            ->first(['title', 'content']);
        if (!empty($rowData)) {
            return response()->json(['data' => $rowData]);
        } else {
            return response()->json(['data' => false]);
        }
    }

    public function storelangTranslation(Request $request)
    {
        $rowData = FooterData::where('footer_id', $request->id)
            ->whereNotNull('source_id')
            ->first();
        if ($rowData !== null) {
            $validator = Validator::make($request->all(), [
                'title' =>  array('required', 'max:255', Rule::unique('footer_data')->ignore($rowData->id)),
            ]);
            if ($validator->fails()) {
                return response()->json(["errors" => $validator->errors()]);
            }

            $rowData->update([
                'title' => $request->title,
                'content' => $request->get("content"),
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'title' =>  array('required', 'max:255', 'unique:footer_data'),
            ]);
            if ($validator->fails()) {
                return response()->json(["errors" => $validator->errors()]);
            }

            $rowParent = FooterData::where('footer_id', $request->id)->whereNull('source_id')->first();
            FooterData::create([
                'title' => $request->title,
                'content' => $request->get("content"),
                'lang_id' => $request->lang_id_data,
                'footer_id' => $request->id,
                'source_id' => $rowParent->id,
            ]);
        }
        return response()->json("SUCCESS");
    }

    public function delete($id)
    {
        $footer = Footer::destroy($id);
        FooterData::where('footer_id', $id)->delete();
        return response(["data" => true]);
    }
    protected function get($id)
    {
        $find = FooterData::join("footers", "footers.id", "footer_data.footer_id")
            ->where("footer_id", $id)->whereNull("source_id")->select("footer_data.*", "footers.order")->first();
        return response(["data" => $find, "status" => "ok"]);
    }
    public function sort(Request $request)
    {
        if ($request->ajax()) {
            if ($request->row_sort_hightId) {
                $row_id = $request->row_sort_hightId;
                $footer = Footer::find($row_id);
                $next = Footer::where('order', "<", $footer->order)->orderByDesc("order")->first(["id","order"]);
                if($next!==null)
                {
                    $old =$footer->order  ;
                    $footer->order =$next->order;
                    $footer->save();
                    $next->order =$old;
                    $next->save();
                    return response()->json(true);
                }

            } else {
                $row_id = $request->row_sort_bottomId;
                $footer = Footer::find($row_id);
                $prev = Footer::where('order', ">", $footer->order)->orderBy("order")->first(["id","order"]);
                if($prev!==null)
                {
                    $old =$footer->order  ;
                    $footer->order =$prev->order;
                    $footer->save();
                    $prev->order =$old;
                    $prev->save();
                    return response()->json(true);
                }

            }
        }
    }
}
