<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact; // Importa el modelo Contact

class ContactController extends Controller
{
    /**
     * Muestra una lista de los mensajes de contacto.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $contacts = Contact::all(); // Obtiene todos los mensajes de contacto
        return view('admin.contacts.index', compact('contacts')); // Devuelve la vista con los mensajes de contacto
    }

    /**
     * Muestra el formulario para crear un nuevo mensaje de contacto.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.contacts.create'); // Devuelve la vista para crear un nuevo mensaje
    }

    /**
     * Almacena un nuevo mensaje de contacto en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
        ]);

        return redirect()->route('admin.contacts.index')->with('success', 'Mensaje de contacto enviado con éxito.'); // Redirige con mensaje
    }

    /**
     * Muestra el mensaje de contacto especificado.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\View\View
     */
    public function show(Contact $contact)
    {
        return view('admin.contacts.show', compact('contact')); // Devuelve la vista del mensaje de contacto
    }

    /**
     * Muestra el formulario para editar el mensaje de contacto especificado.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\View\View
     */
    public function edit(Contact $contact)
    {
        return view('admin.contacts.edit', compact('contact')); // Devuelve la vista para editar el mensaje
    }

    /**
     * Actualiza el mensaje de contacto especificado en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Contact $contact)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        $contact->update([
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
        ]);

        return redirect()->route('admin.contacts.index')->with('success', 'Mensaje de contacto actualizado con éxito.'); // Redirige con mensaje
    }

    /**
     * Elimina el mensaje de contacto especificado de la base de datos.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Contact $contact)
    {
        $contact->delete(); // Elimina el mensaje de contacto
        return redirect()->route('admin.contacts.index')->with('success', 'Mensaje de contacto eliminado con éxito.'); // Redirige con mensaje
    }
}