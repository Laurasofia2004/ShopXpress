<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category; // Importa el modelo Category

class CategoryController extends Controller
{
    /**
     * Muestra una lista de las categorías.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $categories = Category::all(); // Obtiene todas las categorías
        return view('admin.categories.index', compact('categories')); // Devuelve la vista con las categorías
    }

    /**
     * Muestra el formulario para crear una nueva categoría.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.categories.create'); // Devuelve la vista para crear una nueva categoría
    }

    /**
     * Almacena una nueva categoría en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255', // Validación de la categoría
        ]);

        Category::create($request->only('name')); // Crea la categoría
        return redirect()->route('admin.categories.index')->with('success', 'Categoría creada con éxito.'); // Redirige con mensaje
    }

    /**
     * Muestra el formulario para editar la categoría especificada.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\View\View
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category')); // Devuelve la vista para editar la categoría
    }

    /**
     * Actualiza la categoría especificada en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255', // Validación de la categoría
        ]);

        $category->update($request->only('name')); // Actualiza la categoría
        return redirect()->route('admin.categories.index')->with('success', 'Categoría actualizada con éxito.'); // Redirige con mensaje
    }

    /**
     * Elimina la categoría especificada de la base de datos.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Category $category)
    {
        $category->delete(); // Elimina la categoría
        return redirect()->route('admin.categories.index')->with('success', 'Categoría eliminada con éxito.'); // Redirige con mensaje
    }
}
