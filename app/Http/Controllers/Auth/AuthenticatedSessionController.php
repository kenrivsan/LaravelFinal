
<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    public function store(Request $request)
    {
        // Validar las credenciales del usuario
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Intentar autenticar con las credenciales
        if (Auth::attempt($credentials)) {
            // Regenerar la sesión
            $request->session()->regenerate();

            // Redirigir al usuario a la página de inicio o al destino original
            return redirect()->intended(route('home'));
        }

        // Si las credenciales no coinciden, redirigir con un mensaje de error
        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ]);
    }

    public function destroy(Request $request)
    {
        // Cerrar sesión
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirigir a la página de inicio
        return redirect()->route('home');
    }
}