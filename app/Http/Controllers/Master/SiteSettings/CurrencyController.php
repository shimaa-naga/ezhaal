<?php
namespace App\Http\Controllers\Master\SiteSettings;
use App\Http\Controllers\Controller;
use App\Models\SiteSettings\Currency;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Boolean;
use Yajra\DataTables\Facades\DataTables;

class CurrencyController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $query = Currency::select("*")->orderBy('code');

            return DataTables::eloquent($query)
                ->addColumn("active",function($query){
                    $checked = ($query->active)? "checked" : "";

                    return '<label class="switch"><input onclick="status(this,'.$query->id.')" name="status" type="checkbox" '.$checked.'><span class="slider round"></span>
                  </label>';
                })
                ->editColumn('created_at', function ($query){
                    return $query->created_at = date('Y-m-d H:i:s', strtotime($query->created_at));
                })->addColumn('options' ,function($query) {
                    $html = '
						<a href ="#" data-toggle="modal" data-target="#modal-edit" class="btn waves-effect waves-light btn-primary edit text-center" title="'._i("Edit").'" data-id="'.$query->id.'" data-code="'.$query->code.'" data-rate="'.$query->rate.'">
							<i class="fa fa-edit"></i>
						</a>  &nbsp;'.'
                    	<form class="delete"   method="POST" action="currency/'.$query->id.'" style="display: inline-block; right: 50px;" >
                    		<input name="_method" type="hidden" value="DELETE">
                    		<input type="hidden" name="_token" value="' . csrf_token() . '">
                    		<button type="submit" class="btn btn-danger" title=" '._i('Delete').' "> <span> <i class="fa fa-trash-o"></i></span></button>
                     	</form> &nbsp;';
                    $html .= '</div>';



                    return $html;
                })
                ->rawColumns([
                    'options',
                    'country_id',
                    'city_title',
                    'active'
                ])
                ->make(true);
        }


        return view('master.currency.index' );
    }
    protected function store()
    {
        $request =request();
        Currency::create([
            'code' => $request->code,
            "rate" => $request->rate,
        ]);

        return response()->json("SUCCESS");
    }
    protected function status($id)
    {
        $request =request();
        $find =Currency::find($id);
        $bol =filter_var( $request->input("status"),FILTER_VALIDATE_BOOLEAN);

        $find->active =$bol ;
        $find->save();



        return response()->json("SUCCESS");
    }
    protected function destroy($id)
    {
        Currency::destroy($id);

        return response(["data" => true]);
    }
    protected function update( $id,Request $request)
    {
        $item =Currency::find($id);

        if($item!=null)
        {
            $item->update(["code" => request("code"),
            "rate" => request("rate")]);
        }

        return response()->json("SUCCESS");
    }
}
