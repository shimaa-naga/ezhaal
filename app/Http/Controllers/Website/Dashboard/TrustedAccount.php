<?php


namespace App\Http\Controllers\Website\Dashboard;

use App\Help\Constants\MimTypes;
use App\Help\Constants\Roles;
use App\Help\Constants\TrustedStatus;
use App\Help\Constants\UserType;
use App\Help\Utility;
use App\Http\Controllers\Controller;
use App\Models\TrustedUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class TrustedAccount extends Controller
{

    protected function trusted()
    {
        $user_type = auth("web")->user()->account_type;

        // if (auth("web")->user()->hasRole(Roles::TRUSTEDFREELANCER)|| $user_type == UserType::TRUSTEDPROVIDER) {

        //     return view("website.thanks", ["msg" => _i("You account is") . " " . $user_type, "title" => _i("Trusted Account")]);
        // }
       // if ($user_type == UserType::USER) {
            //check if sending request before
            $find = TrustedUser::where("user_id", auth("web")->id())->first();
          //  auth("web")->user()->assignRole(Roles::TRUSTEDFREELANCER);

            if ($find == null )
                return view("website.dashboard.profile.trusted");
            else
                return view("website.thanks", [
                    "msg" => _i("You account is") . " " . $find->status,
                    "title" => _i("Trusted Account")
                ]);
        //}
    }
    protected function trustedStore(Request $request)
    {
        $rules =  [
            'sign' => 'mimes:'.MimTypes::NDA,

        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->with("error", _i("Invalid file type"));
        }
        $destinationPath = Utility::PathCreate("app/uploads/trusted/users/" . auth("web")->id(), true);
        $filename = $request->sign->getClientOriginalName();
        $request->sign->move(storage_path($destinationPath),$filename);
        TrustedUser::create([
            "user_id" => auth("web")->id(),
            "file" => storage_path($destinationPath) ."/". $filename,
            "status" => TrustedStatus::PENDING,
            ""
        ]);
        return redirect()->back()->with("success", _i("NDA uploaded successfully"));
    }
}
