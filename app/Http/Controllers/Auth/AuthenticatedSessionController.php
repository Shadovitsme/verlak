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
        // Выполняем аутентификацию через LoginRequest
        $request->authenticate();

        // Проверяем, активен ли пользователь
        if (Auth::user()->active != 1) {
            Auth::guard('web')->logout(); // Выход, если неактивен
            $request->session()->invalidate(); // Сбрасываем сессию
            $request->session()->regenerateToken(); // Регенерируем CSRF-токен

            return redirect()->route('login')->withErrors([
                'email' => 'Ваш аккаунт неактивен.',
            ]);
        }

        // Если активен, регенерируем сессию и перенаправляем
        $request->session()->regenerate();

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
