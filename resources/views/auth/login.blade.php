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

        <div class="mt-6 flex items-center justify-center gap-4">
            <div class="h-px bg-white/10 flex-1"></div>
            <span class="text-xs text-gray-500 uppercase tracking-widest">OR</span>
            <div class="h-px bg-white/10 flex-1"></div>
        </div>

        <div class="mt-6">
            <a href="{{ route('auth.google') }}" class="w-full flex items-center justify-center gap-3 bg-white hover:bg-gray-100 text-gray-900 font-semibold py-3 rounded-xl transition-all active:scale-95">
                <svg class="w-5 h-5" viewBox="0 0 24 24">
                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                    <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                    <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z" fill="#FBBC05"/>
                    <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                </svg>
                Continue with Google
            </a>
        </div>

        <div class="mt-6 text-center">
            <p class="text-sm text-gray-400">Don't have an account? <a href="{{ route('register') }}" class="text-blue-400 hover:text-blue-300 font-semibold">Register here</a></p>
        </div>
    </form>
</x-guest-layout>
