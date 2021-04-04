<?php

namespace App\Http\Controllers;

/**
 * @group Authentication
 *
 * Authentication endpoints
 */
class AuthController extends Controller
{
    public function destroyAccount()
    {
        return auth()->user();
    }
}
