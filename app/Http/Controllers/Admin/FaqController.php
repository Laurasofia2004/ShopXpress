<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    // Mostrar todas las FAQs
    public function index()
    {
        $faqs = Faq::all(); // Obtener todas las preguntas frecuentes
        return view('admin.faqs.index', compact('faqs')); // Pasar a la vista
    }

    // Mostrar el formulario para crear una nueva FAQ
    public function create()
    {
        return view('admin.faqs.create'); // Vista para crear una FAQ
    }

    // Almacenar una nueva FAQ
    public function store(Request $request)
    {
        // Validar la solicitud
        $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
        ]);

        // Crear la FAQ
        Faq::create([
            'question' => $request->question,
            'answer' => $request->answer,
        ]);

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ creada con éxito.'); // Redirigir
    }

    // Mostrar el formulario para editar una FAQ
    public function edit(Faq $faq)
    {
        return view('admin.faqs.edit', compact('faq')); // Vista para editar
    }

    // Actualizar la FAQ
    public function update(Request $request, Faq $faq)
    {
        // Validar la solicitud
        $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
        ]);

        // Actualizar la FAQ
        $faq->update([
            'question' => $request->question,
            'answer' => $request->answer,
        ]);

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ actualizada con éxito.'); // Redirigir
    }

    // Eliminar una FAQ
    public function destroy(Faq $faq)
    {
        $faq->delete(); // Eliminar la FAQ
        return redirect()->route('admin.faqs.index')->with('success', 'FAQ eliminada con éxito.'); // Redirigir
    }
}
