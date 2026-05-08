<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-8">
        <h2 class="text-3xl font-bold text-white">Welcome Back</h2>
        <p class="text-gray-400">Enter your credentials to access your garage.</p>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-300 mb-1">Email Address</label>
            <input id="email" class="block w-full bg-white/10 border-white/20 text-white focus:border-blue-500 focus:ring-blue-500 rounded-xl transition-all" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-6">
            <div class="flex justify-between mb-1">
                <label for="password" class="block text-sm font-medium text-gray-300">Password</label>
                @if (Route::has('password.request'))
                    <a class="text-xs text-blue-400 hover:text-blue-300 transition-colors" href="{{ route('password.request') }}">
                        Forgot?
                    </a>
                @endif
            </div>
            <input id="password" class="block w-full bg-white/10 border-white/20 text-white focus:border-blue-500 focus:ring-blue-500 rounded-xl transition-all"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-6">
            <label for="remember_me" class="inline-flex items-center group cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded-lg border-white/20 bg-white/10 text-blue-600 shadow-sm focus:ring-blue-500 focus:ring-offset-black" name="remember">
                <span class="ms-2 text-sm text-gray-400 group-hover:text-gray-200 transition-colors">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="mt-8">
            <button class="w-full bg-blue-600 hover:bg-blue-500 text-white font-bold py-3 rounded-xl shadow-lg shadow-blue-900/20 transition-all active:scale-95">
                {{ __('LOG IN') }}
            </button>
        </div>

        <div class="mt-6 text-center">
            <p class="text-sm text-gray-400">Don't have an account? <a href="{{ route('register') }}" class="text-blue-400 hover:text-blue-300 font-semibold">Register here</a></p>
        </div>
    </form>
</x-guest-layout>
