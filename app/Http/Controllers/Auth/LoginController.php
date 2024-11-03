<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    // Redireccionar a donde ir después de iniciar sesión
    protected $redirectTo = '/home';

    // Mostrar el formulario de inicio de sesión
    public function showLoginForm()
    {
        return view('auth.login'); // Asegúrate de tener la vista auth/login.blade.php
    }

    // Manejar la autenticación del usuario
    public function login(Request $request)
    {
        // Validar los datos de inicio de sesión
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Intentar autenticar al usuario
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Autenticación exitosa, redirigir al usuario
            return redirect()->intended($this->redirectTo);
        }

        // Si la autenticación falla, redirigir de vuelta al formulario con un mensaje de error
        return back()->withInput($request->only('email'))->withErrors([
            'email' => 'Las credenciales proporcionadas son incorrectas.',
        ]);
    }

    // Cerrar sesión del usuario
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/'); // Redirigir a la página principal o de inicio
    }
}
