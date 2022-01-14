<?php

namespace App\Http\Controllers\Master\Company;

use App\Companies;
use App\Help\Constants\UserType;
use App\Help\Utility;
use App\Http\Controllers\Controller;
use App\Models\Companies as ModelsCompanies;
use App\Models\SiteSettings\CountryData;
use App\User;
use App\WebsiteUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class ManagementController extends Controller
{
    protected function index()
    {

        if (request()->ajax()) {
            if (request()->query("provider") != null) {
                $query = Companies::Providers()->orderByDesc('id')->get();
            } else if (request()->query("buyers") != null) {
                $query = Companies::Buyers()->orderByDesc('id')->get();
            } else
                $query = Companies::all()->orderByDesc('id')->get();

            return DataTables::of($query)
                ->addColumn('image', function ($query) {
                    $logo = "";
                    if (empty($query->logo)) {
                        if (empty($query->image)) {
                            return;
                        } else
                            $logo = $query->image;
                    } else
                        $logo = $query->logo;
                    $url = asset($logo);
                    return '<img src=' . $url . ' class="img-thumbnail" align="center">';
                })
                ->editColumn('name', function ($query) {
                    return $query->name = $query->name . " " . $query->last_name;
                })
                ->addColumn('status', function ($query) {

                    return ' <input onchange="active(' . $query->company_id . ')" type="checkbox" class="js-switch-blue" ' . ($query->active == 1 ? "checked" : "") . ' />';
                })
                ->addColumn('options', function ($query) {
                    return '<a href="' . route('company.edit', $query->company_id) . '" class="btn btn-primary edit" title="' . _i("Edit") . '"><i class="fa fa-edit"></i></a>
                        <a href="#" data-url="' . route('company.destroy', $query->company_id) . '" class="btn btn-delete btn-danger" title="' . _i("Delete") . '"><i class="fa fa-trash-o"></i></a>';
                })
                ->rawColumns([
                    'image',
                    'status',
                    'options',
                ])
                ->make(true);
        }
        return view('master.company.index');
    }
    protected function edit($id)
    {

        $company = ModelsCompanies::findOrFail($id);
        $user = $company->MasterAccount;
        $countries = CountryData::where("lang_id", Utility::getLang())->get();
        return view('master.company.edit', compact('user', "company", "countries"));
    }
    protected function activate($id)
    {
        $company = ModelsCompanies::find($id);
        if ($company == null)
            return response()->json([], 404);
        $company->active = !$company->active;
        $company->save();
        return response()->json("success", 200);
    }
    protected function update(Request $request, $id)
    {

        $user = WebsiteUser::allCompanies()->findOrFail($id);
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
        if ($user->company != null) {
            $user->company->update(["cr_number" => $request->input("cr_number"),
            "name" => $request->input("name")]);
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $destinationPath = '/uploads/users/buyers/' . $user->id;
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

    protected function destroy($id)
    {
        $user = WebsiteUser::all()->findOrFail($id);
        $user->delete();
        return response()->json(['data' => true]);
    }
}
