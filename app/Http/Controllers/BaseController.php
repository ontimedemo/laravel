<?php

namespace App\Http\Controllers;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;

class BaseController extends Controller
{
    public function getUserTeams()
    {
        if (!$user = Auth::user()) {
            throw new AuthenticationException();
        }
        return $user->teams();
    }

    public function getUser()
    {
        return Auth::user();
    }
}