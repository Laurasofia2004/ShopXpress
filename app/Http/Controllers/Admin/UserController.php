<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Mostrar todos los usuarios
    public function index()
    {
        $users = User::all(); // Obtener todos los usuarios
        return view('admin.users.index', compact('users')); // Pasar a la vista
    }

    // Mostrar el formulario para crear un nuevo usuario
    public function create()
    {
        return view('admin.users.create'); // Vista para crear un usuario
    }

    // Almacenar un nuevo usuario
    public function store(Request $request)
    {
        // Validar la solicitud
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Crear el usuario
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password), // Cifrar la contraseña
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Usuario creado con éxito.'); // Redirigir
    }

    // Mostrar el formulario para editar un usuario
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user')); // Vista para editar
    }

    // Actualizar el usuario
    public function update(Request $request, User $user)
    {
        // Validar la solicitud
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed', // La contraseña es opcional
        ]);

        // Actualizar el usuario
        $user->name = $request->name;
        $user->email = $request->email;
        
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password); // Cifrar la nueva contraseña si se proporciona
        }

        $user->save(); // Guardar cambios

        return redirect()->route('admin.users.index')->with('success', 'Usuario actualizado con éxito.'); // Redirigir
    }

    // Eliminar un usuario
    public function destroy(User $user)
    {
        $user->delete(); // Eliminar el usuario
        return redirect()->route('admin.users.index')->with('success', 'Usuario eliminado con éxito.'); // Redirigir
    }
}
