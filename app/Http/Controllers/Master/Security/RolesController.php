<?php

namespace App\Http\Controllers\Master\Security;

use App\Help\Utility;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\User;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;


class RolesController extends Controller
{
    public function index()
    {
        $lang_id = Utility::getLang();
        $permissions = Permission::join('permission_data', 'permissions.id', 'permission_data.permission_id')
            ->where('guard_name', 'master')
            ->where('permission_data.lang_id', $lang_id)->orderBy("permission_data.title")
            ->get();

        if (request()->ajax()) {
            $roles = Role::where('guard_name', 'master')->get();
            return DataTables::of($roles)
                ->editColumn('options', function ($query) {
                    $html = "<a href='#' class='btn btn-info edit-row' data-toggle='modal' data-target='#default-Modal' data-url='" . route('master.roles.edit', $query->id) . "' title='" . _i('Edit') . "' ><i class='fa fa-edit'></i></a> &nbsp;";
                    $html .= "<a class='btn btn-default m{{\App\Help\Utility::getLangCode() == 'ar' ? 'r' : 'l'}}-2'  href='roles/users/{$query->id}' title='" . _i('Users') . "'><i class='fa fa-users'></i></a> &nbsp;";
                    $html .= "<a href='#' class='btn btn-danger m{{\App\Help\Utility::getLangCode() == 'ar' ? 'r' : 'l'}}-2 btn-delete' data-url='" . route('master.roles.destroy', $query->id) . "' title='" . _i('Delete') . "'><i class='fa fa-trash-o'></i></a>";
                    return $html;
                })
                ->rawColumns([
                    'options',
                ])
                ->make(true);
        }
        return view('master.security.roles.index', compact('permissions'));
    }

    public function edit($id)
    {
        $role = Role::find($id);
        $permissions = $role->permissions->pluck('name');
        return ['role' => $role, 'permissions' => $permissions];
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $role = Role::create([
            'name' => $request->name,
            'guard_name' => "master",
        ]);
        $role->givePermissionTo($request->permissions);
        return response()->json('success');
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        $role = Role::find($request->id);
        $role->update([
            'name' => $request->name
        ]);
        $role->syncPermissions($request->permissions);
        return response()->json('success');
    }
    protected function getUsers($id)
    {
        $role =Role::find($id);
       // dd($role);

        $users =($role->users()->get());
       // dd($users);

        return view('master.security.roles.users',["users"=>$users]);
    }
    public function destroy($id)
    {
        Role::find($id)->delete();
        return response()->json(['data' => true]);
    }
}
