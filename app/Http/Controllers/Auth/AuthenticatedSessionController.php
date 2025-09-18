<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\JsonResponse;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }
    //LOGIN ESCRITORIO
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended('/dashboard');
    }

    //LOGIN IONIC
    public function ion_store(Request $request): JsonResponse
        {
            // Validar las credenciales
            $request->validate([
                'email' => ['required', 'string', 'email'],
                'password' => ['required', 'string'],
            ]);

            // Intentar autenticar al usuario
            if (! Auth::attempt($request->only('email', 'password'))) {
                return response()->json([
                    'message' => 'Credenciales inválidas.'
                ], 401);
            }

            // Obtener al usuario
            $user = $request->user();
            $token = $user->createToken('ionic-token')->plainTextToken;


            // Devolver una respuesta JSON 
            return response()->json([
                'message' => 'Login exitoso',
                'user' => $user,
                'token' => $token
            ]);
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




    /**
     * Handle an incoming authentication request.
     */
    /* FUNCIÓN ANTERIOR PARA DEVOLVER EL USER / COMPLETAR EL LOGIN - DEVUELVE EL USER A IONIC
    
    */