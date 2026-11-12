<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Cart is stored in the session as: [product_id => quantity]
     * Simple and sufficient for Phase 1's traffic level — no DB table needed.
     */
    public function index(Request $request)
    {
        $cart = $request->session()->get('cart', []);

        $products = Product::whereIn('id', array_keys($cart))->get()
            ->map(function (Product $product) use ($cart) {
                $product->quantity = $cart[$product->id];
                return $product;
            });

        $total = $products->sum(fn ($p) => $p->price * $p->quantity);

        return view('cart.index', compact('products', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        $request->validate(['quantity' => 'nullable|integer|min:1|max:20']);
        $qty = $request->input('quantity', 1);

        abort_unless($product->inStock($qty), 422, 'This product is out of stock.');

        $cart = $request->session()->get('cart', []);
        $cart[$product->id] = ($cart[$product->id] ?? 0) + $qty;
        $request->session()->put('cart', $cart);

        return back()->with('status', "{$product->name} added to cart.");
    }

    public function remove(Request $request, Product $product)
    {
        $cart = $request->session()->get('cart', []);
        unset($cart[$product->id]);
        $request->session()->put('cart', $cart);

        return back()->with('status', 'Item removed from cart.');
    }
}
