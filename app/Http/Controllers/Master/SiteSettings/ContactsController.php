<?php


namespace App\Http\Controllers\Master\SiteSettings;
use App\Http\Controllers\Controller;
use App\Models\SiteSettings\Contacts;
use Yajra\DataTables\Facades\DataTables;

class ContactsController extends Controller
{

    public function index()
    {
        if (request()->ajax()) {
            $query = Contacts::select("*")->orderByDesc('id');
            return DataTables::eloquent($query)
                ->editColumn('created_at', function ($query){
                    return $query->created_at = date('Y-m-d H:i:s', strtotime($query->created_at));
                })
                ->addColumn('options' ,function($query) {
                    $html = '
                    <a href ="'.route("master.contact.show",$query->id) .'" class="btn waves-effect waves-light btn-primary edit text-center"
                    title="'._i("Show Message").'"> <i class="fa fa-eye"></i> </a>  &nbsp;'.'
                    	<form class="delete" action="'.route("master.contact.destroy",$query->id) .'"  method="POST" id="delform" style="display: inline-block; right: 50px;" >
                    		<input name="_method" type="hidden" value="DELETE">
                    		<input type="hidden" name="_token" value="' . csrf_token() . '">
                    		<button type="submit" class="btn btn-danger" title=" '._i('Delete').' "> <span> <i class="fa fa-trash-o"></i></span></button>
                     	</form> &nbsp;';

                    return $html;
                })
                ->rawColumns([
                    'options',
                ])
                ->make(true);
        }

        return view('master.site_settings.contacts.index');
    }

    public function show($id)
    {
        $contact = Contacts::findOrFail($id);
        return view('master.site_settings.contacts.show', compact('contact'));
    }


    public function delete($id)
    {
        Contacts::destroy($id);
        if (request()->ajax()){
            return response(["data" => true]);
        }else{
            return redirect()->route('master.contact.index')->with('success', _i('Deleted Successfully'));
        }
    }
}
