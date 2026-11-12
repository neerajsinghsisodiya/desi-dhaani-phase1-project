<x-app-layout>
    <div class="max-w-3xl mx-auto py-10 px-4">
        <a href="{{ route('home') }}" class="text-sm underline">← Back to products</a>

        <div class="mt-6 border rounded-lg p-6 shadow-sm bg-white">
            <p class="text-sm uppercase tracking-wide text-gray-500">{{ $product->type }}</p>
            <h1 class="mt-2 text-3xl font-bold text-red-900">{{ $product->name }}</h1>
            <p class="mt-4 text-gray-700">{{ $product->description }}</p>
            <p class="mt-6 text-xl font-bold">₹{{ $product->priceInRupees() }}</p>

            @if ($product->stock > 0)
                <form action="{{ route('cart.add', $product) }}" method="POST" class="mt-6">
                    @csrf
                    <button type="submit" class="bg-red-900 text-white px-6 py-3 rounded hover:bg-red-800">
                        Add to Cart
                    </button>
                </form>
            @else
                <p class="mt-6 text-red-700">Out of stock</p>
            @endif
        </div>
    </div>
</x-app-layout>
