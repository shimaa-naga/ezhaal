<?php


namespace App\Http\Controllers\Master\Security;

use App\Http\Controllers\Controller;
use App\MasterUsers;
use App\Site;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class AdminController extends Controller
{

    public function index()
    {
        if (request()->ajax()) {

            $admin = MasterUsers::get();

            return DataTables::of($admin)
                ->addColumn('image', function ($admin) {
                    if( empty( $admin->image) ) return;
                    //$url = asset('/uploads/master_users/' . $admin->id . '/' . $admin->image);
                    $url = asset($admin->image);
                    return '<img src=' . $url . ' class="img-thumbnail" align="center">';
                })
                ->addColumn('options', function ($admin) {
                    return '<a href="'.route('master.admins.edit', $admin->id).'" class="btn btn-primary edit" title="'._i("Edit").'"><i class="fa fa-edit"></i></a>
                        <a href="#" data-url="'.route('master.admins.destroy', $admin->id).'" class="btn btn-delete btn-danger" title="'._i("Delete").'"><i class="fa fa-trash-o"></i></a>';
                })
                ->rawColumns([
                    'image',
                    'options',
                ])
                ->make(true);
        }
        return view('master.security.admins.index');
    }

    public function create()
    {
        $roles =  Role::where('guard_name' , "master")->get();
        return view('master.security.admins.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $rules =  [
            'name' => ['required', 'string', 'max:255', 'min:3'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'role' => ['required'],
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            $user = MasterUsers::create([
                'name' => $request->name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'mobile' => $request->phone,
                'password' => Hash::make($request->password),
                'is_active' => 1,
                'guard' => "master"
            ]);

            $role = Role::where('id' , $request->role)->first();
            $permissions = $role->load('permissions');
            $user->assignRole($role['id']);

            foreach ($permissions->permissions as $perm)
            {
                $user->givePermissionTo($perm['name']);
                $user->save();
            }

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $destinationPath = '/uploads/master_users/'. $user->id;
                $filename = time() . '.' . $image->getClientOriginalExtension();
                $request->image->move(public_path($destinationPath), $filename);

                $user->image = $destinationPath . '/' . $filename;
                $user->save();
            }

            return redirect()->back()->with('success' ,_i('Saved Successfully !'));
        }
    }

    public function edit($id)
    {
        $user = MasterUsers::findOrFail($id);
        $roles = Role::where('guard_name' , "master")->get();
        return view('master.security.admins.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $user = MasterUsers::findOrFail($id);
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($id)],
            'roles' => ['sometimes', 'min:1']
        ]);

        $user->update([
            'name' => $request->input('name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'mobile' => $request->input('mobile'),
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $destinationPath = '/uploads/master_users/'. $user->id;
            if (File::exists(public_path($user->image))) {
                File::delete(public_path($user->image));
            }
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $request->image->move(public_path($destinationPath), $filename);
            $user->image = $destinationPath.'/'. $filename;
            $user->save();
        }

        if($request->has('role'))
        {
            $user->syncRoles($request->role);
        }

        return redirect()->back()->with( 'success',_i('Saved Successfully !'));
    }

    public function destroy($id)
    {
        $user = MasterUsers::findOrFail($id);
        if($user->hasAnyRole(Role::all()) || $user->hasAnyPermission(Permission::all()))
        {
            $roles = $user->getRoleNames();
            $permissions = $user->getPermissionsViaRoles($roles);
            foreach($permissions as $permission)
            {
                $user->revokePermissionTo($permission);
            }
            foreach($roles as $role)
            {
                $user->removeRole($role);
            }
        }
        $user->delete();
        return response()->json(['data'=>true]);
    }


    public function changePassword(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $rules = [
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator);
        }
        $user->password = Hash::make($request->input('password'));
        $user->save();
        return response()->json(['data'=>true]);
    }

    public function changeStatus(Request $request)
    {
        //dd($request->all());
        $user = User::findOrFail($request->user_id);
        $user->is_active = $request->user_status;
        $user->save();
        return response()->json($user);
    }
}
