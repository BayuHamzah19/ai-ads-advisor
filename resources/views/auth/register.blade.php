<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-2xl font-bold">Create Account</h2>
        <p class="text-gray-400 text-sm mt-1">Join AdVise AI and start optimizing your ads.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div class="space-y-2">
            <label class="block text-sm font-semibold text-gray-300">Full Name</label>
            <input type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                   class="w-full bg-slate-800/50 border border-white/10 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-sky-500 transition text-white placeholder-gray-600"
                   placeholder="John Doe">
            <x-input-error :messages="$errors->get('name')" class="text-red-400 text-xs mt-1" />
        </div>

        <!-- Email Address -->
        <div class="space-y-2">
            <label class="block text-sm font-semibold text-gray-300">Email Address</label>
            <input type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                   class="w-full bg-slate-800/50 border border-white/10 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-sky-500 transition text-white placeholder-gray-600"
                   placeholder="name@company.com">
            <x-input-error :messages="$errors->get('email')" class="text-red-400 text-xs mt-1" />
        </div>

        <!-- Password -->
        <div class="space-y-2">
            <label class="block text-sm font-semibold text-gray-300">Password</label>
            <input type="password" name="password" required autocomplete="new-password"
                   class="w-full bg-slate-800/50 border border-white/10 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-sky-500 transition text-white"
                   placeholder="••••••••">
            <x-input-error :messages="$errors->get('password')" class="text-red-400 text-xs mt-1" />
        </div>

        <!-- Confirm Password -->
        <div class="space-y-2">
            <label class="block text-sm font-semibold text-gray-300">Confirm Password</label>
            <input type="password" name="password_confirmation" required autocomplete="new-password"
                   class="w-full bg-slate-800/50 border border-white/10 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-sky-500 transition text-white"
                   placeholder="••••••••">
            <x-input-error :messages="$errors->get('password_confirmation')" class="text-red-400 text-xs mt-1" />
        </div>

        <button type="submit" class="w-full btn-primary py-4 rounded-xl font-bold text-lg mt-4 transition-all">
            Get Started
        </button>

        <div class="text-center mt-6">
            <p class="text-sm text-gray-500">Already have an account? 
                <a href="{{ route('login') }}" class="text-sky-400 font-bold hover:underline">Sign in</a>
            </p>
        </div>
    </form>
</x-guest-layout>
