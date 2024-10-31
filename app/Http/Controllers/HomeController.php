<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    /**
     * Muestra la página de inicio.
     * Carga productos destacados y categorías para la tienda.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Obtiene los productos destacados (los primeros 8 marcados como destacados)
        $featuredProducts = Product::where('is_featured', true)->take(8)->get();

        // Obtiene todas las categorías para mostrar en la página de inicio
        $categories = Category::all();

        // Retorna la vista de inicio con productos destacados y categorías
        return view('home.index', compact('featuredProducts', 'categories'));
    }

    /**
     * Muestra los productos por categoría.
     * Se utiliza para mostrar los productos en una categoría específica.
     *
     * @param  int  $categoryId
     * @return \Illuminate\View\View
     */
    public function category($categoryId)
    {
        // Encuentra la categoría actual usando el ID proporcionado
        $category = Category::findOrFail($categoryId);

        // Obtiene los productos de la categoría actual paginados de 12 en 12
        $products = Product::where('category_id', $categoryId)->paginate(12);

        // Retorna la vista de la categoría con productos relacionados
        return view('home.category', compact('category', 'products'));
    }

    /**
     * Muestra los detalles de un producto específico.
     * También carga productos relacionados dentro de la misma categoría.
     *
     * @param  int  $productId
     * @return \Illuminate\View\View
     */
    public function productDetails($productId)
    {
        // Encuentra el producto usando el ID proporcionado
        $product = Product::findOrFail($productId);

        // Obtiene productos relacionados de la misma categoría, excluyendo el producto actual
        $relatedProducts = Product::where('category_id', $product->category_id)
                                  ->where('id', '!=', $product->id)
                                  ->take(4)
                                  ->get();

        // Retorna la vista de detalles del producto junto con productos relacionados
        return view('home.product_details', compact('product', 'relatedProducts'));
    }

    /**
     * Muestra la página de preguntas frecuentes (FAQ).
     * Proporciona respuestas a preguntas comunes para los usuarios.
     *
     * @return \Illuminate\View\View
     */
    public function faq()
    {
        // Retorna la vista de preguntas frecuentes
        return view('home.faq');
    }

    /**
     * Muestra la página de contacto.
     * Permite a los usuarios enviar mensajes o consultas.
     *
     * @return \Illuminate\View\View
     */
    public function contact()
    {
        // Retorna la vista de contacto
        return view('home.contact');
    }

    /**
     * Procesa el formulario de contacto.
     * Almacena la consulta o mensaje del usuario en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function submitContact(Request $request)
    {
        // Validación del formulario de contacto
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        // Almacena el mensaje en la base de datos (asume que tienes un modelo Contact)
        Contact::create($request->all());

        // Redirecciona con un mensaje de éxito
        return redirect()->back()->with('success', 'Mensaje enviado exitosamente.');
    }
}
