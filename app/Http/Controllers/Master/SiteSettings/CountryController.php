<?php


namespace App\Http\Controllers\Master\SiteSettings;


use App\Http\Controllers\Controller;
use App\Language;
use App\Models\SiteSettings\Country;
use App\Models\SiteSettings\CountryData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class CountryController extends Controller
{

    public function index()
    {
        if (request()->ajax()) {
            $query = Country::select("*")->orderByDesc('id');
            return DataTables::eloquent($query)
                ->addColumn('logo', function ($query) {
                    $logo = asset($query->logo);
                    return $query->logo != '' ? "<img class='img-thumbnail' src=".$logo." style='max-width:70px; max-hight:70px;'>" : '';
                })
                ->editColumn('created_at', function ($query){
                    return $query->created_at = date('Y-m-d H:i:s', strtotime($query->created_at));
                })
                ->addColumn('options' ,function($query) {
                    $html = '
						<a href ="#" data-toggle="modal" data-target="#modal-edit" class="btn waves-effect waves-light btn-primary edit text-center" title="'._i("Edit").'" data-id="'.$query->id.'"  data-code="'.$query->code.'" data-logo="'.$query->logo.'">
							<i class="fa fa-edit"></i>
						</a>  &nbsp;'.'
                    	<form class="delete" action="'.route("master.country.destroy",$query->id) .'"  method="POST" id="delform" style="display: inline-block; right: 50px;" >
                    		<input name="_method" type="hidden" value="DELETE">
                    		<input type="hidden" name="_token" value="' . csrf_token() . '">
                    		<button type="submit" class="btn btn-danger" title=" '._i('Delete').' "> <span> <i class="fa fa-trash-o"></i></span></button>
                     	</form>';
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
                    'logo',
                ])
                ->make(true);
        }

        $languages = Language::get();
        return view('master.country.index' , compact('languages'));
    }

    public function store(Request $request)
    {
        $country = Country::create([
            'code' => $request->code,
        ]);

        if ($request->hasFile('logo'))
        {
            $image = $request->file('logo');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = '/uploads/country/'. $country->id;
            $request->logo->move(public_path($destinationPath), $filename);
            $country->logo = $destinationPath .'/'. $filename;
            $country->save();
        }
        return response()->json("SUCCESS");
    }

    public function update(Request $request)
    {
        $country = Country::findOrFail($request->country_id);
        $country->update([
            'code' => $request->code,
        ]);
        if ($request->hasFile('logo'))
        {
            $image = $request->file('logo');
            if (File::exists(public_path($country->logo))) {
                File::delete(public_path($country->logo));
            }
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = '/uploads/country/'. $country->id;
            $request->logo->move(public_path($destinationPath), $filename);
            $country->logo = $destinationPath .'/'. $filename;
            $country->save();
        }
        return response()->json("SUCCESS");
    }

    public function getLangValue(Request $request)
    {
        $rowData = CountryData::where('country_id',$request->id)
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
        $rowData = CountryData::where('country_id',$request->id)
            ->where('lang_id', $request->lang_id_data)
            ->first();
        if ($rowData !== null){
            $validator = Validator::make($request->all(), [
                'title' =>  array('required', 'max:255', Rule::unique('country_data')->ignore($rowData->id)),
            ]);
            if ($validator->fails()) {  return response()->json(["errors" => $validator->errors()]); }

            $rowData->update([
                'title' => $request->title,
            ]);
        }else{
            $validator = Validator::make($request->all(), [
                'title' =>  array('required', 'max:255','unique:country_data'),
            ]);
            if ($validator->fails()) {  return response()->json(["errors" => $validator->errors()]); }

            CountryData::create([
                'title' => $request->title,
                'lang_id' => $request->lang_id_data,
                'country_id' => $request->id,
            ]);
        }
        return response()->json("SUCCESS");
    }

    public function delete($id)
    {
        $country = Country::findOrFail($id);
        if (File::exists(public_path($country->logo)))
        {
            File::delete(public_path($country->logo)); // delete file
            File::deleteDirectory(public_path('uploads/country/').$id); // delete folder else
        }
        CountryData::where('country_id', $country->id)->delete();
        $country->delete();
        return response(["data" => true]);
    }


    public function countryList(Request $request)
    {
        $countries = CountryData::where('lang_id' , $request->lang_id)->pluck("title","country_id");
        return $countries;
    }
}
