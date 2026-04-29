<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>AdVise AI - Login</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
        
        <!-- Scripts -->
        <script src="https://cdn.tailwindcss.com"></script>
        <style>
            body {
                font-family: 'Outfit', sans-serif;
                background: #0f172a;
                color: #f8fafc;
                background-image: 
                    radial-gradient(at 0% 0%, hsla(210,100%,15%,1) 0, transparent 50%), 
                    radial-gradient(at 100% 0%, hsla(230,100%,15%,1) 0, transparent 50%);
            }
            .glass {
                background: rgba(30, 41, 59, 0.7);
                backdrop-filter: blur(12px);
                border: 1px solid rgba(255, 255, 255, 0.1);
            }
            .gradient-text {
                background: linear-gradient(135deg, #38bdf8 0%, #818cf8 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
            }
            .btn-primary {
                background: linear-gradient(135deg, #38bdf8 0%, #818cf8 100%);
                transition: all 0.3s ease;
            }
            .btn-primary:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 20px rgba(56, 189, 248, 0.4);
            }
        </style>
    </head>
    <body class="antialiased min-h-screen flex items-center justify-center p-6">
        <div class="w-full max-w-md">
            <div class="text-center mb-10">
                <div class="text-4xl font-bold gradient-text mb-2">AdVise AI</div>
                <p class="text-gray-500 text-sm">Professional Ads Optimization Advisor</p>
            </div>
            
            <div class="glass p-8 rounded-[2.5rem] shadow-2xl relative overflow-hidden">
                <div class="absolute -top-24 -right-24 w-48 h-48 bg-sky-500/10 rounded-full blur-3xl"></div>
                <div class="absolute -bottom-24 -left-24 w-48 h-48 bg-indigo-500/10 rounded-full blur-3xl"></div>
                
                {{ $slot }}
            </div>

            <div class="mt-8 text-center text-gray-600 text-xs">
                &copy; 2026 AdVise AI. Built for Performance.
            </div>
        </div>
    </body>
</html>
