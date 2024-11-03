<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    // Mostrar el formulario de registro (opcional)
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // Manejar el registro de nuevos usuarios
    public function register(Request $request)
    {
        // Validar los datos del formulario
        $this->validator($request->all())->validate();

        // Crear el usuario
        $user = $this->create($request->all());

        // Iniciar sesión automáticamente después de registrarse (opcional)
        auth()->login($user);

        // Redirigir al usuario a la página deseada
        return redirect()->route('home')->with('success', 'Registro exitoso.');
    }

    // Validar los datos del registro
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    // Crear un nuevo usuario en la base de datos
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}