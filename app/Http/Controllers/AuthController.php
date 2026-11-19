<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Register user baru (default role: customer, bisa dikirim 'admin' saat testing)
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role'     => 'nullable|in:admin,customer',
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => $validated['password'], // otomatis di-hash oleh cast di Model User
            'role'     => $validated['role'] ?? 'customer',
        ]);

        Auth::login($user);

        return response()->json([
            'success' => true,
            'message' => 'Registrasi berhasil',
            'data'    => [
                'user' => $user,
            ],
        ], 201);
    }

    // Login user
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau password salah',
            ], 401);
        }

        $request->session()->regenerate();

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil',
            'data'    => [
                'user' => Auth::user(),
            ],
        ], 200);
    }

    // Cek user yang sedang login sekarang
    public function me()
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Belum login',
            ], 401);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data user yang sedang login',
            'data'    => [
                'user' => Auth::user(),
            ],
        ], 200);
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil',
            'data'    => null,
        ], 200);
    }
}