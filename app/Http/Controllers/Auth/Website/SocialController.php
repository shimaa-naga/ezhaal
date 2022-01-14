<?php

namespace App\Http\Controllers\Auth\Website;

use App\Help\Constants\UserType;
use App\Http\Controllers\Controller;
use App\User;
use App\WebsiteUser;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller {

    public function redirect($provider) {
        //dd($provider);
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider) {
        //dd($provider);
        if ($provider == "linkedin") {
            $getInfo = Socialite::driver($provider)->user();
        } else {
            $getInfo = Socialite::driver($provider)->stateless()->user();
        }
        // dd($getInfo);
        $email = WebsiteUser::all()->where('email', $getInfo->email)->first();
        if ($email != null) {
            $user = $this->createUser($getInfo, $provider);
            auth()->guard('web')->login($user);
            session()->flash('success', _i('welcome visitor You login by'." " . $provider));
            return redirect()->route('WebsiteHome');
        } else {
//            $email->delete();
            $user = $this->createUser($getInfo, $provider);
            auth()->guard('web')->login($user);
            session()->flash('success', _i('welcome visitor You login by'." " . $provider));
            return redirect()->route('WebsiteHome');
        }
    }

    function createUser($getInfo, $provider) {
        //dd($getInfo, $provider);
        $user = WebsiteUser::all()->where('provider_id', $getInfo->id)->first();
        if ($user == null) {
            $user = WebsiteUser::all()->create([
                        'name' => $getInfo->name,
                        'email' => $getInfo->email,
                        'guard' => 'web',
                        'is_active' => 1,
                        'account_type' => UserType::USER,
                        'image' => $getInfo->avatar,
                        'providers' => $provider,
                        'provider_id' => $getInfo->id
            ]);
        }
        return $user;
    }

}
