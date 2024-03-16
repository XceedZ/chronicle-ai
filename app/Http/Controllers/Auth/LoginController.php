<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect('/')->with('error', 'Login dengan Google gagal.');
        }

        // Check if the user already exists in the database
        $existingUser = User::where('email', $user->email)->first();

        // If the user doesn't exist, create a new user
        if (!$existingUser) {
            $newUser = new User();
            $newUser->name = $user->name;
            $newUser->email = $user->email;
            $newUser->password = bcrypt('randompassword'); // You can set a random password
            $newUser->save();

            Auth::login($newUser);
        } else {
            Auth::login($existingUser);
        }

        return redirect('http://127.0.0.1:8000'); // Ganti ini dengan halaman setelah login
    }
}
