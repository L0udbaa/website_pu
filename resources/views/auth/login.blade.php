<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-6 p-4 rounded-xl bg-indigo-50 border border-indigo-100 text-indigo-700 shadow-sm" :status="session('status')" />

    <div class="max-w-md mx-auto bg-white/80 backdrop-blur-md p-8 rounded-2xl shadow-xl border border-gray-100">
        <!-- Optional Decorative Header -->
        <div class="mb-6 text-center">
            <h2 class="text-2xl font-bold text-gray-800 tracking-tight">Selamat Datang Kembali</h2>
            <p class="text-sm text-gray-500 mt-1">Silakan masuk ke akun Anda</p>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" class="text-sm font-semibold text-gray-700" />
                <x-text-input id="email" 
                    class="block mt-1.5 w-full rounded-xl border-gray-200 bg-gray-50/50 px-4 py-3 text-gray-800 shadow-sm transition-all duration-200 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-500/20" 
                    type="email" 
                    name="email" 
                    :value="old('email')" 
                    required 
                    autofocus 
                    autocomplete="username" 
                    placeholder="nama@email.com" />
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-rose-500" />
            </div>

            <!-- Password -->
            <div class="mt-5">
                <x-input-label for="password" :value="__('Password')" class="text-sm font-semibold text-gray-700" />

                <x-text-input id="password" 
                    class="block mt-1.5 w-full rounded-xl border-gray-200 bg-gray-50/50 px-4 py-3 text-gray-800 shadow-sm transition-all duration-200 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-500/20"
                    type="password"
                    name="password"
                    required 
                    autocomplete="current-password" 
                    placeholder="••••••••" />

                <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-rose-500" />
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between mt-5">
                <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                    <input id="remember_me" type="checkbox" class="rounded-md border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 focus:ring-offset-0 transition-colors duration-200 cursor-pointer" name="remember">
                    <span class="ms-2 text-sm text-gray-600 group-hover:text-gray-900 transition-colors duration-200">{{ __('Remember me') }}</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="text-sm font-medium text-indigo-600 hover:text-indigo-800 hover:underline transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 rounded-md" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
            </div>

            <div class="mt-6">
                <x-primary-button class="w-full justify-center py-3 px-4 bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 active:scale-[0.98] text-white font-semibold rounded-xl shadow-lg shadow-indigo-500/25 hover:shadow-indigo-500/35 transition-all duration-200 border-none">
                    {{ __('Log in') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>