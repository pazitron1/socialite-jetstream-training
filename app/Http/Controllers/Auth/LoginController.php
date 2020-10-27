<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('github')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        $githubUser = Socialite::driver('github')->user();

        $user = User::firstOrCreate([
            'email' => $githubUser->getEmail(),
            'name' => $githubUser->getName(),
            'provider_id' => $githubUser->getId()
        ]);
        // $user = User::create([
        //     'email' => $githubUser->getEmail(),
        //     'name' => $githubUser->getName(),
        //     'provider_id' => $githubUser->getId()
        // ]);

        auth()->login($user, true);

        return redirect('dashboard');
    }
}
