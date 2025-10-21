<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Cari user berdasarkan email
        $user = User::where('email', $request->email)->first();

        // Jika user tidak ditemukan ATAU password salah
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(
                [
                    'message' => 'Unauthorized. Email or password not found.',
                ],
                401,
            );
        }

        // Hapus token lama (opsional)
        $user->tokens()->delete();

        // Buat token baru
        $token = $user->createToken('auth-token')->plainTextToken;

        // Load relasi
        $user->load('role.division');

        //dd($user,$token);
        return response()->json([
            'message' => 'Login Success!',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'role' => [
                    'id' => $user->role->id,
                    'name' => $user->role->name,
                    'division' => [
                        'id' => $user->role->division->id,
                        'name' => $user->role->division->name,
                    ],
                ],
            ],
        ]);
    }

    // jaga-jaga kalau mau implementasi refresh token
    // public function refreshToken(Request $request) {
    //     $authHeader = $request->header('Authorization');

    //     if (empty($authHeader) || !str_starts_with($authHeader, 'Bearer ')) {
    //         return response()->json(['message' => 'Token is invalid'], 422);
    //     }

    //     $tokenString = explode('Bearer ', $authHeader)[1] ?? null;
    //     $token = PersonalAccessToken::findToken($tokenString);

    //     if (!$token || !$token->tokenable instanceof User) {
    //         return response()->json(['message' => 'Token is invalid'], 422);
    //     }

    //     // Hapus token lama & buat token baru
    //     $token->delete();
    //     $newToken = $token->tokenable->createToken('token')->plainTextToken;

    //     return response()->json([
    //         'status' => 'success',
    //         'access_token' => $newToken,
    //         'token_type' => 'Bearer',
    //     ]);
    // }

    public function user()
    {
        return response()->json([
            'message' => 'Success!',
            //'data' => Auth::user(),
        ]);
    }

    public function logout()
    {
        Auth::user()->tokens()->delete();

        $user = Auth::user();

        if (!$user) {
            return response()->json(
                [
                    'message' => 'User not authenticated.',
                ],
                401,
            );
        }

        $user->tokens()->delete();

        return response()->json([
            'message' => 'Success!',
        ]);
    }
}
