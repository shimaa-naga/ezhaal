<?php

namespace App\Bll;

use App\Help\Constants\UserType;
use App\Mail\VerifyEmail;
use App\User as AppUser;
use App\WebsiteUser;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class User
{

    /**
     * Created user after register
     * @var \App\User
     */
    public $created;
    private $error;
    public function GetError()
    {
        return $this->error;
    }
    public function login(Request $request, $email_input = "email", $password_input = "password")
    {
        $request->validate([
            $email_input => 'required|email',
            $password_input => 'required|min:6'
        ]);

        $remember_me = request('remember_me') == 1 ? true : false;
        $user = WebsiteUser::all()->whereEmail($request->input($email_input))->first();
        if ($user == null) {
            $this->error = "This email is not registered. Please register.";
            return false;
        }
        $this->created = $user;
        if ($user->email_verified_at == null) {
            $this->error = _i('please verify your email.Resend the verification email ?') . '<a href="reverify?email=' . $user->email . '">' . _i('Click here') . '</a> ';
            return true;
        }
        // 1- check for email & password
        if (auth()->guard('web')->attempt(["email" => $request->$email_input, "password" => $request->$password_input], $remember_me)) {
            // 2- check for guard type if "web" => true : false
            $user = auth()->guard('web')->user();
            if ($user->guard == "web" && $user->is_active == 1) {
                return true;
            } else {
                auth('web')->logout();
                Auth::logout();
                $this->error = _i('This email has been blocked. Please contact the administration!');
                return true;
            }
        }
        return false;
    }
    public  function loginByOtp(Request $request)
    {
        $find = AppUser::where("mobile", $request->otp_mobile)->first();
        if ($find == null) {
            $created = AppUser::create([
                'name' => "Guest",
                'last_name' => "",
                'mobile' => $request->otp_mobile,
                'password' => Hash::make($request->password),
                'guard' => 'web',
                'is_active' => 1,
                'account_type' => UserType::USER,
            ]);
            $user = AppUser::find($created->id);
            $this->created = $user;
        } else
            $this->created = $find;

            Auth::loginUsingId($this->created->id);

    }
    public  function Register(Request $request)
    {
        $request->validate([
            'name' => 'required', 'string', 'max:255',
            'last_name' => 'sometimes', 'string', 'max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);
        $created = AppUser::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'guard' => 'web',
            'is_active' => 1,
            'account_type' => UserType::USER,
        ]);
        $user = AppUser::find($created->id);
        $this->created = $user;
        // $user->assignRole(Roles::REGISTEREDUSER);
        try {
            Mail::to($user->email)->send(new VerifyEmail($user->uuid, $user->name));
            return true;
        } catch (Exception $ex) {
            error_log($ex->getMessage());
        }
        return false;
    }
}
