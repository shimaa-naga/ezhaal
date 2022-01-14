<?php


namespace App\Http\Controllers\Master\SiteSettings;
use App\Help\Utility;
use App\Http\Controllers\Controller;
use App\Language;
use App\Models\SiteSettings\City;
use App\Models\SiteSettings\CityData;
use App\Models\SiteSettings\CountryData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class CityController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $query = City::select("*")->orderByDesc('id');

            return DataTables::eloquent($query)

                ->addColumn('city_title', function ($query) {

                    return $query->Source()->title ;
                })
                ->editColumn('created_at', function ($query){
                    return $query->created_at = date('Y-m-d H:i:s', strtotime($query->created_at));
                })->editColumn('country_id', function ($query){
                    $country_data = CountryData::where('country_id',$query->country_id)->where('lang_id', Utility::getLang())->first();
                    return $country_data != null ? $country_data->title : '<a href="#" class="btn btn-round btn-xs btn-default"> '._i('Country not translated yet').'</a>';
                })
                ->addColumn('options' ,function($query) {
                    $html = '
						<a href ="#" data-toggle="modal" data-target="#modal-edit" class="btn waves-effect waves-light btn-primary edit text-center" title="'._i("Edit").'" data-id="'.$query->id.'"  data-countryid="'.$query->country_id.'"
						data-title="'.$query->Source()->title.'" data-lang="'.$query->Source()->lang_id.'">
							<i class="fa fa-edit"></i>
						</a>  &nbsp;'.'
                    	<form class="delete" action="'.route("master.city.destroy",$query->id) .'"  method="POST" id="delform" style="display: inline-block; right: 50px;" >
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
                    'country_id',
                    'city_title',
                ])
                ->make(true);
        }

        $languages = Language::get();
        $countries_data = CountryData::where('lang_id', Utility::getLang())->get();
        return view('master.city.index' , compact('languages','countries_data'));
    }

    public function store(Request $request)
    {
        $city = City::create([
            'country_id' => $request->country_id,
        ]);
        CityData::create([
            'title' => $request->title,
            'lang_id' => $request->lang_id,
            'city_id' => $city->id,
            'source_id' => null,
        ]);
        return response()->json("SUCCESS");
    }

    public function update(Request $request)
    {
        $city = City::findOrFail($request->city_id);
        $city->update([
            'country_id' => $request->country_id,
        ]);
        $city_data = CityData::where('city_id', $city->id)->whereNull('source_id')->first();
        $city_data->update([
            'title' => $request->title,
            'lang_id' => $request->lang_id,
        ]);
        return response()->json("SUCCESS");
    }

    public function getLangValue(Request $request)
    {
        $rowData = CityData::where('city_id',$request->id)
            //->where('lang_id',$request->lang_id)
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
        $rowData = CityData::where('city_id',$request->id)
           // ->where('lang_id', $request->lang_id_data)
            ->whereNotNull('source_id')
            ->first();
        if ($rowData !== null){
            $validator = Validator::make($request->all(), [
                'title' =>  array('required', 'max:255', Rule::unique('city_data')->ignore($rowData->id)),
            ]);
            if ($validator->fails()) {  return response()->json(["errors" => $validator->errors()]); }

            $rowData->update([
                'title' => $request->title,
            ]);
        }else{
            $validator = Validator::make($request->all(), [
                'title' =>  array('required', 'max:255','unique:city_data'),
            ]);
            if ($validator->fails()) {  return response()->json(["errors" => $validator->errors()]); }

            $rowParent = CityData::where('city_id', $request->id)->whereNull('source_id')->first();
            CityData::create([
                'title' => $request->title,
                'lang_id' => $request->lang_id_data,
                'city_id' => $request->id,
                'source_id' => $rowParent->id,
            ]);
        }
        return response()->json("SUCCESS");
    }

    public function delete($id)
    {
        $city = City::destroy($id);
        CityData::where('city_id', $id)->delete();
        return response(["data" => true]);
    }
}
