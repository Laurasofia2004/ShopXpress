<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Muestra una lista de todos los pedidos del usuario.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Obtiene los pedidos del usuario autenticado
        $orders = Order::where('user_id', auth()->id())->orderBy('created_at', 'desc')->get();

        return view('orders.index', compact('orders'));
    }

    /**
     * Crea un nuevo pedido a partir del carrito de compras.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        // Inicia una transacción de base de datos
        DB::beginTransaction();

        try {
            $cart = Cart::where('user_id', auth()->id())->first();

            if (!$cart || $cart->cartItems->isEmpty()) {
                return redirect()->route('cart.index')->with('error', 'El carrito está vacío.');
            }

            // Crea el pedido
            $order = Order::create([
                'user_id' => auth()->id(),
                'total' => $cart->cartItems->sum(function ($item) {
                    return $item->quantity * $item->product->price;
                })
            ]);

            // Transfiere los items del carrito al pedido
            foreach ($cart->cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->product->price
                ]);
            }

            // Vacía el carrito del usuario
            $cart->cartItems()->delete();

            DB::commit();

            return redirect()->route('orders.show', $order->id)->with('success', 'Pedido realizado con éxito.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('cart.index')->with('error', 'Hubo un problema al realizar el pedido.');
        }
    }

    /**
     * Muestra los detalles de un pedido específico.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $order = Order::where('id', $id)
            ->where('user_id', auth()->id())
            ->with('orderItems.product')
            ->firstOrFail();

        return view('orders.show', compact('order'));
    }

    /**
     * Cancela un pedido.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cancel($id)
    {
        $order = Order::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        // Lógica de cancelación del pedido (cambiar estado, etc.)
        $order->status = 'cancelled';
        $order->save();

        return redirect()->route('orders.index')->with('success', 'Pedido cancelado.');
    }
}