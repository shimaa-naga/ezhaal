<?php


namespace App\Http\Controllers\Auth\Website;

use App\Help\Constants\Roles;
use App\Help\Constants\UserType;
use App\Bll\User as HelpUser;
use App\Http\Controllers\Controller;
use App\Mail\VerifyEmail;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use PHPUnit\TextUI\Help;

class RegisterController extends Controller
{
    public function register()
    {
        if (auth()->guard('web')->user() != null)
            return redirect()->route('WebsiteHome');
        return view('website.auth.register');
    }

    public function postRegister(Request $request)
    {

        //     $this->validate($request, [
        //         'name' => 'required', 'string', 'max:255',
        //         'last_name' => 'sometimes', 'string', 'max:255',
        //         'email' => 'required|email|unique:users',
        //         'password' => 'required|min:6'
        //     ]);

        //     $created = User::create([
        //         'name' => $request->name,
        //         'last_name' => $request->last_name,
        //         'email' => $request->email,
        //         'password' => Hash::make($request->password),
        //         'guard' => 'web',
        //         'is_active' => 1,
        //         'account_type' => UserType::USER,
        //     ]);
        //     $user = User::find($created->id);
        //    // $user->assignRole(Roles::REGISTEREDUSER);
        // try {
        //     Mail::to($user->email)->send(new VerifyEmail($user->uuid, $user->name));
        //     return view("website.thanks", [
        //         "title" => _i("Register complete"),
        //         "msg" => _i("Your account has been created successfully. please check your email to activate your account.")
        //     ]);
        // } catch (Exception $ex) {
        //     error_log($ex->getMessage());
        // }
        $bll =new HelpUser();

        if ($bll->Register($request))
            return view("website.thanks", [
                "title" => _i("Register complete"),
                "msg" => _i("Your account has been created successfully. please check your email to activate your account.")
            ]);
            return back()->with("error","Error");

    }
}
