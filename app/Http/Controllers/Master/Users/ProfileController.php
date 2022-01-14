<?php
namespace App\Http\Controllers\Master\Users;
use App\Http\Controllers\Controller;
use App\MasterUsers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class ProfileController extends Controller
{
    public function get_profile()
    {
        $user = auth()->guard('master')->user();
        return view('master.users.profile', compact('user'));
    }

    public function update_profile(Request $request)
    {
        $user = auth()->guard('master')->user();
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
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

        return redirect()->back()->with( 'success',_i('Saved Successfully !'));
    }


    public function changePassword(Request $request)
    {
        $user = auth()->guard('master')->user();
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
}
