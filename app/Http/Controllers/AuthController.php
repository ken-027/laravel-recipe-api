<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['login', 'store']);
    }

    /**
     * Register new user
     *
     * @bodyParam password_confirmation string required Must be at least 8 characters. Must not be greater than 16 characters and match with the password.
     *
     * @response {
     *  "access_token": "token",
     *  "token_type": "bearer",
     *  "expires_in": "seconds"
     * }
     */
    public function store(StoreUserRequest $request, User $user)
    {
        $user = $user->create($request->validated());

        event(new Registered($user));

        return $this->respondWithToken((string) Auth::login($user))->setStatusCode(201);
    }

    public function login(LoginRequest $request)
    {
        return $this->respondWithToken($request->authenticate());
    }

    public function info()
    {
        return response(['user' => Auth::user()]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        Auth::logout();

        return response()->noContent();
    }

    public function refresh()
    {
        return $this->respondWithToken(Auth::refresh());
    }

    protected function respondWithToken(string $token): Response
    {
        return response()->json([
            'access_token' => $token,
            'token' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60,
        ]);
    }
}
