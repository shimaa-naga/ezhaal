<?php

namespace App\Http\Controllers\Master\Security;

use App\Help\Utility;
use App\Language;
use App\Models\Security\PermissionData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;
//use Yajra\Datatables\Facades\Datatables;
//use Response;

class PermissionsController extends Controller
{
	public function index()
	{
		if (request()->ajax()) {
			$permission = Permission::select('permissions.*', 'permission_data.title as title', 'permission_data.lang_id as lang_id')
                ->leftJoin('permission_data', 'permission_data.permission_id', 'permissions.id')
                ->where('permission_data.lang_id', Utility::getLang(session('locale')))
                ->where('permissions.guard_name' , "master");

			return DataTables::of($permission)
                ->addColumn('title', function ($permission) {
                    return $permission->title;
                })
                ->addColumn('lang_id', function ($permission) {
                    return $permission->lang_id;
                })
				->addColumn('action', function ($permission) {
                    $dir =(\App\Help\Utility::getLangCode() == 'ar') ? 'r' : 'l';
					$html =
                        '<button class="btn mr-1 m'.$dir.'-1 waves-effect waves-light btn-primary edit text-center" data-id ="'.$permission->id.'" data-name ="'.$permission->name.'" data-title ="'.$permission->title.'" data-lang_id ="'.$permission->lang_id.'" data-toggle="modal" data-target="#modal-edit"  title="'._i("Edit").'"><i class="fa fa-edit"></i> </button> &nbsp;' .'<a href="'.route('master.permissions.delete', $permission->id).'" data-remote="'.route('master.permissions.delete', $permission->id).'" class="btn mr-1 m'.$dir.'-1 btn-delete waves-effect waves-light btn-danger text-center" title="'._i("Delete").'"><i class=" fa fa-trash-o"></i></a>';
					$langs = Language::get();
					$options = '';
					foreach ($langs as $lang) {
						// if ($lang->id != $permission->lang_id) {
						$options .= '<li><a href="#" data-toggle="modal" data-target="#langedit" class="lang_ex" data-id="' . $permission->id . '" data-lang="' . $lang->id . '" >' . $lang->title . '</a></li>';
						// }
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
                ->rawColumns(['action'])
				->make(true);
		}
		$languages = Language::get();

		return view('master.security.permissions.permissions', compact('languages'));
	}


	public function store( Request $request )
	{
		$request->validate([
			'name' =>  array('required', 'max:255',
				Rule::unique('permissions')->where(function ($query) {
					return $query->where('guard_name', 'site');
				})
			),
			'title' =>  array('required', 'max:150'),
		]);

		$permission = Permission::create([
			'name' => $request->name,
			'guard_name' => 'master',
		]);
		PermissionData::create([
			'title' => $request->title,
			'lang_id' => Language::where('code',"ar")->first()->id,
			'permission_id' => $permission->id,
			'store_id' => null
		]);

		$role = Role::where('name', 'Master')->first();
		if($role == null){
            $role = Role::create([
                'name' => "Master",
                'guard_name' => "master",
            ]);
        }
		$role->givePermissionTo($permission->name);

		return Response::json("SUCCESS");
	}

	public function update( Request $request)
	{
		$lang_id = Language::where('code',"ar")->first()->id;

		$request->validate([
			'name' =>  array('required', 'max:255',
				Rule::unique('permissions')->ignore($request->permission_id)->where(function ($query) {
					return $query->where('guard_name', 'master');
				})
			),
			'title' =>  array('required', 'max:150'),
		]);

		$permission = Permission::findOrFail($request->permission_id);
		$permission_data = PermissionData::where('permission_id', $permission->id)
			->where('lang_id', $lang_id)
			->first();
		$permission->update([
			'name' => $request->name,
		]);
		if ($permission_data == null) {
			$permission_data = PermissionData::create([
				'title' => $request->title,
				'lang_id' => $lang_id,
			]);
		} else {
			$permission_data->update([
				'title' => $request->title,
				'lang_id' => $lang_id
			]);
		}
		return Response::json("SUCCESS");
	}

	public function delete($id)
	{
		$permission = Permission::findOrFail($id);
		PermissionData::where('permission_id', $permission->id)->delete();
		$permission->delete();
		return response()->json(['data'=>true]);
	}

	public function getLangValue(Request $request)
	{
		$rowData = PermissionData::where('permission_id', $request->transRowId)
			->where('lang_id', $request->lang_id)
			->first(['title']);
		if (!empty($rowData)) {
			return response()->json(['data' => $rowData]);
		} else {
			return response()->json(['data' => false]);
		}
	}

	public function storeTranslation(Request $request)
	{
		$rowData = PermissionData::where('permission_id', $request->id)->where('lang_id', $request->lang_id_data)->first();
		if ($rowData !== null) {
			$rowData->update([
				'title' => $request->title,
				'lang_id' => $request->lang_id_data,
			]);
		} else {
			//$parentRow = PermissionData::where('permission_id', $request->id)->first();
			PermissionData::create([
				'title' => $request->title,
				'lang_id' => $request->lang_id_data,
				'permission_id' => $request->id,
			]);
		}
		return response()->json("SUCCESS");
	}
}
