<!DOCTYPE html>
<html lang="th" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Esvance Shop — สโตร์ไอดีเกมอันดับ 1</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@300;400;500;600;700&family=Kanit:ital,wght@0,400;0,600;0,800;1,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Noto Sans Thai', 'sans-serif'],
                        display: ['Kanit', 'sans-serif']
                    },
                    colors: {
                        esv: { bg: '#f4f5f7', primary: '#6b21a8', secondary: '#a855f7', accent: '#d946ef', dark: '#1e1b4b' }
                    }
                }
            }
        }
    </script>
    <style>
        body { background-color: #f4f5f7; color: #333; }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f4f5f7; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        .white-nav { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
    </style>
</head>
<body class="font-sans antialiased overflow-x-hidden">

    @include('partials.navbar')

    <main class="min-h-screen">
        @yield('content')
    </main>

    <footer class="mt-20 py-8 text-center text-slate-400 text-sm">
        <p>© 2026 Esvance Shop. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
