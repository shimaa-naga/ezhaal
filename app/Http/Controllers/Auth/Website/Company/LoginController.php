<?php


namespace App\Http\Controllers\Auth\Website\Company;


use App\Http\Controllers\Controller;
use App\Mail\MasterForgetPassword;
use App\Mail\VerifyEmail;
use App\User;
use App\WebsiteUser;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{

    protected function login()
    {
        if (auth()->guard('web')->user() != null)
            return redirect()->to('home');
        return view('website.auth.company.login');
    }
    protected function reVerify()
    {

        $email = request()->input("email");
        if ($email != null) {
            return view("auth.passwords.reverify", ["email" => $email]);
        }
        return view("auth.passwords.reverify");
    }
    protected function reVerifyPost()
    {
        $email = request()->input("email");
        if ($email == null) {
            abort(404);
        }
        $find = WebsiteUser::all()->where("email", $email)->first();
        if ($find == null)
            return redirect()->back()->with("error", _i("Email is not registered."));

        Mail::to($find->email)->send(new VerifyEmail($find->uuid, $find->name));
        return view("website.thanks", [
            "title" => _i("Email Sent"),
            "msg" => _i("Please check your email to activate your account.")
        ]);
    }
    protected function verify($token)
    {
        if (auth()->guard('web')->user() != null)
            return redirect()->to('home');
        // dd($token);
        $find = WebsiteUser::all()->where("uuid", $token)->first();
        if ($find == null)
            abort(404);
        $find->email_verified_at = now();
        $find->uuid = uniqid();
        $find->update();
        return view("website.thanks", ["title" => "Verified", "msg" => "Thanks your account has been verified successfully."]);
    }

    protected function checkLogin(Request $request)
    {

        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        $remember_me = request('remember_me') == 1 ? true : false;
        $user = WebsiteUser::allCompanies()->whereEmail($request->input("email"))->first();

        if ($user == null) {
            return redirect()->action('Auth\Website\RegisterController@register')->with("error", "This email is not registered. Please register.");
        }
        if ($user->email_verified_at == null) {
            return redirect(route('WebsiteLogin'))
                ->withInput($request->only('email', 'remember'))
                ->withErrors([
                    'email' => _i('please verify your email.Resend the verification email ?') . '<a href="reverify?email=' . $user->email . '">' . _i('Click here') . '</a> '
                ]);
        }
        // 1- check for email & password
        if (auth()->guard('web')->attempt(['email' => $request->email, 'password' => $request->password], $remember_me)) {
            // 2- check for guard type if "web" => true : false
           // dd( $user->company->active );
            $user = auth()->guard('web')->user();
            if ($user->guard == "web" && $user->is_active == 1 && $user->company->active == true ) {
                if (request()->query("return") != null)
                {
                    return redirect()->to(url( request()->query("return")));
                }
                return redirect()->intended('home');
            } else {
                $this->logout();
                return redirect(route('WebsiteLogin'))
                    ->withInput($request->only('email', 'remember'))
                    ->withErrors([
                        'email' => _i('This email has been blocked. Please contact the administration!'),
                    ]);
            }
        } else {
            return redirect(route('WebsiteLogin'))
                ->withInput($request->only('email', 'remember'))
                ->withErrors([
                    "email" => _i('Invalid authentication password !'),
                ]);
        }
    }

    public function logout()
    {
        auth('web')->logout();
        Auth::logout();
        return redirect()->route('WebsiteLogin');
    }

    public function forgotPasswordPost(Request $request)
    {
        if (auth()->guard('web')->user() != null)
            return redirect()->to('home');
        $check_email = WebsiteUser::all()->where(['email' => $request->email, 'guard' => "master"])->first();
        if ($check_email) {

            $bytes = random_bytes(20);
            $token = bin2hex($bytes);
            $password_reset = DB::table('password_resets')->insert([
                'email' => $request->email,
                'token' => $token
            ]);

            Mail::to($check_email->email)->send(new MasterForgetPassword($token, $check_email->name));

            //notify()->success(_i('Please Check Your Inbox'));
            return redirect()->back()->with('success', _i('Please Check Your Inbox'));
        } else {
            //notify()->error(_i('Incorrect email'));
            return redirect()->back()->with('error', _i('Incorrect email'));
        }
    }

    public function reset_token_get($token)
    {
        if (auth()->guard('web')->user() != null)
            return redirect()->to('home');
        $check_token = DB::table('password_resets')->where('token', $token)->first();

        if ($check_token) {
            $email = $check_token->email;
            return view('master.auth.reset_password', compact('token', 'email'));
        } else {
            abort(404);
        }
    }

    public function reset_token(Request $request)
    {
        if (auth()->guard('web')->user() != null)
            return redirect()->to('home');
        $this->validate($request, [

            'token'    => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6',
            //'password_confirmation' => 'required|same:password'
        ]);


        $check_token_and_email = DB::table('password_resets')->where(['email' => $request->email, 'token' => $request->token])->first();

        if ($check_token_and_email) {

            WebsiteUser::all()->where(['email' => $request->email, 'guard' => "master"])->update([
                'password' => bcrypt($request->password)
            ]);
            DB::table('password_resets')->where(['email' => $request->email, 'token' => $request->token])->delete();
            return redirect()->route('MasterLogin')->with('success', _i('The password has been reset successfully'));
        }

        return redirect()->back()->with('error', 'Invalid URL or email');
    }
}
