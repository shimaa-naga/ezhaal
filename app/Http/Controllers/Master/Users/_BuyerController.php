<?php

namespace App\Http\Controllers\Master\Users;

use App\Help\Constants\UserType;
use App\Http\Controllers\Controller;
use App\User;
use App\WebsiteUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class BuyerController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $query = WebsiteUser::Providers()->where('account_type', UserType::USER)->orderByDesc('id')->get();
            return DataTables::of($query)
                ->addColumn('image', function ($query) {
                    if( empty( $query->image) ) return;
                    $url = asset($query->image);
                    return '<img src=' . $url . ' class="img-thumbnail" align="center">';
                })
                ->editColumn('name', function ($query) {
                    return $query->name = $query->name." ".$query->last_name;
                })
                ->addColumn('status', function ($query) {
                    $status =  $query->is_active == 1 ? _i('Active') : _i('Not Active');
                    return $status;
                })
                ->addColumn('options', function ($query) {
                    return '<a href="'.route('master.buyers.edit', $query->id).'" class="btn btn-primary edit" title="'._i("Edit").'"><i class="fa fa-edit"></i></a>
                        <a href="#" data-url="'.route('master.buyers.destroy', $query->id).'" class="btn btn-delete btn-danger" title="'._i("Delete").'"><i class="fa fa-trash-o"></i></a>';
                })
                ->rawColumns([
                    'image',
                    'status',
                    'options',
                ])
                ->make(true);
        }
        return view('master.users.buyers.index');
    }

    public function edit($id)
    {
        $user = WebsiteUser::all()->findOrFail($id);
        return view('master.users.buyers.edit', compact('user'));
    }


    public function update(Request $request, $id)
    {
        $user = WebsiteUser::all()->findOrFail($id);
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($id)],
        ]);

        $user->update([
            'name' => $request->input('name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'mobile' => $request->input('mobile'),
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $destinationPath = '/uploads/users/buyers/'. $user->id;
            if (File::exists(public_path($user->image))) {
                File::delete(public_path($user->image));
            }
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $request->image->move(public_path($destinationPath), $filename);
            $user->image = $destinationPath.'/'. $filename;
            $user->save();
        }

        return redirect()->back()->with( 'success',_i('Saved Successfully !'));
    }

    public function destroy($id)
    {
        $user = WebsiteUser::all()->findOrFail($id);
        $user->delete();
        return response()->json(['data'=>true]);
    }
}
