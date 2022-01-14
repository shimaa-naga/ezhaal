<?php


namespace App\Http\Controllers\Website\Dashboard;

use App\Help\Constants\UserType;
use App\Help\Utility;
use App\Http\Controllers\Controller;
use App\Models\SiteSettings\City;

use App\Models\SiteSettings\CountryData;
use App\Models\Skills\UsersSkills;
use App\Models\UserInfo;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{

    public function index()
    {
        $user = auth()->guard('web')->user();
        // dd($user->account_type );

        $user_info = UserInfo::where('user_id', $user->id)->first();
        if ($user->account_type == UserType::COMPANY)
            return view('website.dashboard.profile.company.index', compact('user', 'user_info'));

        return view('website.dashboard.profile.index', compact('user', 'user_info'));
    }

    public function profile_save(Request $request)
    {
        $user = auth()->guard('web')->user();
        // $user->update(['account_type' => $request->account_type]);
        $user_info = UserInfo::where('user_id', $user->id)->first();
        if ($user_info == null) {
            $user_info = UserInfo::create([
                'user_id' => $user->id,
                'about' => $request->about,
            ]);
        } else {
            $user_info->update(['about' => $request->about]);
        }

        if ($request->hasFile('cv')) {
            $cv = $request->file('cv');
            $destinationPath = '/uploads/users_info/' . $user->id;

            $destinationPath = Utility::PathCreate($destinationPath);


            $filename = $cv->getClientOriginalName();
            $request->cv->move(public_path($destinationPath), $filename);
            $user_info->cv = $destinationPath . '/' . $filename;
            $user_info->save();
        }

        return redirect()->back()->with('success', _i('Profile Saved Successfully !'));
    }


    public function personal_info()
    {
        $user = auth()->guard('web')->user();
        $countries = CountryData::where('lang_id', Utility::websiteLang())->get();
        if ($user->account_type == UserType::COMPANY)
            return view('website.dashboard.profile.company.personal_info', compact('user', 'countries'));

        return view('website.dashboard.profile.personal_info', compact('user', 'countries'));
    }

    public function update_personal_info(Request $request)
    {
        $user_id = auth()->guard('web')->user()->id;
        $rules =  [
            'name' => ['required', 'string', 'max:255', 'min:3'],
            'last_name' => ['sometimes', 'string', 'max:255'],
         //   'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user_id)],
            'password' => ['sometimes'],
        ];
        if (!is_null($request->password)) {
            $rules['old_password'] =  ['required', 'string', 'min:6'];
            $rules['password'] = ['required', 'string', 'confirmed', 'min:6'];
            $rules['password_confirmation'] = ['required'];
        }



        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $user = User::where('id', $user_id)->first();
            $user->update([
                'name' => $request->name,
                'last_name' => $request->last_name,

                'mobile' => $request->mobile,
                'country_id' => $request->country_id,
                'city_id' => $request->city_id,
                'dob' => $request->dob,
                //'password' => Hash::make($request->password),
            ]);
            //dd($request->all());
            $company = $user->company;
            if ($request->cr_number != null) {
                $company->cr_number = $request->cr_number;
            }
            if ($request->address != null) {
                $company->address = $request->address;
            }
            $company->save();
            if (!is_null($request->password)) {
                if (Hash::check($request->input('old_password'), $user->password)) {
                    $user->password = bcrypt($request->input('password'));
                    $user->save();
                } else {
                    return redirect()->back()->with('msg', _i('Old Password Doesn\'t Match !'));
                }
            }
            return redirect()->back()->with('success', _i('Personal information Updated Successfully !'));
        }
    }

    public function  update_logo(Request $request)
    {
        //dd($request->all());
        $user = auth()->guard('web')->user(); //buyers  freelancers
        $type= $user->account_type;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $destinationPath = '/uploads/users/' . $type . '/' . $user->id;
            if (File::exists(public_path($user->image))) {
                File::delete(public_path($user->image));
            }
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $request->image->move(public_path($destinationPath), $filename);
            $user->image = $destinationPath . '/' . $filename;
            $user->save();
        }
        return redirect()->back()->with('success', _i('Image Updated Successfully !'));
    }

    public function update_password(Request $request)
    {
        $user_id =  auth()->user()->id;
        $user = User::findOrFail($user_id);
        $rules = [
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'old_password' => ['required', 'string', 'min:6'],
        ];


        $validator = validator()->make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        if (Hash::check($request->input('old_password'), $user->password)) {
            $user->password = bcrypt($request->input('password'));
            $user->save();
            return redirect()->back()->with('flash_message', _i('Password Updated Successfully !'));
        } else {
            return redirect()->back()->with('flash_message', _i('Old Password Doesn\'t Match !'));
        }
    }


    public function skills()
    {
        $user = auth()->guard('web')->user();
        $user_skills = UsersSkills::where('user_id', $user->id)->get();
        return view('website.dashboard.profile.skills', compact('user', 'user_skills'));
    }

    public function save_skills(Request $request)
    {
        $userId = auth()->guard('web')->user()->id;
        $user_skills = UsersSkills::where('user_id', $userId)->delete();
        foreach ($request->skills as $item) {
            UsersSkills::create([
                'user_id' => $userId,
                'skill_id' => $item,
            ]);
        }
        return redirect()->back()->with('success', _i('Profile Saved Successfully !'));
    }

    public function cityList(Request $request)
    {
        //dd($request->all());
        $cities = City::leftJoin('city_data', 'city_data.city_id', 'cities.id')
            ->where('city_data.lang_id', Utility::websiteLang())
            ->where('cities.country_id', $request->country_id)->pluck("city_data.title", "city_data.city_id");
        return $cities;
    }
}
