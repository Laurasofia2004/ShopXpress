<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;

class CartController extends Controller
{
    /**
     * Muestra los elementos en el carrito de compras.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Supón que el carrito se basa en el ID de usuario autenticado
        $cart = Cart::where('user_id', auth()->id())->first();

        // Si el carrito está vacío, devuelve un carrito vacío o crea uno nuevo
        $cartItems = $cart ? $cart->cartItems : [];

        // Calcula el total del carrito
        $total = $cartItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });

        return view('cart.index', compact('cartItems', 'total'));
    }

    /**
     * Agrega un producto al carrito.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);

        // Obtiene el carrito del usuario actual o crea uno nuevo
        $cart = Cart::firstOrCreate([
            'user_id' => auth()->id()
        ]);

        // Busca si el producto ya está en el carrito
        $cartItem = $cart->cartItems()->where('product_id', $product->id)->first();

        if ($cartItem) {
            // Si el producto ya existe en el carrito, aumenta la cantidad
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            // Agrega el nuevo producto al carrito
            $cart->cartItems()->create([
                'product_id' => $product->id,
                'quantity' => $request->quantity
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Producto agregado al carrito.');
    }

    /**
     * Actualiza la cantidad de un producto en el carrito.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cartItem = CartItem::findOrFail($id);

        // Verifica si el item pertenece al carrito del usuario actual
        if ($cartItem->cart->user_id !== auth()->id()) {
            abort(403);
        }

        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        return redirect()->route('cart.index')->with('success', 'Cantidad actualizada.');
    }

    /**
     * Elimina un producto del carrito.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $cartItem = CartItem::findOrFail($id);

        // Verifica si el item pertenece al carrito del usuario actual
        if ($cartItem->cart->user_id !== auth()->id()) {
            abort(403);
        }

        $cartItem->delete();

        return redirect()->route('cart.index')->with('success', 'Producto eliminado del carrito.');
    }

    /**
     * Vacía el carrito de compras.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function clear()
    {
        $cart = Cart::where('user_id', auth()->id())->first();

        if ($cart) {
            $cart->cartItems()->delete();
        }

        return redirect()->route('cart.index')->with('success', 'Carrito vaciado.');
    }
}
