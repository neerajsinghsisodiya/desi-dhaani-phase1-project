<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><meta name="csrf-token" content="{{ csrf_token() }}"><title>{{ config('app.name', 'Desi Dhaani') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#f8f1e4] text-[#2f261b]">
    <div class="min-h-screen flex items-center justify-center px-5 py-12 relative overflow-hidden"><div class="absolute inset-0 bg-gradient-to-br from-[#f8f1e4] via-[#fbf5e9] to-[#ead7b9]"></div><div class="relative w-full max-w-[350px]"><a href="{{ route('home') }}" class="block text-center mb-8"><span class="block dd-serif text-3xl text-[#4b2e15] uppercase tracking-wide">Desi Dhaani</span><span class="block text-sm italic text-[#967046] mt-1">Taste the Soul of Rajasthan</span></a><div class="bg-white/95 border border-[#eadfce] rounded-2xl shadow-xl px-5 py-7"><div class="w-full max-w-[280px] mx-auto">{{ $slot }}</div></div><p class="text-center text-xs text-[#756653] mt-6">Pure traditions. Honest flavours.</p></div></div>
</body>
</html>
