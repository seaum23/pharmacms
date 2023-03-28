<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;

class AuthUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \App\Http\Resources\UserResource
     */
    public function index()
    {
        return new UserResource(Auth::user());
    }
}
