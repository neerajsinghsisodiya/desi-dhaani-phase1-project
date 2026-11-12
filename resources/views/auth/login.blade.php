<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-7"><p class="dd-gold uppercase tracking-[.2em] text-xs">Welcome back</p><h1 class="dd-serif text-3xl text-[#3f2b1a] mt-2">Sign in to your account</h1><p class="text-sm text-[#756653] mt-2">Continue your journey with Desi Dhaani.</p></div>
    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email address')" class="text-sm text-[#4b3a29]" />
            <x-text-input id="email" class="block mt-2 w-full border-[#ddcfba] rounded-lg p-3" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" class="text-sm text-[#4b3a29]" />

            <x-text-input id="password" class="block mt-2 w-full border-[#ddcfba] rounded-lg p-3"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center text-sm text-[#756653]">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-between pt-1">
            @if (Route::has('password.request'))
                <a class="text-sm text-[#315a2a] hover:underline" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="bg-[#315a2a] hover:bg-[#24471f] px-5 py-3 rounded-lg">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
    <p class="text-center text-sm text-[#756653] mt-7">New here? <a href="{{ route('register') }}" class="text-[#315a2a] font-semibold hover:underline">Create an account</a></p>
</x-guest-layout>
