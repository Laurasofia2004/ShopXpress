<?php

namespace App\Http\Controllers\Admin;

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventory; // Importa el modelo Inventory
use App\Models\Product; // Importa el modelo Product

class InventoryController extends Controller
{
    /**
     * Muestra una lista de los elementos del inventario.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $inventories = Inventory::with('product')->get(); // Obtiene todos los elementos del inventario con sus productos
        return view('admin.inventory.index', compact('inventories')); // Devuelve la vista con el inventario
    }

    /**
     * Muestra el formulario para crear un nuevo elemento del inventario.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $products = Product::all(); // Obtiene todos los productos
        return view('admin.inventory.create', compact('products')); // Devuelve la vista para crear un nuevo elemento
    }

    /**
     * Almacena un nuevo elemento del inventario en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        Inventory::create([
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
        ]);

        return redirect()->route('admin.inventory.index')->with('success', 'Elemento del inventario creado con éxito.'); // Redirige con mensaje
    }

    /**
     * Muestra el elemento del inventario especificado.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\View\View
     */
    public function show(Inventory $inventory)
    {
        return view('admin.inventory.show', compact('inventory')); // Devuelve la vista del elemento del inventario
    }

    /**
     * Muestra el formulario para editar el elemento del inventario especificado.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\View\View
     */
    public function edit(Inventory $inventory)
    {
        $products = Product::all(); // Obtiene todos los productos
        return view('admin.inventory.edit', compact('inventory', 'products')); // Devuelve la vista para editar el elemento
    }

    /**
     * Actualiza el elemento del inventario especificado en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Inventory $inventory)
    {
        $request->validate([
            'quantity' => 'required|integer|min:0', // Permite cero o más
        ]);

        $inventory->quantity = $request->quantity;
        $inventory->save(); // Guarda los cambios

        return redirect()->route('admin.inventory.index')->with('success', 'Elemento del inventario actualizado con éxito.'); // Redirige con mensaje
    }

    /**
     * Elimina el elemento del inventario especificado de la base de datos.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Inventory $inventory)
    {
        $inventory->delete(); // Elimina el elemento del inventario
        return redirect()->route('admin.inventory.index')->with('success', 'Elemento del inventario eliminado con éxito.'); // Redirige con mensaje
    }
}

