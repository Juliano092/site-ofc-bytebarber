<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        try {
            // Debug: Log da tentativa de autenticação
            Log::info('Tentativa de login', [
                'email' => $request->email,
                'ip' => $request->ip()
            ]);

            $request->authenticate();

            $request->session()->regenerate();

            // Debug: vamos ver qual é o tipo de usuário
            $user = Auth::user();

            Log::info('Login bem-sucedido', [
                'user_id' => $user->id,
                'user_type' => $user->user_type,
                'email' => $user->email
            ]);

            // Redirecionar diretamente baseado no tipo de usuário
            switch ($user->user_type) {
                case 'admin':
                    return redirect()->route('admin.dashboard');
                case 'barber':
                    return redirect()->route('barber.dashboard');
                case 'client':
                    return redirect()->route('client.dashboard');
                default:
                    return redirect()->route('dashboard');
            }
        } catch (\Exception $e) {
            Log::error('Erro no login', [
                'error' => $e->getMessage(),
                'email' => $request->email ?? 'N/A'
            ]);

            return back()->withErrors([
                'email' => 'Erro interno no sistema de autenticação.'
            ])->withInput();
        }
    }    /**
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
