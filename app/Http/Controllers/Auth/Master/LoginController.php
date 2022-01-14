<?php


namespace App\Http\Controllers\Auth\Master;
use App\Http\Controllers\Controller;
use App\Mail\MasterForgetPassword;
use App\User;
use App\WebsiteUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class LoginController extends Controller
{
    public function login() {
        //dd(auth()->guard('master')->user());
        if (auth()->guard('master')->user() != null)
            return redirect()->route('MasterHome');
        return view('master.auth.login');
    }

    public function checkLogin(Request $request) {

        $this->validate($request, [
            'email' => 'required|email|exists:users',
            'password' => 'required|min:6'
        ]);

        $remember_me = request('remember_me') == 1 ? true : false;
    // 1- check for email & password
        if (auth()->guard('master')->attempt(['email' => $request->email, 'password' => $request->password], $remember_me)) {
            // 2- check for guard type if "master" => true : false
            $user = auth()->guard('master')->user();

            if ($user->guard == "master" && $user->is_active == 1 ) {
                return redirect()->route('MasterHome');
            } else {
                $this->logout();
                return redirect(route('MasterLogin'))
                    ->withInput($request->only('email', 'remember'))
                    ->withErrors([
                        'comp-email' => _i('You do not have permission to access the board!'),
                    ]);
            }
        } else {
            return redirect(route('MasterLogin'))
                ->withInput($request->only('email', 'remember'))
                ->withErrors([
                    "comp-email" => _i('Invaid login credentials !'),
                ]);
        }
    }

    public function logout() {
        auth()->guard('master')->logout();
        Auth::logout();
        return redirect()->route('MasterLogin');
    }

    public function forgotPasswordPost(Request $request) {

        $check_email = WebsiteUser::all()->where(['email' => $request->email , 'guard' => "master"])->first();
        if($check_email) {

            $bytes = random_bytes(20);
            $token = bin2hex($bytes);
            $password_reset = DB::table('password_resets')->insert([
                'email' => $request->email,
                'token' => $token
            ]);

            Mail::to($check_email->email)->send(new MasterForgetPassword($token , $check_email->name));
            //notify()->success(_i('Please Check Your Inbox'));
            return redirect()->back()->with('success', _i('Please Check Your Inbox') );

        } else {
            //notify()->error(_i('Incorrect email'));
            return redirect()->back()->with('error', _i('Incorrect email'));
        }
    }

    public function reset_token_get($token) {

        $check_token = DB::table('password_resets')->where('token' , $token)->first();

        if($check_token) {
            $email = $check_token->email;
            return view('master.auth.reset_password' , compact('token' , 'email'));
        } else {
            abort(404);
        }
    }

    public function reset_token(Request $request) {

        $this->validate($request, [

            'token'	=> 'required',
            'email' => 'required|email',
            'password' => 'required|min:6',
            //'password_confirmation' => 'required|same:password'
        ]);


        $check_token_and_email = DB::table('password_resets')->where(['email' => $request->email , 'token' => $request->token])->first();

        if($check_token_and_email) {

            WebsiteUser::all()->where(['email' => $request->email , 'guard' => "master"])->update([
                'password' => bcrypt($request->password)
            ]);
            DB::table('password_resets')->where(['email' => $request->email , 'token' => $request->token])->delete();
            return redirect()->route('MasterLogin')->with('success', _i('The password has been reset successfully'));
        }

        return redirect()->back()->with('error', 'Invalid URL or email');
    }
}
