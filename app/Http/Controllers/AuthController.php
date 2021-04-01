<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * @group Authentication
 *
 * Authentication endpoints
 */
class AuthController extends Controller
{
    /**
     * Register new user
     * @bodyParam password_confirmation string
     * @param Request $request
     * @return array
     */
    public function register(RegisterRequest $request)
    {
//        return User::create
    }
}
