<x-app-layout>
    <section class="dd-paper py-14"><div class="max-w-5xl mx-auto px-6"><p class="dd-gold uppercase tracking-[.25em] text-xs">Your selections</p><h1 class="dd-serif text-5xl text-[#3f2b1a] mt-2">Your Cart</h1><p class="text-base text-[#655849] mt-3">Review your products before checkout.</p></div></section>

    <section class="bg-[#f8f1e4] py-12"><div class="max-w-5xl mx-auto px-6">
        @if ($products->isEmpty())
            <div class="bg-white border border-[#eadfce] rounded-2xl p-12 text-center shadow-sm"><div class="text-5xl text-[#b57a24]">✦</div><h2 class="dd-serif text-3xl text-[#3f2b1a] mt-4">Your cart is empty</h2><p class="text-base text-[#756653] mt-3">Discover something special from our traditional kitchen.</p><a href="{{ route('products.index') }}" class="inline-block mt-7 bg-[#315a2a] text-white px-7 py-3 rounded text-sm hover:bg-[#24471f]">Browse Products →</a></div>
        @else
            <div class="grid lg:grid-cols-[1fr_330px] gap-7 items-start"><div class="bg-white border border-[#eadfce] rounded-2xl shadow-sm divide-y divide-[#eee3d3]">
                @foreach ($products as $product)
                    <div class="p-5 sm:p-6 flex items-center gap-5"><div class="dd-product-image w-24 h-24 rounded-xl flex items-center justify-center shrink-0"><div class="dd-placeholder w-12 h-16 rounded-t-2xl rounded-b-md border-2 border-[#b88239] flex items-end justify-center pb-1"><span class="text-[6px] text-center text-[#68451f]">IMAGE</span></div></div><div class="grow"><p class="text-xs uppercase tracking-widest text-[#a5793c]">{{ $product->type }}</p><h2 class="font-semibold text-base text-[#3f2b1a] mt-1">{{ $product->name }}</h2><p class="text-sm text-[#756653] mt-1">Qty: {{ $product->quantity }} × ₹{{ $product->priceInRupees() }}</p></div><form action="{{ route('cart.remove', $product) }}" method="POST">@csrf @method('DELETE')<button class="text-sm text-[#9b4b32] underline hover:no-underline">Remove</button></form></div>
                @endforeach
            </div><aside class="bg-[#315a2a] text-[#f8f1e4] rounded-2xl p-7 shadow-sm"><h2 class="dd-serif text-3xl">Order Summary</h2><div class="border-t border-[#6d8a65] mt-6 pt-5 flex justify-between text-base"><span>Total</span><strong class="text-xl text-[#f0c36d]">₹{{ number_format($total / 100, 2) }}</strong></div><a href="{{ route('checkout.show') }}" class="block text-center mt-7 bg-[#e4ad4b] text-[#3f2b1a] px-6 py-3 rounded font-semibold text-sm hover:bg-[#f0c36d]">@auth Proceed to Checkout → @else Login to Checkout → @endauth</a><a href="{{ route('products.index') }}" class="block text-center mt-5 text-sm underline">Continue shopping</a></aside></div>
        @endif
    </div></section>
</x-app-layout>
