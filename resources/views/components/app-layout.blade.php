<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Desi Dhaani') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="bg-[#3b2410] text-[#f7e8c7] text-center text-[10px] tracking-wide py-1.5">Free Shipping on orders above ₹999 &nbsp; | &nbsp; Taste of Rajasthan, Delivered to Your Doorstep</div>
    <header class="bg-[#fbf5e9] border-b border-[#e8dcc9] sticky top-0 z-20">
        <div class="max-w-6xl mx-auto px-5 py-4 flex justify-between items-center gap-5">
            <a href="{{ route('home') }}" class="min-w-max"><span class="block dd-serif text-2xl text-[#4b2e15] uppercase tracking-wide">Desi Dhaani</span><span class="block text-xs italic text-[#967046]">Taste the Soul of Rajasthan</span></a>
            <nav class="hidden md:flex items-center gap-8 text-sm text-[#493a2b]"><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'text-[#a56d20] border-b border-[#b57a24] pb-1' : '' }}">Home</a><a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.index') ? 'text-[#a56d20] border-b border-[#b57a24] pb-1' : '' }}">Products</a><a href="{{ route('home') }}#story">Our Story</a><a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'text-[#a56d20] border-b border-[#b57a24] pb-1' : '' }}">Contact</a></nav>
            <div class="flex items-center gap-3 text-[#493a2b]"><form action="{{ route('products.index') }}" method="GET" class="hidden sm:flex items-center border border-[#ddcfba] bg-white rounded-full px-4 py-2 text-sm text-[#8b7a63] w-44 lg:w-56"><input type="search" name="q" value="{{ request('q') }}" placeholder="Search products..." class="w-full bg-transparent border-0 p-0 text-sm text-[#493a2b] placeholder-[#9b8c79] focus:ring-0"><button type="submit" class="ml-2 text-xl font-semibold leading-none" aria-label="Search">⌕</button></form><a href="{{ route('cart.index') }}" aria-label="Open cart" title="Cart" class="text-[#315a2a] transition hover:text-[#24471f] hover:scale-110"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7"><path stroke-linecap="round" stroke-linejoin="round" d="M6.5 8.25h11l1.05 11H5.45l1.05-11ZM9 8.25V6.5a3 3 0 0 1 6 0v1.75"/></svg></a>
                @auth
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="text-xs">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="rounded border border-[#315a2a] bg-[#315a2a] px-5 py-2 text-sm text-white hover:bg-[#24471f]">Login</a>
                @endauth
            </nav>
        </div>
    </header>

    @if (session('status'))
        <div class="max-w-6xl mx-auto mt-4 px-5">
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded">{{ session('status') }}</div>
        </div>
    @endif

    <main>
        {{ $slot }}
    </main>
</body>
</html>
