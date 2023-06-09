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
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request, User $user)
    {
        $user = $user->create($request->validated());

        event(new Registered($user));

        $token = Auth::attempt($request->validated());

        return $this->respondWithToken($token)->setStatusCode(201);
    }

    public function login(LoginRequest $request)
    {

        $token = $request->authenticate();

        return $this->respondWithToken($token);
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
            'expires_in' => Auth::factory()->getTTL() * 60
        ]);
    }
}
