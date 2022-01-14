<?php


namespace App\Http\Controllers\Master\Users;

use App\DataTable;
use App\Help\Constants\Roles;
use App\Help\Constants\TrustedStatus;
use App\Help\Constants\UserType;
use App\Http\Controllers\Controller;
use App\Models\TrustedUser;
use App\User;
use App\WebsiteUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use TrustedUsers;
use Yajra\DataTables\Facades\DataTables;

class FreelancerController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {

            if (request()->query("freelancer") != null) {
                $query = WebsiteUser::Freelancers()->orderByDesc('id');
            } else if (request()->query("buyers") != null) {
                $query = WebsiteUser::Providers()->orderByDesc('id');
            } else
                $query = WebsiteUser::all()->orderByDesc('id');
            // dd($query);
            $dt = new DataTable($query);
            return $dt->response();
        }
        return view('master.users.freelancers.index');
    }
    protected function getTrustedRequests(Request $request)
    {
        if ($request->ajax()) {
            $columns = ["users.name", "users.email", "users.image", "users.id", "trusted_users.status", "trusted_users.created_at"];

            $query = TrustedUser::join("users", "users.id", "user_id")->select("users.name", "users.email", "users.image", "users.id", "trusted_users.id as request_id", "trusted_users.status as status", DB::raw("trusted_users.created_at as created"));
            $dt = new DataTable($query);
            $dt->columns($columns);
            return $dt->response();
        }
        return view('master.users.freelancers.trusted.requests');
    }
    protected function trust($id)
    {
        $request = TrustedUser::findOrFail($id);
        return view('master.users.freelancers.trusted.show', compact('request'));
    }

    protected function approveTrust($id)
    {
        $request = TrustedUser::findOrFail($id);
        $request->status = TrustedStatus::APPROVED;
        $request->save();

        $user = $request->User;
        //$user->account_type =UserType::TRUSTEDFREELANCER;
        if (Role::where("name", Roles::TRUSTEDFREELANCER)->first() == null)
            Role::create(['name' => Roles::TRUSTEDFREELANCER, "guard_name" => "web"]);
        $user->assignRole(Roles::TRUSTEDFREELANCER);

        return redirect()->back()->with('success', _i('Approved Successfully !'));
    }

    protected function removeTrusted($id)
    {
        $request = TrustedUser::findOrFail($id);
        $request->status = TrustedStatus::REJECTED;
        $request->save();
        $user = $request->User;
        //$user->account_type =UserType::TRUSTEDFREELANCER;
        if ($user->HasRole(Roles::TRUSTEDFREELANCER))
            $user->removeRole(Roles::TRUSTEDFREELANCER);

        return redirect()->back()->with('success', _i('Removed Successfully !'));
    }
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('master.users.freelancers.edit', compact('user'));
    }

    protected function destroy($id)
    {
        $user = WebsiteUser::all()->findOrFail($id);
        $user->delete();
        return response()->json(['data' => true]);
    }
    protected function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
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
            $destinationPath = '/uploads/users/freelancers/' . $user->id;
            if (File::exists(public_path($user->image))) {
                File::delete(public_path($user->image));
            }
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $request->image->move(public_path($destinationPath), $filename);
            $user->image = $destinationPath . '/' . $filename;
            $user->save();
        }

        return redirect()->back()->with('success', _i('Saved Successfully !'));
    }
}
