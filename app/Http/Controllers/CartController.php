<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $cart = $user->cart()->with('cartItems.product')->first();

        return view('user.cart', compact('cart'));
    }

    public function add(Product $product)
    {
        $user = Auth::user();

        $cart = $user->cart()->firstOrCreate(['user_id' => $user->id]);

        $cartItem = $cart->cartItems()->where('product_id', $product->id)->first();

        if ($cartItem) {
            $cartItem->quantity += 1;
            $cartItem->save();
        } else {
            $cart->cartItems()->create([
                'product_id' => $product->id,
                'quantity' => 1,
            ]);
        }

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    public function update(Request $request, CartItem $cartItem)
    {
        $action = $request->input('action');

        if ($action === 'increment') {
            $cartItem->quantity += 1;
        } elseif ($action === 'decrement' && $cartItem->quantity > 1) {
            $cartItem->quantity -= 1;
        }

        $cartItem->save();

        return redirect()->route('cart.index')->with('success', 'Kuantitas berhasil diperbarui.');
    }

    public function remove(CartItem $cartItem)
    {
        $cartItem->delete();

        return redirect()->route('cart.index')->with('success', 'Produk berhasil dihapus dari keranjang.');
    }
}