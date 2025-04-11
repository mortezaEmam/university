<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // احراز هویت کاربر
        $request->authenticate();

        // ایجاد یک نشست جدید برای کاربر
        $request->session()->regenerate();

        // استخراج اطلاعات اعتبارسنجی (ایمیل و پسورد)
        $credentials = $request->only('email', 'password');
        // تولید توکن JWT
        if ($token = JWTAuth::attempt($credentials)) {
            // بازگشت به صفحه دَش‌بورد با توکن JWT در هدر Authorization
            return response()->json(['token' => $token]);
        }

        // اگر احراز هویت انجام نشد، کاربر را به صفحه دَش‌بورد هدایت می‌کنیم
        return redirect()->intended(route('dashboard', absolute: false));
    }


    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
