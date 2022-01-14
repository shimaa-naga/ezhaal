<?php


namespace App\Http\Controllers\Master\SiteSettings;

use App\Help\Category;
use App\Help\Utility;
use App\Http\Controllers\Controller;
use App\Models\Projects\ProjCategoryData;
use App\Models\SiteSettings\Commissions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class CommissionController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $query = Commissions::select("*")->orderByDesc('id');
            return DataTables::eloquent($query)

                ->editColumn('price', function ($query) {
                    return $query->type == "perc" ? $query->price . "%" : "+" . $query->price;
                })
                ->addColumn('category_title', function ($query) {
                    if ($query->category_id != null) {
                        $query_data = ProjCategoryData::where('category_id', $query->category_id)->where('lang_id', Utility::getLang())->first();
                        return $query_data != null ? $query_data->title : '<a href="#" class="btn btn-round btn-xs btn-default"> ' . _i('Project category not translated yet') . '</a>';
                    } else {
                        return  '<a href="#" class="btn btn-round btn-xs btn-default"> ' . _i('No Category Selected') . '</a>';
                    }
                })
                ->addColumn('options', function ($query) {
                    $html = '
                    <a href ="#" data-toggle="modal" data-target="#modal-edit" class="btn waves-effect waves-light btn-primary edit text-center" title="' . _i("Edit") . '"
						data-commissionid="' . $query->id . '" data-title="' . $query->title . '"  data-type="' . $query->type . '" data-categoryid="' . $query->category_id . '"
						data-price="' . $query->price . '" data-code="' . $query->code . '"  >
							<i class="fa fa-edit"></i>
						</a>  &nbsp;' . '
                    	<form class="delete" action="' . route("master.commission.destroy", $query->id) . '"  method="POST" id="delform" style="display: inline-block; right: 50px;" >
                    		<input name="_method" type="hidden" value="DELETE">
                    		<input type="hidden" name="_token" value="' . csrf_token() . '">
                    		<button type="submit" class="btn btn-danger" title=" ' . _i('Delete') . ' "> <span> <i class="fa fa-trash-o"></i></span></button>
                     	</form> &nbsp;';
                    $html .= '</div>';
                    return $html;
                })
                ->rawColumns([
                    'category_title',
                    'options',
                ])
                ->make(true);
        }

        $obj = new Category();
        $obj->publish = 1;

        $categories= $obj->getAllTreeArray();
        $categories= json_decode(json_encode($categories));
       // dd(json_decode(json_encode($categories)));
        //$categories = ProjCategoryData::where('lang_id', Utility::getLang())->get();
       // dd($categories);

        return view('master.commissions.index', compact('categories'));
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' =>  array('nullable', 'max:50', 'unique:commissions'),
        ]);
        if ($validator->fails()) {
            return response()->json(["errors" => $validator->errors()]);
        }
        Commissions::create([
            'title' => $request->title,
            'type' => $request->type,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'code' => $request->code,
        ]);
        return response()->json("SUCCESS");
    }


    public function update(Request $request)
    {
        $commission = Commissions::findOrFail($request->row_id);
        $validator = Validator::make($request->all(), [
            'code' =>  array('nullable', 'max:50', Rule::unique('commissions')->ignore($commission->id)),
        ]);
        if ($validator->fails()) {
            return response()->json(["errors" => $validator->errors()]);
        }
        $commission->update([
            'title' => $request->title,
            'type' => $request->type,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'code' => $request->code,
        ]);
        return response()->json("SUCCESS");
    }

    public function delete($id)
    {
        $query = Commissions::destroy($id);
        return response(["data" => true]);
    }
}
