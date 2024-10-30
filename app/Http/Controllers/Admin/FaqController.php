<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Faq; // Importa el modelo Faq

class FaqController extends Controller
{
    /**
     * Muestra una lista de las preguntas frecuentes.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $faqs = Faq::all(); // Obtiene todas las preguntas frecuentes
        return view('admin.faqs.index', compact('faqs')); // Devuelve la vista con las preguntas frecuentes
    }

    /**
     * Muestra el formulario para crear una nueva pregunta frecuente.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.faqs.create'); // Devuelve la vista para crear una nueva pregunta frecuente
    }

    /**
     * Almacena una nueva pregunta frecuente en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
        ]);

        Faq::create([
            'question' => $request->question,
            'answer' => $request->answer,
        ]);

        return redirect()->route('admin.faqs.index')->with('success', 'Pregunta frecuente añadida con éxito.'); // Redirige con mensaje
    }

    /**
     * Muestra la pregunta frecuente especificada.
     *
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\View\View
     */
    public function show(Faq $faq)
    {
        return view('admin.faqs.show', compact('faq')); // Devuelve la vista de la pregunta frecuente
    }

    /**
     * Muestra el formulario para editar la pregunta frecuente especificada.
     *
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\View\View
     */
    public function edit(Faq $faq)
    {
        return view('admin.faqs.edit', compact('faq')); // Devuelve la vista para editar la pregunta frecuente
    }

    /**
     * Actualiza la pregunta frecuente especificada en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Faq $faq)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
        ]);

        $faq->update([
            'question' => $request->question,
            'answer' => $request->answer,
        ]);

        return redirect()->route('admin.faqs.index')->with('success', 'Pregunta frecuente actualizada con éxito.'); // Redirige con mensaje
    }

    /**
     * Elimina la pregunta frecuente especificada de la base de datos.
     *
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Faq $faq)
    {
        $faq->delete(); // Elimina la pregunta frecuente
        return redirect()->route('admin.faqs.index')->with('success', 'Pregunta frecuente eliminada con éxito.'); // Redirige con mensaje
    }
}