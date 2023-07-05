<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class OAuthController extends Controller
{
    /**
     * Redirect for a google authentication
     */
    public function google()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    /**
     * Redirect for a github authentication
     */
    public function github()
    {
        return Socialite::driver('github')->stateless()->redirect();
    }

    /**
     * Callback for a google authentication
     */
    public function google_callback(Request $request)
    {
        $authenticated_user = Socialite::driver('google')->stateless()->user();

        $user = User::firstOrCreate([
            'provider_id' => $authenticated_user->getId(),
            'name' => $authenticated_user->getName(),
            'email' => $authenticated_user->getEmail(),
            'avatar' => $authenticated_user->getAvatar(),
        ]);

        return $this->respondWithToken((string) Auth::login($user));
    }

    /**
     * Callback for a github authentication
     */
    public function github_callback(Request $request)
    {
        $authenticated_user = Socialite::driver('github')->stateless()->user();

        $user = User::firstOrCreate([
            'provider_id' => $authenticated_user->getId(),
            'name' => $authenticated_user->getName(),
            'email' => $authenticated_user->getEmail(),
            'avatar' => $authenticated_user->getAvatar(),
        ]);

        return $this->respondWithToken((string) Auth::login($user));
    }

    protected function respondWithToken(string $token)
    {
        return response()->json([
            'access_token' => $token,
            'token' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60,
        ]);
    }
}
