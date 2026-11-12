<x-app-layout>
    <div class="max-w-xl mx-auto py-16 px-4 text-center">
        <h1 class="text-3xl font-bold text-green-800 mb-4">Thank you!</h1>
        <p class="text-gray-600">
            Order #{{ $order->id }} is {{ $order->status }}.
            @if ($order->status !== 'paid')
                Payment is still being confirmed. Please contact us if your order does not update shortly.
            @endif
        </p>
        <a href="{{ route('home') }}" class="inline-block mt-6 underline">Continue shopping</a>
    </div>
</x-app-layout>
