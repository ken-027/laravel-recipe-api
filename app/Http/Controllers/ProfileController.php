<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Info of authenticated user
     * @authenticated
     */
    public function show(): UserResource
    {
        return new UserResource(auth()->user());
    }
}
