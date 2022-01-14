<?php


namespace App\Http\Controllers\Auth\Website\Company;

use App\Help\Constants\Roles;
use App\Help\Constants\UserType;
use App\Http\Controllers\Controller;
use App\Mail\VerifyEmail;
use App\Models\Companies;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    // public function register()
    // {
    //     if (auth()->guard('web')->user() != null)
    //         return redirect()->route('WebsiteHome');
    //     return view('website.auth.company.register');
    // }
    public function postRegister(Request $request)
    {


        $validator = Validator::make($request->all(),  [
            'name' => 'required', 'string', 'max:255',

            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);
        if($validator->fails())
        {
            return redirect('register?company=1')
            ->withErrors($validator)
            ->withInput();
        }

        $created = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'guard' => 'web',
            'is_active' => 1,
            'account_type' => UserType::COMPANY,
        ]);
        Companies::create(["user_id" => $created->id,"name"=> $request->name]);
        $user = User::find($created->id);
        try {

            Mail::to($created->email)->send(new VerifyEmail($user->uuid, $user->name));
        } catch (Exception $ex) {
            error_log($ex->getMessage());
        }
        return view("website.thanks", [
            "title" => _i("Register complete"),
            "msg" => _i("Your account has been created successfully. please check your email to activate your account.")
        ]);
    }
}
