<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-2xl font-bold">Welcome Back</h2>
        <p class="text-gray-400 text-sm mt-1">Please enter your details to sign in.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div class="space-y-2">
            <label class="block text-sm font-semibold text-gray-300">Email Address</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                   class="w-full bg-slate-800/50 border border-white/10 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-sky-500 transition text-white placeholder-gray-600"
                   placeholder="name@company.com">
            <x-input-error :messages="$errors->get('email')" class="text-red-400 text-xs mt-1" />
        </div>

        <!-- Password -->
        <div class="space-y-2">
            <div class="flex justify-between">
                <label class="block text-sm font-semibold text-gray-300">Password</label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-xs text-sky-400 hover:underline">Forgot password?</a>
                @endif
            </div>
            <input type="password" name="password" required autocomplete="current-password"
                   class="w-full bg-slate-800/50 border border-white/10 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-sky-500 transition text-white"
                   placeholder="••••••••">
            <x-input-error :messages="$errors->get('password')" class="text-red-400 text-xs mt-1" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <input id="remember_me" type="checkbox" class="rounded bg-slate-800 border-white/10 text-sky-500 focus:ring-sky-500" name="remember">
            <label for="remember_me" class="ms-2 text-sm text-gray-400">Remember this device</label>
        </div>

        <button type="submit" class="w-full btn-primary py-4 rounded-xl font-bold text-lg transition-all">
            Sign In
        </button>

        <div class="text-center mt-6">
            <p class="text-sm text-gray-500">Don't have an account? 
                <a href="{{ route('register') }}" class="text-sky-400 font-bold hover:underline">Register now</a>
            </p>
        </div>
    </form>
</x-guest-layout>
