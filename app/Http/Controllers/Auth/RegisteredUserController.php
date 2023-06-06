<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(StoreUserRequest $request, User $user): Response
    {
        $user = $user->create($request->validated());

        event(new Registered($user));

        return response([
            'accessToken' => $user->createToken($user->id, ['server:update'])->plainTextToken,
        ], 201);
    }
}
