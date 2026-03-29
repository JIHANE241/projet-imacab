{{-- resources/views/layouts/admin.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>IMACAB Admin - {{ config('app.name') }}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />
    <!-- Heroicons (via Font Awesome) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Variables de couleurs - Thème lumineux */
        :root {
            --sidebar-bg: #ffffff;
            --sidebar-surface: #f9fafb;
            --sidebar-hover: #f1f5f9;
            --sidebar-active: #2563eb;
            --sidebar-active-bg: #eff6ff;
            --primary: #3b82f6;
            --primary-dark: #2563eb;
            --text-primary: #1e293b;
            --text-secondary: #475569;
            --border-light: #e2e8f0;
        }

        /* Animations */
        @keyframes slideIn {
            from { transform: translateX(-100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .animate-slide-in {
            animation: slideIn 0.4s ease-out forwards;
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.5s ease-out forwards;
            opacity: 0;
        }

        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.2s; }
        .delay-3 { animation-delay: 0.3s; }
        .delay-4 { animation-delay: 0.4s; }
        .delay-5 { animation-delay: 0.5s; }
        .delay-6 { animation-delay: 0.6s; }

        /* Style de la sidebar */
        .sidebar {
            background: var(--sidebar-bg);
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.05);
            border-right: 1px solid var(--border-light);
            position: fixed;
            height: 100%;
            width: 18rem;
            transition: all 0.3s ease;
        }

        .nav-link {
            transition: all 0.2s ease;
            border-radius: 10px;
            margin: 4px 8px;
            padding: 0.75rem 1rem;
            color: var(--text-secondary);
            font-weight: 500;
            position: relative;
            overflow: hidden;
        }

        .nav-link::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 0;
            background: linear-gradient(90deg, rgba(37, 99, 235, 0.08), transparent);
            transition: width 0.2s ease;
            z-index: 0;
        }

        .nav-link:hover::before {
            width: 100%;
        }

        .nav-link:hover {
            color: var(--text-primary);
            background-color: var(--sidebar-hover);
            transform: translateX(5px);
        }

        .nav-link-active {
            background: var(--sidebar-active-bg);
            color: var(--sidebar-active);
            font-weight: 600;
            border-left: 4px solid var(--sidebar-active);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
        }

        .nav-icon {
            transition: transform 0.2s, color 0.2s;
            width: 1.5rem;
            text-align: center;
            color: var(--text-secondary);
        }

        .nav-link:hover .nav-icon {
            transform: scale(1.1);
            color: var(--primary);
        }

        .nav-link-active .nav-icon {
            color: var(--sidebar-active);
        }

        /* Effet glass pour le header */
        .glass-header {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-light);
            position: sticky;
            top: 0;
            z-index: 40;
        }

        /* Badge de notification */
        .notification-badge {
            position: absolute;
            top: -6px;
            right: -6px;
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            font-size: 0.7rem;
            font-weight: 600;
            padding: 0.15rem 0.4rem;
            border-radius: 9999px;
            animation: pulse 1.5s infinite;
            box-shadow: 0 2px 6px rgba(239, 68, 68, 0.5);
        }

        /* Logo avec dégradé moderne */
        .logo-text {
            font-size: 1.25rem;
            font-weight: 800;
            background: linear-gradient(135deg, #4f46e5 0%, #3b82f6 50%, #06b6d4 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            letter-spacing: -0.02em;
            text-shadow: 0 2px 4px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }

        .logo-text:hover {
            background: linear-gradient(135deg, #3b82f6 0%, #4f46e5 100%);
            -webkit-background-clip: text;
            background-clip: text;
            transform: scale(1.02);
        }

        .logo-image {
            transition: transform 0.3s ease;
        }
        .logo-image:hover {
            transform: scale(1.05) rotate(2deg);
        }

        /* Scrollbar personnalisée */
        .sidebar-scroll::-webkit-scrollbar {
            width: 4px;
        }
        .sidebar-scroll::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        .sidebar-scroll::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        .sidebar-scroll::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
</head>

<body class="font-sans antialiased bg-gray-100" style="font-family: 'Plus Jakarta Sans', sans-serif;">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-72 sidebar shadow-2xl fixed h-full flex flex-col animate-slide-in">
            <!-- Logo animé avec style inspiré de l'image -->
            <div class="py-6 border-b border-gray-200 animate-fade-in-up delay-1 px-6">
                <div class="flex items-center">
                    <img src="{{ asset('images/image.png') }}" 
                         alt="IMACAB"
                         class="logo-image w-16 h-12 rounded-md object-cover shadow-sm mr-3">
                    <div class="leading-tight">
                        <p class="logo-text">
                            IMACAB
                        </p>
                        <p class="text-gray-500 text-xs font-medium">
                            Usine cables ingelec
                        </p>
                    </div>
                </div>
            </div>

            <!-- Menu Principal -->
            <div class="flex-1 overflow-y-auto py-4 px-2 sidebar-scroll">
                <div class="mb-6 animate-fade-in-up delay-2">
                    <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Menu Principal</p>
                    <nav class="mt-2 space-y-0.5">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link flex items-center {{ request()->routeIs('admin.dashboard') ? 'nav-link-active' : '' }}">
                            <i class="fas fa-tachometer-alt nav-icon mr-3"></i>
                            <span>Dashboard</span>
                        </a>
                        <a href="{{ route('admin.utilisateurs.index') }}" class="nav-link flex items-center {{ request()->routeIs('admin.utilisateurs.*') ? 'nav-link-active' : '' }}">
                            <i class="fas fa-users nav-icon mr-3"></i>
                            <span>Utilisateurs</span>
                        </a>
                        <a href="{{ route('admin.directions.index') }}" class="nav-link flex items-center {{ request()->routeIs('admin.directions.*') ? 'nav-link-active' : '' }}">
                            <i class="fas fa-building nav-icon mr-3"></i>
                            <span>Directions</span>
                        </a>
                    </nav>
                </div>

                <!-- Gestion -->
                <div class="mb-6 animate-fade-in-up delay-3">
                    <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Gestion</p>
                    <nav class="mt-2 space-y-0.5">
                        <a href="{{ route('admin.offres.index') }}" class="nav-link flex items-center {{ request()->routeIs('admin.offres.*') ? 'nav-link-active' : '' }}">
                            <i class="fas fa-briefcase nav-icon mr-3"></i>
                            <span>Offres d'emploi</span>
                        </a>
                        <a href="{{ route('admin.statistiques.index') }}" class="nav-link flex items-center {{ request()->routeIs('admin.statistiques.*') ? 'nav-link-active' : '' }}">
                            <i class="fas fa-chart-bar nav-icon mr-3"></i>
                            <span>Statistiques</span>
                        </a>
                        <a href="{{ route('admin.candidatures.index') }}" class="nav-link flex items-center {{ request()->routeIs('admin.candidatures.*') ? 'nav-link-active' : '' }}">
                            <i class="fas fa-file-alt nav-icon mr-3"></i>
                            <span>Candidatures</span>
                        </a>
                        <a href="{{ route('admin.entretiens.index') }}" class="nav-link flex items-center {{ request()->routeIs('admin.entretiens.*') ? 'nav-link-active' : '' }}">
                            <i class="fas fa-calendar-check nav-icon mr-3"></i>
                            <span>Entretiens</span>
                        </a>
                    </nav>
                </div>

                <!-- Configuration -->
                <div class="mb-6 animate-fade-in-up delay-4">
                    <nav class="space-y-0.5">
                        <a href="{{ route('admin.profil.edit') }}" class="nav-link flex items-center {{ request()->routeIs('admin.profil.*') ? 'nav-link-active' : '' }}">
                            <i class="fas fa-user-circle nav-icon mr-3"></i>
                            <span>Profil</span>
                        </a>
                        <a href="{{ route('admin.parametres.index') }}" class="nav-link flex items-center {{ request()->routeIs('admin.parametres.*') ? 'nav-link-active' : '' }}">
                            <i class="fas fa-cog nav-icon mr-3"></i>
                            <span>Paramètres</span>
                        </a>
                        <a href="{{ route('admin.archives.index') }}" class="nav-link flex items-center {{ request()->routeIs('admin.archives.*') ? 'nav-link-active' : '' }}">
                            <i class="fas fa-archive nav-icon mr-3"></i>
                            <span>Archives</span>
                        </a>
                    </nav>
                </div>
            </div>

            <!-- Profil utilisateur -->
            <div class="border-t border-gray-200 p-4 hover:bg-gray-50 transition-all animate-fade-in-up delay-5">
                <div class="flex items-center group">
                    <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-blue-600 rounded-full flex items-center justify-center text-white font-semibold text-lg shadow-md transition-transform group-hover:scale-110">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div class="ml-3 flex-1">
                        <p class="text-sm font-medium text-gray-800">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-gray-400 hover:text-gray-600 transition-colors">
                            <i class="fas fa-sign-out-alt text-lg"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <div class="flex-1 ml-72 animate-fade-in-up" style="animation-delay: 0.2s;">
            <!-- Header avec effet glass -->
            <header class="glass-header shadow-md border-b border-gray-200 sticky top-0 z-10">
                <div class="flex justify-between items-center px-8 py-4">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight tracking-tight">
                        @yield('header', 'Tableau de bord')
                    </h2>
                    <div class="flex items-center space-x-6">
                        <!-- Notifications pour admin -->
<div class="relative" x-data="{ open: false }">
    <button @click="open = !open" class="relative">
        <i class="fas fa-bell text-gray-500 text-xl cursor-pointer hover:text-indigo-600 transition-colors"></i>
        @php $unreadCount = Auth::user()->unreadNotifications->count(); @endphp
        @if($unreadCount > 0)
            <span class="notification-badge">{{ $unreadCount }}</span>
        @endif
    </button>
    <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-xl border border-gray-200 z-50">
        <div class="p-3 border-b border-gray-200">
            <p class="font-semibold text-gray-700">Notifications</p>
        </div>
        <div class="max-h-96 overflow-y-auto">
            @forelse(Auth::user()->notifications()->take(10)->get() as $notification)
                @php
                    $data = $notification->data;
                    $notificationType = $data['type'] ?? 'default';
                    $targetUrl = '#';
                    if ($notificationType === 'nouvelle_candidature' && isset($data['candidature_id'])) {
                        $targetUrl = route('admin.candidatures.show', $data['candidature_id']);
                    } elseif ($notificationType === 'candidature_commented' && isset($data['candidature_id'])) {
                        $targetUrl = route('admin.candidatures.show', $data['candidature_id']);
                    } elseif ($notificationType === 'new_offer' && isset($data['offre_id'])) {
                        $targetUrl = route('admin.offres.show', $data['offre_id']);
                    } elseif (isset($data['url'])) {
                        $targetUrl = $data['url'];
                    }
                @endphp
                <a href="{{ $targetUrl }}"
                   class="block p-3 border-b border-gray-100 hover:bg-gray-50 transition {{ $notification->read_at ? '' : 'bg-indigo-50' }}"
                   onclick="event.preventDefault(); document.getElementById('mark-read-{{ $notification->id }}').submit();">
                    <p class="text-sm text-gray-800">{{ $data['message'] ?? 'Notification' }}</p>
                    <p class="text-xs text-gray-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                </a>
                <form id="mark-read-{{ $notification->id }}" action="{{ route('notifications.markAsRead', $notification->id) }}" method="POST" class="hidden">
                    @csrf
                </form>
            @empty
                <p class="p-4 text-center text-gray-500">Aucune notification</p>
            @endforelse
        </div>
        <div class="p-2 border-t border-gray-200 text-center">
            <a href="{{ route('notifications.markAllRead') }}" class="text-xs text-indigo-600 hover:underline" onclick="event.preventDefault(); document.getElementById('mark-all-read').submit();">Marquer tout comme lu</a>
            <form id="mark-all-read" action="{{ route('notifications.markAllRead') }}" method="POST" class="hidden">
                @csrf
            </form>
        </div>
    </div>
</div>
                        <!-- Avatar utilisateur -->
                        <div class="w-9 h-9 bg-gradient-to-br from-indigo-500 to-blue-600 rounded-full flex items-center justify-center text-white font-semibold shadow-md">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-8 bg-gray-50 min-h-screen">
                @yield('content')
            </main>
        </div>
    </div>
    @stack('scripts')
</body>
</html>