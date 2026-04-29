@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-12">
    <div class="text-center mb-16">
        <h1 class="text-5xl font-bold mb-4">Connect with <span class="gradient-text">Our Specialist</span></h1>
        <p class="text-gray-400 text-lg">Need help executing your AI recommendations? Reach out to our expert consultant directly.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Email Card -->
        <div class="glass p-8 rounded-[2rem] text-center border-white/5 hover:border-sky-500/30 transition-all group">
            <div class="w-16 h-16 bg-sky-500/10 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition">
                <svg class="w-8 h-8 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            </div>
            <h3 class="text-xl font-bold mb-2">Email</h3>
            <p class="text-gray-400 text-sm mb-6">Professional inquiries and support.</p>
            <a href="mailto:hznocounter@gmail.com" class="text-sky-400 font-bold hover:underline">hznocounter@gmail.com</a>
        </div>

        <!-- WhatsApp Card -->
        <div class="glass p-8 rounded-[2rem] text-center border-white/5 hover:border-emerald-500/30 transition-all group">
            <div class="w-16 h-16 bg-emerald-500/10 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition">
                <svg class="w-8 h-8 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
            </div>
            <h3 class="text-xl font-bold mb-2">WhatsApp</h3>
            <p class="text-gray-400 text-sm mb-6">Fast response for urgent execution.</p>
            <a href="https://wa.me/6285141142612" target="_blank" class="text-emerald-400 font-bold hover:underline">+62 851 4114 2612</a>
        </div>

        <!-- Instagram Card -->
        <div class="glass p-8 rounded-[2rem] text-center border-white/5 hover:border-pink-500/30 transition-all group">
            <div class="w-16 h-16 bg-pink-500/10 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition">
                <svg class="w-8 h-8 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
            </div>
            <h3 class="text-xl font-bold mb-2">Instagram</h3>
            <p class="text-gray-400 text-sm mb-6">Follow for more ads optimization tips.</p>
            <a href="https://instagram.com/azaa19_" target="_blank" class="text-pink-400 font-bold hover:underline">@azaa19_</a>
        </div>
    </div>

    <div class="mt-16 glass p-10 rounded-[2.5rem] border-sky-500/20 text-center relative overflow-hidden">
        <div class="absolute -top-24 -left-24 w-64 h-64 bg-sky-500/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-24 -right-24 w-64 h-64 bg-indigo-500/10 rounded-full blur-3xl"></div>
        
        <h2 class="text-2xl font-bold mb-4 relative z-10">Why consult with us?</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-left max-w-2xl mx-auto relative z-10">
            <div class="flex gap-4 items-start">
                <div class="w-6 h-6 bg-sky-500/20 rounded-full flex items-center justify-center text-sky-400 shrink-0">✓</div>
                <p class="text-gray-400 text-sm">Help implementing complex technical AI recommendations.</p>
            </div>
            <div class="flex gap-4 items-start">
                <div class="w-6 h-6 bg-sky-500/20 rounded-full flex items-center justify-center text-sky-400 shrink-0">✓</div>
                <p class="text-gray-400 text-sm">Reviewing your current creative assets and copywriting.</p>
            </div>
            <div class="flex gap-4 items-start">
                <div class="w-6 h-6 bg-sky-500/20 rounded-full flex items-center justify-center text-sky-400 shrink-0">✓</div>
                <p class="text-gray-400 text-sm">Advanced pixel setup and event tracking optimization.</p>
            </div>
            <div class="flex gap-4 items-start">
                <div class="w-6 h-6 bg-sky-500/20 rounded-full flex items-center justify-center text-sky-400 shrink-0">✓</div>
                <p class="text-gray-400 text-sm">Scaling strategies for high-performing campaigns.</p>
            </div>
        </div>
    </div>
</div>
@endsection
