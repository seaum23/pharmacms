<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class PasswordController extends Controller
{
    public function update(User $user, Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed'
        ]);

        $user->password = bcrypt($request->password);
        $user->save();
    }

    public function update_self(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed'
        ]);
        auth()->user()->update(['password' => bcrypt($request->password)]);
    }
}
