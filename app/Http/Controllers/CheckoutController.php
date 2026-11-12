<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function show(Request $request)
    {
        $cart = $request->session()->get('cart', []);
        abort_if(empty($cart), 302, redirect()->route('cart.index'));

        $products = Product::whereIn('id', array_keys($cart))->get();
        $total = $products->sum(fn ($p) => $p->price * $cart[$p->id]);

        return view('checkout.show', compact('products', 'cart', 'total'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'line1' => 'required|string|max:255',
            'line2' => 'nullable|string|max:255',
            'city' => 'required|string|max:120',
            'state' => 'required|string|max:120',
            'postal_code' => 'required|string|max:12',
            'phone' => 'required|string|max:20',
        ]);

        $cart = $request->session()->get('cart', []);
        abort_if(empty($cart), 302, redirect()->route('cart.index'));

        $order = DB::transaction(function () use ($data, $cart, $request) {
            $address = Address::create($data + ['user_id' => $request->user()->id]);

            $products = Product::whereIn('id', array_keys($cart))->get();

            foreach ($products as $product) {
                abort_unless($product->inStock($cart[$product->id]), 422, "{$product->name} no longer has enough stock.");
            }

            $order = Order::create([
                'user_id' => $request->user()->id,
                'status' => 'pending',
                'total' => $products->sum(fn ($p) => $p->price * $cart[$p->id]),
                'address_id' => $address->id,
            ]);

            foreach ($products as $product) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $cart[$product->id],
                    'unit_price' => $product->price,
                ]);
            }

            return $order;
        });

        return response()->json([
            'local_order_id' => $order->id,
            'amount' => $order->total,
            'currency' => 'INR',
        ]);
    }

    public function success(Order $order)
    {
        abort_unless($order->user_id === auth()->id(), 403);

        return view('checkout.success', compact('order'));
    }
}
