<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pqr;
use Illuminate\Http\Request;

class PqrController extends Controller
{
    // Mostrar todas las PQRS
    public function index()
    {
        $pqrs = Pqr::all(); // Obtener todas las PQRS
        return view('admin.pqrs.index', compact('pqrs')); // Pasar a la vista
    }

    // Mostrar el formulario para crear una nueva PQR
    public function create()
    {
        return view('admin.pqrs.create'); // Vista para crear una PQR
    }

    // Almacenar una nueva PQR
    public function store(Request $request)
    {
        // Validar la solicitud
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'type' => 'required|string',
            'message' => 'required|string',
        ]);

        // Crear la PQR
        Pqr::create([
            'name' => $request->name,
            'email' => $request->email,
            'type' => $request->type,
            'message' => $request->message,
        ]);

        return redirect()->route('admin.pqrs.index')->with('success', 'PQR creada con éxito.'); // Redirigir
    }

    // Mostrar el formulario para editar una PQR
    public function edit(Pqr $pqr)
    {
        return view('admin.pqrs.edit', compact('pqr')); // Vista para editar
    }

    // Actualizar la PQR
    public function update(Request $request, Pqr $pqr)
    {
        // Validar la solicitud
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'type' => 'required|string',
            'message' => 'required|string',
        ]);

        // Actualizar la PQR
        $pqr->name = $request->name;
        $pqr->email = $request->email;
        $pqr->type = $request->type;
        $pqr->message = $request->message;

        $pqr->save(); // Guardar cambios

        return redirect()->route('admin.pqrs.index')->with('success', 'PQR actualizada con éxito.'); // Redirigir
    }

    // Eliminar una PQR
    public function destroy(Pqr $pqr)
    {
        $pqr->delete(); // Eliminar la PQR
        return redirect()->route('admin.pqrs.index')->with('success', 'PQR eliminada con éxito.'); // Redirigir
    }
}
