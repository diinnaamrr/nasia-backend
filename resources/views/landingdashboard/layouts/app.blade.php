<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Landing Dashboard') | NASIA Premium</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Cairo:wght@400;600;700;900&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        *, *::before, *::after {
            box-sizing: border-box;
        }

        :root {
            --primary: #6366f1;
            --primary-glow: rgba(99, 102, 241, 0.4);
            --secondary: #a855f7;
            --accent: #f43f5e;
            --sidebar-bg: #030712;
            --sidebar-hover: #111827;
            --top-nav-blur: rgba(255, 255, 255, 0.7);
            --bg-color: #f8fafc;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --white: #ffffff;
            --border-color: #e2e8f0;
            --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.1);
            --premium-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
            --transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
        }

        [dir="rtl"] {
            --font-family: 'Cairo', sans-serif;
        }

        body {
            margin: 0;
            padding: 0;
            background-color: var(--bg-color);
            color: var(--text-main);
            font-family: var(--font-family, 'Outfit', 'Inter', sans-serif);
            display: flex;
            min-height: 100vh;
            overflow-x: hidden;
            width: 100vw;
        }

        /* Sidebar Styling */
        .sidebar {
            width: 280px;
            background-color: var(--sidebar-bg);
            color: var(--white);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            transition: var(--transition);
            z-index: 1000;
            display: flex;
            flex-direction: column;
            border-right: 1px solid rgba(255,255,255,0.05);
        }

        [dir="rtl"] .sidebar {
            left: auto;
            right: 0;
            border-right: none;
            border-left: 1px solid rgba(255,255,255,0.05);
        }

        .sidebar-header {
            padding: 2.5rem 2rem;
            text-align: center;
        }

        .sidebar-header .logo {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--white);
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            background: linear-gradient(135deg, #6366f1, #a855f7);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .sidebar-menu {
            flex: 1;
            padding: 1rem;
            overflow-y: auto;
        }

        .menu-label {
            padding: 1.5rem 1rem 0.5rem;
            font-size: 0.7rem;
            font-weight: 800;
            color: #4b5563;
            text-transform: uppercase;
            letter-spacing: 1.5px;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 0.9rem 1.2rem;
            color: #94a3b8;
            text-decoration: none;
            transition: var(--transition);
            margin: 0.3rem 0;
            border-radius: 12px;
            font-weight: 500;
        }

        .sidebar-menu a i {
            margin-right: 14px;
            font-size: 1.2rem;
            width: 24px;
            text-align: center;
            transition: var(--transition);
        }

        [dir="rtl"] .sidebar-menu a i {
            margin-right: 0;
            margin-left: 14px;
        }

        .sidebar-menu a:hover {
            color: var(--white);
            background: rgba(255,255,255,0.05);
            transform: scale(1.02);
        }

        .sidebar-menu a.active {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: var(--white);
            box-shadow: 0 10px 15px -3px var(--primary-glow);
        }

        .sidebar-menu a.active i {
            transform: scale(1.1);
        }

        /* Top Navbar */
        .top-navbar {
            background: var(--top-nav-blur);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1.5rem;
            position: sticky;
            top: 0;
            z-index: 900;
            border-bottom: 1px solid var(--border-color);
        }

        .main-container {
            flex: 1;
            margin-left: 280px;
            display: flex;
            flex-direction: column;
            transition: var(--transition);
            min-width: 0;
            overflow-x: hidden;
        }

        [dir="rtl"] .main-container {
            margin-left: 0;
            margin-right: 280px;
        }

        .breadcrumb {
            font-weight: 500;
            font-size: 0.95rem;
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        /* Language Switcher */
        .lang-switcher {
            display: flex;
            background: #f1f5f9;
            padding: 5px;
            border-radius: 50px;
            border: 1px solid #e2e8f0;
        }

        .lang-btn {
            padding: 6px 18px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 700;
            text-decoration: none;
            color: #64748b;
            transition: var(--transition);
        }

        .lang-btn.active {
            background: white;
            color: var(--primary);
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 6px 12px;
            border-radius: 50px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            transition: var(--transition);
            cursor: pointer;
        }

        .user-profile:hover {
            border-color: var(--primary);
        }

        .content-area {
            padding: 1.5rem;
            max-width: 1600px;
            width: 100%;
            margin: 0 auto;
        }

        @media (min-width: 768px) {
            .top-navbar { padding: 0 2.5rem; }
            .content-area { padding: 3rem; }
        }

        /* Generic Improvements */
        .card {
            background: white;
            border-radius: 24px;
            box-shadow: var(--card-shadow);
            border: 1px solid var(--border-color);
            transition: var(--transition);
        }

        .card:hover {
            box-shadow: var(--premium-shadow);
            transform: translateY(-4px);
        }

        .btn {
            border-radius: 14px;
            font-weight: 700;
            padding: 0.8rem 1.8rem;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
        }

        @media (max-width: 992px) {
            .sidebar { width: 90px; }
            .sidebar-header span, .sidebar-menu a span, .menu-label { display: none; }
            .main-container { margin-left: 90px; }
            [dir="rtl"] .main-container { margin-right: 90px; }
        }
    </style>
    @stack('styles')
</head>
<body>
    <aside class="sidebar">
        <div class="sidebar-header">
            <a href="#" class="logo">
                <i class="fa-solid fa-cloud-bolt"></i> <span>{{ __('messages.NASIA') }}</span>
            </a>
        </div>
        <nav class="sidebar-menu">
            
            <div class="menu-label">{{ __('messages.Architecture') }}</div>
            <a href="{{ route('landingdashboard.departments.index') }}" class="{{ request()->routeIs('landingdashboard.departments.*') ? 'active' : '' }}">
                <i class="fa-solid fa-layer-group"></i> <span>{{ __('messages.Departments') }}</span>
            </a>
            <a href="{{ route('landingdashboard.stock-units.index') }}" class="{{ request()->routeIs('landingdashboard.stock-units.*') ? 'active' : '' }}">
                <i class="fa-solid fa-cubes"></i> <span>{{ __('messages.Stock Units') }}</span>
            </a>

            <div class="menu-label">{{ __('messages.Campaigns') }}</div>
            <a href="{{ route('landingdashboard.flash-sales.index') }}" class="{{ request()->routeIs('landingdashboard.flash-sales.*') ? 'active' : '' }}">
                <i class="fa-solid fa-fire-flame-curved"></i> <span>{{ __('messages.Flash Sales') }}</span>
            </a>
            
            <div class="menu-label">{{ __('messages.Navigation') }}</div>
            <a href="{{ route('home') }}">
                <i class="fa-solid fa-arrow-up-right-from-square"></i> <span>{{ __('messages.Live Preview') }}</span>
            </a>
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="color: #f87171;">
                <i class="fa-solid fa-power-off"></i> <span>{{ __('messages.Logout') }}</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="GET" style="display: none;"></form>
        </nav>
    </aside>

    <div class="main-container">
        <header class="top-navbar">
            <div class="breadcrumb">
                <span style="color: var(--text-muted)">{{ __('messages.NASIA') }} /</span> @yield('title')
            </div>
            
            <div class="nav-actions">
                <div class="lang-switcher">
                    <a href="{{ route('lang', ['en']) }}" class="lang-btn {{ app()->getLocale() == 'en' ? 'active' : '' }}">EN</a>
                    <a href="{{ route('lang', ['ar']) }}" class="lang-btn {{ app()->getLocale() == 'ar' ? 'active' : '' }}">AR</a>
                </div>

                <div class="user-profile">
                    <img src="https://ui-avatars.com/api/?name=Admin&background=6366f1&color=fff&bold=true" alt="Admin" style="width: 32px; border-radius: 50%;">
                    <div style="display: flex; flex-direction: column;">
                        <span style="font-weight: 800; font-size: 0.8rem; line-height: 1;">{{ __('messages.Genesis Admin') }}</span>
                        <span style="font-size: 0.65rem; color: var(--text-muted); font-weight: 700;">{{ __('messages.SUPREME ACCESS') }}</span>
                    </div>
                </div>
            </div>
        </header>

        <main class="content-area">
            @if(session('success'))
                <div style="background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; padding: 1.2rem; border-radius: 18px; margin-bottom: 2rem; display: flex; align-items: center; gap: 15px; font-weight: 600;">
                    <i class="fa-solid fa-circle-check" style="font-size: 1.2rem;"></i> {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div style="background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 1.2rem; border-radius: 18px; margin-bottom: 2rem; font-weight: 600;">
                    <ul style="margin: 0; padding-left: 1.5rem;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "Precision Select",
                allowClear: true
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
