<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\StoreLoginRequest;
use App\Http\Requests\Auth\StoreRegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(StoreRegisterRequest $request)
    {
        $data = $request->validated();

        if($request->hasFile('profile')) {
            $profile = $request->file('profile');
            $name = time(). '.' . $profile->getClientOriginalExtension();
            $profile->move(public_path('upload/profile'),$name);
            $data['profile'] = 'profile/' . $name;
        }

        $data['password'] = Hash::make($request->password);

        $user = User::create($data);

        return response()->json(['user' => $user]);
    }

    public function login(StoreLoginRequest $request)
    {
        $credentials = $request->validated();

        if(Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('authToken')->accessToken;

            return response()->json([
                'user' => $user,
                'token' => $token
            ]);
        }

        return response()->json(['error' => 'Unautharized']);
    }
}
