<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Muestra una lista de todas las publicaciones.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $blogs = Blog::latest()->paginate(10); // Obtiene las publicaciones ordenadas por las más recientes
        return view('blog.index', compact('blogs'));
    }

    /**
     * Muestra el formulario para crear una nueva publicación.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('blog.create');
    }

    /**
     * Almacena una nueva publicación en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validación de datos
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        // Creación de la publicación
        Blog::create([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return redirect()->route('blog.index')
                         ->with('success', '¡La publicación se ha creado con éxito!');
    }

    /**
     * Muestra una publicación específica.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\View\View
     */
    public function show(Blog $blog)
    {
        return view('blog.show', compact('blog'));
    }

    /**
     * Muestra el formulario para editar una publicación existente.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\View\View
     */
    public function edit(Blog $blog)
    {
        return view('blog.edit', compact('blog'));
    }

    /**
     * Actualiza una publicación específica en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Blog $blog)
    {
        // Validación de datos
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        // Actualización de la publicación
        $blog->update([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return redirect()->route('blog.index')
                         ->with('success', '¡La publicación se ha actualizado con éxito!');
    }

    /**
     * Elimina una publicación específica de la base de datos.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Blog $blog)
    {
        $blog->delete();

        return redirect()->route('blog.index')
                         ->with('success', '¡La publicación se ha eliminado con éxito!');
    }
}
