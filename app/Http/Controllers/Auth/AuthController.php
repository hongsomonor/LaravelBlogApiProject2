<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\StoreLoginRequest;
use App\Http\Requests\Auth\StoreRegisterRequest;
use App\Http\Requests\Auth\StoreUpdateRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    public function register(StoreRegisterRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('profile')) {
            $profile = $request->file('profile');
            $path = $profile->store('upload/user-profile', 'public');
            $data['profile'] = $path;
        }

        $data['password'] = Hash::make($request->password);

        $user = User::create($data);

        return response()->json(['user' => $user]);
    }

    public function login(StoreLoginRequest $request)
    {
        $credentials = $request->validated();

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('authToken')->accessToken;

            return response()->json([
                'user' => $user,
                'token' => $token
            ]);
        }

        return response()->json(['error' => 'Unautharized']);
    }

    // view profile
    public function viewProfile()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated'
            ]);
        }

        return response()->json([
            'success' => true,
            'profile' => $user
        ]);
    }

    // update profle
    public function update(StoreUpdateRequest $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated'
            ]);
        }

        $data = $request->validated();

        if ($request->hasFile('profile')) {
            if ($user->profile) {
                Storage::disk('public')->delete($user->profile);
            }

            $profile = $request->file('profile');
            $path = $profile->store('upload/user-profile', 'public');
            $data['profile'] = $path;
        }

        $user->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Update profile success',
            'user' => $user
        ]);
    }

    // logout
    public function logout()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated'
            ]);
        }

        $user->token()->revoke();

        return response()->json([
            'success' => true,
            'message' => 'Logout success'
        ]);
    }

    // delete account
    public function deleteAccount()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated'
            ]);
        }

        $user->token()->each(function ($token) {
            $token->revoke();
        });

        if($user->profile) {
            Storage::disk('public')->delete($user->profile);
        }

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Account deleted successfully'
        ]);
    }
}
