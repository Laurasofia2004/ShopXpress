<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    /**
     * Muestra una lista de todos los productos.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Obtiene todos los productos con paginación de 10 elementos por página
        $products = Product::paginate(10);

        return view('products.index', compact('products'));
    }

    /**
     * Muestra el formulario para crear un nuevo producto.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Obtiene todas las categorías para seleccionar en el formulario de creación
        $categories = Category::all();

        return view('products.create', compact('categories'));
    }

    /**
     * Almacena un producto recién creado en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Valida los datos del formulario
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        // Crea el nuevo producto en la base de datos
        Product::create($request->all());

        // Redirecciona con un mensaje de éxito
        return redirect()->route('products.index')->with('success', 'Producto creado exitosamente.');
    }

    /**
     * Muestra un producto específico.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        // Encuentra el producto o lanza un error 404 si no existe
        $product = Product::findOrFail($id);

        return view('products.show', compact('product'));
    }

    /**
     * Muestra el formulario para editar un producto específico.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        // Encuentra el producto o lanza un error 404 si no existe
        $product = Product::findOrFail($id);

        // Obtiene todas las categorías para el formulario de edición
        $categories = Category::all();

        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Actualiza un producto específico en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // Valida los datos del formulario
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        // Encuentra y actualiza el producto
        $product = Product::findOrFail($id);
        $product->update($request->all());

        // Redirecciona con un mensaje de éxito
        return redirect()->route('products.index')->with('success', 'Producto actualizado exitosamente.');
    }

    /**
     * Elimina un producto específico de la base de datos.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        // Encuentra y elimina el producto
        $product = Product::findOrFail($id);
        $product->delete();

        // Redirecciona con un mensaje de éxito
        return redirect()->route('products.index')->with('success', 'Producto eliminado exitosamente.');
    }
}
