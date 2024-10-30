<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order; // Importa el modelo Order
use App\Models\OrderItem; // Importa el modelo OrderItem

class OrderController extends Controller
{
    /**
     * Muestra una lista de los pedidos.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $orders = Order::with('orderItems')->get(); // Obtiene todos los pedidos con sus items
        return view('admin.orders.index', compact('orders')); // Devuelve la vista con los pedidos
    }

    /**
     * Muestra el formulario para crear un nuevo pedido.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.orders.create'); // Devuelve la vista para crear un nuevo pedido
    }

    /**
     * Almacena un nuevo pedido en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'total' => 'required|numeric',
            'status' => 'required|string',
            // Validación para los items de pedido, puedes ajustarla según la estructura
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        // Crear el pedido
        $order = Order::create([
            'user_id' => $request->user_id,
            'total' => $request->total,
            'status' => $request->status,
        ]);

        // Crear los items del pedido
        foreach ($request->items as $item) {
            $order->orderItems()->create([
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
            ]);
        }

        return redirect()->route('admin.orders.index')->with('success', 'Pedido creado con éxito.'); // Redirige con mensaje
    }

    /**
     * Muestra el pedido especificado.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\View\View
     */
    public function show(Order $order)
    {
        $order->load('orderItems'); // Carga los items del pedido
        return view('admin.orders.show', compact('order')); // Devuelve la vista del pedido
    }

    /**
     * Muestra el formulario para editar el pedido especificado.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\View\View
     */
    public function edit(Order $order)
    {
        $order->load('orderItems'); // Carga los items del pedido
        return view('admin.orders.edit', compact('order')); // Devuelve la vista para editar el pedido
    }

    /**
     * Actualiza el pedido especificado en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'total' => 'required|numeric',
            'status' => 'required|string',
        ]);

        $order->total = $request->total;
        $order->status = $request->status;
        $order->save(); // Guarda los cambios

        return redirect()->route('admin.orders.index')->with('success', 'Pedido actualizado con éxito.'); // Redirige con mensaje
    }

    /**
     * Elimina el pedido especificado de la base de datos.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Order $order)
    {
        $order->delete(); // Elimina el pedido
        return redirect()->route('admin.orders.index')->with('success', 'Pedido eliminado con éxito.'); // Redirige con mensaje
    }
}