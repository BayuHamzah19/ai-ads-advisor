<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Ads Advisor</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background: #0f172a;
            color: #f8fafc;
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
<body class="min-h-screen">
    <nav class="glass sticky top-0 z-50 px-6 py-4 flex justify-between items-center">
        <div class="text-2xl font-bold gradient-text">AdVise AI</div>
        <div class="flex gap-6 items-center">
            <a href="{{ route('dashboard') }}" class="hover:text-sky-400 transition">Dashboard</a>
            <a href="{{ route('analyses.index') }}" class="hover:text-sky-400 transition">History</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-gray-400 hover:text-white">Logout</button>
            </form>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-6 py-10">
        @yield('content')
    </main>

    <footer class="mt-20 py-10 border-t border-white/10 text-center text-gray-500 text-sm">
        &copy; 2026 AI Digital Ads Optimization Advisor. Built for Performance.
    </footer>
</body>
</html>
