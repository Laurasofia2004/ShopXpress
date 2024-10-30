<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pqr; // Importa el modelo Pqr

class PqrController extends Controller
{
    /**
     * Muestra una lista de todas las PQRs.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $pqrs = Pqr::all(); // Obtiene todas las PQRs
        return view('admin.pqrs.index', compact('pqrs')); // Devuelve la vista con las PQRs
    }

    /**
     * Muestra el formulario para crear una nueva PQR.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.pqrs.create'); // Devuelve la vista para crear una nueva PQR
    }

    /**
     * Almacena una nueva PQR en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        Pqr::create([
            'customer_name' => $request->customer_name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
        ]);

        return redirect()->route('admin.pqrs.index')->with('success', 'PQR registrada con éxito.'); // Redirige con mensaje
    }

    /**
     * Muestra la PQR especificada.
     *
     * @param  \App\Models\Pqr  $pqr
     * @return \Illuminate\View\View
     */
    public function show(Pqr $pqr)
    {
        return view('admin.pqrs.show', compact('pqr')); // Devuelve la vista de la PQR
    }

    /**
     * Muestra el formulario para editar la PQR especificada.
     *
     * @param  \App\Models\Pqr  $pqr
     * @return \Illuminate\View\View
     */
    public function edit(Pqr $pqr)
    {
        return view('admin.pqrs.edit', compact('pqr')); // Devuelve la vista para editar la PQR
    }

    /**
     * Actualiza la PQR especificada en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pqr  $pqr
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Pqr $pqr)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $pqr->update([
            'customer_name' => $request->customer_name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
        ]);

        return redirect()->route('admin.pqrs.index')->with('success', 'PQR actualizada con éxito.'); // Redirige con mensaje
    }

    /**
     * Elimina la PQR especificada de la base de datos.
     *
     * @param  \App\Models\Pqr  $pqr
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Pqr $pqr)
    {
        $pqr->delete(); // Elimina la PQR
        return redirect()->route('admin.pqrs.index')->with('success', 'PQR eliminada con éxito.'); // Redirige con mensaje
    }
}
