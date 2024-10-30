<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; // Importa el modelo User
use Illuminate\Support\Facades\Hash; // Para encriptar contraseñas

class UserController extends Controller
{
    /**
     * Muestra una lista de los usuarios.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $users = User::all(); // Obtiene todos los usuarios
        return view('admin.users.index', compact('users')); // Devuelve la vista con los usuarios
    }

    /**
     * Muestra el formulario para crear un nuevo usuario.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.users.create'); // Devuelve la vista para crear un nuevo usuario
    }

    /**
     * Almacena un nuevo usuario en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed', // Requiere confirmación de contraseña
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Encripta la contraseña
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Usuario creado con éxito.'); // Redirige con mensaje
    }

    /**
     * Muestra el formulario para editar el usuario especificado.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\View\View
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user')); // Devuelve la vista para editar el usuario
    }

    /**
     * Actualiza el usuario especificado en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id, // Excluye el usuario actual de la validación
            'password' => 'nullable|string|min:8|confirmed', // Requiere confirmación de contraseña, opcional
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password); // Actualiza la contraseña si se proporciona
        }

        $user->save(); // Guarda los cambios

        return redirect()->route('admin.users.index')->with('success', 'Usuario actualizado con éxito.'); // Redirige con mensaje
    }

    /**
     * Elimina el usuario especificado de la base de datos.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        $user->delete(); // Elimina el usuario
        return redirect()->route('admin.users.index')->with('success', 'Usuario eliminado con éxito.'); // Redirige con mensaje
    }
}
