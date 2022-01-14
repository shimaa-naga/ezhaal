<?php

namespace App\Http\Controllers\Master\SiteSettings;

use App\Http\Controllers\Controller;
use App\Language;
use App\Models\SiteSettings\Sliders;
use App\Models\SiteSettings\SlidersData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class SliderController extends Controller
{
    public function _index()
    {
        if (request()->ajax()) {
            $query = Sliders::select("*");
            return DataTables::eloquent($query)
                ->addColumn('image', function ($query) {
                    $image = asset($query->image);
                    return $query->image != '' ? "<img class='img-thumbnail' src=" . $image . " style='max-width:150px; max-hight:150px;'>" : '';
                })
                ->editColumn('created_at', function ($query) {
                    return $query->created_at = date('Y-m-d H:i:s', strtotime($query->created_at));
                })
                ->editColumn('status', function ($query) {
                    if ($query->status == 0) {
                        //return "<input type='checkbox' class='js-switch-table' name='status'>";
                        return '<a href="#" class="btn btn-round btn-xs btn-default"> ' . _i('Not Published') . '</a>';
                    } else {
                        //return "<input type='checkbox' class='js-switch-table' name='status' checked>";
                        return '<a href="#" class="btn btn-round btn-xs btn-success"> ' . _i('Published') . '</a>';
                    }
                })
                ->addColumn('options', function ($query) {
                    $html = '
						<a href ="#" data-toggle="modal" data-target="#modal-edit" class="btn waves-effect waves-light btn-primary edit text-center" title="' . _i("Edit") . '" data-id="' . $query->id . '"  data-url="' . $query->url . '" data-status="' . $query->status . '" data-image="' . $query->image . '">
							<i class="fa fa-edit"></i>
						</a>  &nbsp;' . '
                    	<form class="delete" action="' . route("master.sliders.destroy", $query->id) . '"  method="POST" id="delform" style="display: inline-block; right: 50px;" >
                    		<input name="_method" type="hidden" value="DELETE">
                    		<input type="hidden" name="_token" value="' . csrf_token() . '">
                    		<button type="submit" class="btn btn-danger" title=" ' . _i('Delete') . ' "> <span> <i class="fa fa-trash-o"></i></span></button>
                     	</form>';
                    $html .= '';

                    $langs = Language::get();
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
                    'image',
                    'status',
                ])
                ->make(true);
        }

        $languages = Language::get();
        return view('master.sliders.index', compact('languages'));
    }
    protected function index()
    {
        $limit = 10;
        $sliders =  Sliders::select("*")->paginate($limit);
        if (request()->ajax()) {

            return view('master.sliders.ajax', compact('sliders'))->render();
        }

        return view('master.sliders.index', compact('sliders'));
    }

    public function store(Request $request)
    {
        $slider = Sliders::create([
            'url' => $request->url,
            'status' => $request->status ? 1 : 0,
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = '/uploads/sliders/' . $slider->id;
            $request->image->move(public_path($destinationPath), $filename);
            $slider->image = $destinationPath . '/' . $filename;
            $slider->save();
        }
        return response()->json("SUCCESS");
    }

    public function update(Request $request)
    {
        $slider = Sliders::findOrFail($request->slider_id);
        $slider->update([
            'url' => $request->url,
            'status' => $request->status ? 1 : 0,
        ]);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            if (File::exists(public_path($slider->image))) {
                File::delete(public_path($slider->image));
            }
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = '/uploads/sliders/' . $slider->id;
            $request->image->move(public_path($destinationPath), $filename);
            $slider->image = $destinationPath . '/' . $filename;
            $slider->save();
        }
        return response()->json("SUCCESS");
    }

    public function getLangValue(Request $request)
    {
        $rowData = SlidersData::where('slider_id', $request->id)
            ->where('lang_id', $request->lang_id)
            ->first(['title', 'description']);
        if (!empty($rowData)) {
            return response()->json(['data' => $rowData]);
        } else {
            return response()->json(['data' => false]);
        }
    }

    public function storelangTranslation(Request $request)
    {
        $rowData = SlidersData::where('slider_id', $request->id)
            ->where('lang_id', $request->lang_id_data)
            ->first();
        if ($rowData !== null) {
            $rowData->update([
                'title' => $request->title,
                'description' => $request->description,
            ]);
        } else {
            SlidersData::create([
                'title' => $request->title,
                'description' => $request->description,
                'lang_id' => $request->lang_id_data,
                'slider_id' => $request->id,
            ]);
        }
        return response()->json("SUCCESS");
    }

    public function delete($id)
    {
        $slider = Sliders::findOrFail($id);
        if (File::exists(public_path($slider->image))) {
            File::delete(public_path($slider->image)); // delete file
            File::deleteDirectory(public_path('uploads/sliders/') . $id); // delete folder else
        }
        SlidersData::where('slider_id', $slider->id)->delete();
        $slider->delete();
        return response(["data" => true]);
    }
}
