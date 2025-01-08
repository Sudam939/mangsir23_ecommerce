<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class UserController extends Controller
{
    public function google_login()
    {
        return Socialite::driver('google')->redirect();
    }

    public function google_callback()
    {
        $user = Socialite::driver('google')->user();

        $find_user = User::where('google_id', $user->id)->first();

        $registered_user = User::where('email', $user->email)->first();
        if ($registered_user) {
            Auth::login($registered_user);
            return redirect('/dashboard');
        }

        if ($find_user) {
            Auth::login($find_user);
            return redirect('/dashboard');
        }
        $new_user = new User();
        $new_user->name = $user->name;
        $new_user->email = $user->email;
        $new_user->google_id = $user->id;
        $new_user->password = Hash::make(rand(100000, 999999));
        $new_user->save();
        Auth::login($new_user);
        return redirect('/dashboard');
    }
}
