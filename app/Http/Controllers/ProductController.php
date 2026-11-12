<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->input('q', ''));
        $products = Product::where('is_active', true)
            ->when($search, fn ($query) => $query->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('type', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            }))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('products.index', compact('products', 'search'));
    }

    public function show(Product $product)
    {
        abort_unless($product->is_active, 404);

        return view('products.show', compact('product'));
    }
}
