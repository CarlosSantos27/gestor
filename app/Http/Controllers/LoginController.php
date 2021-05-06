<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $guard = $this->guard('web');

        $credentials = array("email" => $request->email, "password" => $request->password);

        if (!$guard->attempt($credentials)) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 428);
        }
        $currentUser = $guard->user();

        $currentUser->api_token = Str::random(80);
        $currentUser->save();
        $guard->logout();
        return $currentUser;
    }

    public function register(Request $request)
    {
        $user = new User([
            'name'  => $request->name,
            'email' => $request->email,
            'api_token' => Str::random(80),
            'password'  => bcrypt($request->password)
        ]);
        $user->save();
        return response()->json($user);
    }

    private function guard($guardName)
    {
        return Auth::guard($guardName);
    }
}
