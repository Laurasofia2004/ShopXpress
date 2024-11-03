<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Mostrar todas las órdenes
    public function index()
    {
        $orders = Order::all(); // Obtener todas las órdenes
        return view('orders.index', compact('orders')); // Pasar a la vista
    }

    // Mostrar un formulario para crear una nueva orden
    public function create()
    {
        return view('orders.create'); // Retornar la vista para crear una orden
    }

    // Almacenar una nueva orden
    public function store(Request $request)
    {
        // Validar y guardar la orden
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            // Otros campos necesarios
        ]);

        $order = Order::create($request->all()); // Crear la orden

        return redirect()->route('orders.index')->with('success', 'Orden creada exitosamente.');
    }

    // Mostrar detalles de una orden específica
    public function show($id)
    {
        $order = Order::findOrFail($id); // Obtener la orden por ID
        return view('orders.show', compact('order')); // Retornar la vista con detalles de la orden
    }

    // Mostrar un formulario para editar una orden existente
    public function edit($id)
    {
        $order = Order::findOrFail($id); // Obtener la orden por ID
        return view('orders.edit', compact('order')); // Retornar la vista para editar la orden
    }

    // Actualizar una orden existente
    public function update(Request $request, $id)
    {
        // Validar y actualizar la orden
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            // Otros campos necesarios
        ]);

        $order = Order::findOrFail($id);
        $order->update($request->all()); // Actualizar la orden

        return redirect()->route('orders.index')->with('success', 'Orden actualizada exitosamente.');
    }

    // Eliminar una orden
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete(); // Eliminar la orden

        return redirect()->route('orders.index')->with('success', 'Orden eliminada exitosamente.');
    }
}