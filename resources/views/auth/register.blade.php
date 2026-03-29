<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'IMACAB') }} - Inscription</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Animations personnalisées */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out forwards;
        }
        .animate-slide-in-right {
            animation: slideInRight 0.6s ease-out forwards;
        }
        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.2s; }

        /* Effet de focus personnalisé */
        .input-icon {
            transition: all 0.2s ease;
        }
        .input-icon:focus-within {
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
        }

        /* Bouton personnalisé */
        .btn-gradient {
            background: linear-gradient(135deg, #4f46e5, #6366f1);
            transition: all 0.3s ease;
        }
        .btn-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.4);
        }

        /* Image de fond avec overlay */
        .left-bg {
            background-image: url('{{ asset('images/register-bg.png') }}');
            background-size: cover;
            background-position: center;
            position: relative;
        }
        .left-bg::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.6);
            z-index: 0;
        }
        .left-bg > * {
            position: relative;
            z-index: 1;
        }
    </style>
</head>
<body class="font-sans antialiased bg-gradient-to-br from-indigo-50 via-white to-indigo-100">
    <!-- Navbar -->
    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <img src="{{ asset('images/image1.png') }}" alt="IMACAB" class="h-12">
                <span class="text-xl font-bold text-gray-800">IMACAB</span>
            </div>
            <div class="hidden md:flex space-x-8">
                <a href="{{ route('home') }}" class="text-gray-700 hover:text-[#970d0d]">Accueil</a>
                <a href="#a-propos" class="text-gray-700 hover:text-[#970d0d]">À propos</a>
                <a href="#directions" class="text-gray-700 hover:text-[#970d0d]">Nos métiers</a>
                <a href="#offres" class="text-gray-700 hover:text-[#970d0d]">Offres</a>
                <a href="#contact" class="text-gray-700 hover:text-[#970d0d]">Contact</a>
            </div>
            <div class="space-x-3">
                @guest
                    <a href="{{ route('login') }}" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-100 transition">Connexion</a>
                    <a href="{{ route('register') }}" class="px-4 py-2 bg-[#970d0d] text-white rounded-lg hover:bg-[#7a0a0a] transition">Inscription</a>
                @else
                    @if(Auth::user()->role == 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 bg-[#970d0d] text-white rounded-lg hover:bg-[#7a0a0a] transition">Dashboard Admin</a>
                    @elseif(Auth::user()->role == 'responsable')
                        <a href="{{ route('responsable.dashboard') }}" class="px-4 py-2 bg-[#970d0d] text-white rounded-lg hover:bg-[#7a0a0a] transition">Dashboard Responsable</a>
                    @else
                        <a href="{{ route('candidat.dashboard') }}" class="px-4 py-2 bg-[#970d0d] text-white rounded-lg hover:bg-[#7a0a0a] transition">Mon espace</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-100 transition">Déconnexion</button>
                    </form>
                @endguest
            </div>
        </div>
    </nav>
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl w-full bg-white rounded-2xl shadow-2xl overflow-hidden grid grid-cols-1 lg:grid-cols-2 animate-fade-in-up">
            <!-- Côté gauche avec photo de fond -->
            <div class="relative hidden lg:block left-bg p-8 text-white">
                <div class="flex flex-col justify-between h-full">
                    <div>
                        <h2 class="text-3xl font-bold leading-tight mb-4">
                            Rejoignez la communauté<br>
                            IMACAB
                        </h2>
                        <p class="text-indigo-100 text-lg">
                            Créez votre espace candidat et accédez à des centaines d’offres d’emploi.
                        </p>
                    </div>
                    <div class="mt-auto pt-12">
                        <div class="flex items-center space-x-4 text-indigo-200">
                            <i class="fas fa-check-circle"></i>
                            <span>Accès illimité aux offres</span>
                        </div>
                        <div class="flex items-center space-x-4 text-indigo-200 mt-2">
                            <i class="fas fa-check-circle"></i>
                            <span>Suivi de vos candidatures</span>
                        </div>
                        <div class="flex items-center space-x-4 text-indigo-200 mt-2">
                            <i class="fas fa-check-circle"></i>
                            <span>Notifications en temps réel</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Côté formulaire (colonne de droite) -->
            <div class="p-8 sm:p-12 lg:p-10 animate-slide-in-right delay-1">
                <div class="text-center mb-8 lg">
                    <img src="{{ asset('images/image1.png') }}" alt="IMACAB" class="h-12 mx-auto">
                    <h2 class="mt-4 text-2xl font-bold text-gray-900">Créer un compte</h2>
                    <p class="mt-1 text-sm text-gray-600">Rejoignez notre plateforme</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    <!-- Nom complet (2 colonnes) -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Nom -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nom <span class="text-red-500">*</span></label>
                            <div class="relative input-icon border border-gray-300 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-user text-gray-400"></i>
                                </div>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                       class="pl-10 pr-4 py-2.5 w-full border-0 focus:ring-0 focus:outline-none"
                                       placeholder="Dupont">
                            </div>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Prénom -->
                        <div>
                            <label for="prenom" class="block text-sm font-medium text-gray-700 mb-1">Prénom</label>
                            <div class="relative input-icon border border-gray-300 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-user text-gray-400"></i>
                                </div>
                                <input type="text" name="prenom" id="prenom" value="{{ old('prenom') }}"
                                       class="pl-10 pr-4 py-2.5 w-full border-0 focus:ring-0 focus:outline-none"
                                       placeholder="Jean">
                            </div>
                            @error('prenom')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Adresse email <span class="text-red-500">*</span></label>
                        <div class="relative input-icon border border-gray-300 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-gray-400"></i>
                            </div>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                   class="pl-10 pr-4 py-2.5 w-full border-0 focus:ring-0 focus:outline-none"
                                   placeholder="jean.dupont@exemple.com">
                        </div>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Téléphone -->
                    <div>
                        <label for="telephone" class="block text-sm font-medium text-gray-700 mb-1">Téléphone</label>
                        <div class="relative input-icon border border-gray-300 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-phone-alt text-gray-400"></i>
                            </div>
                            <input type="tel" name="telephone" id="telephone" value="{{ old('telephone') }}"
                                   class="pl-10 pr-4 py-2.5 w-full border-0 focus:ring-0 focus:outline-none"
                                   placeholder="+212 6 12 34 56 78">
                        </div>
                        @error('telephone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Mot de passe -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Mot de passe <span class="text-red-500">*</span></label>
                        <div class="relative input-icon border border-gray-300 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                            <input type="password" name="password" id="password" required
                                   class="pl-10 pr-4 py-2.5 w-full border-0 focus:ring-0 focus:outline-none"
                                   placeholder="••••••••">
                        </div>
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirmation -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirmation <span class="text-red-500">*</span></label>
                        <div class="relative input-icon border border-gray-300 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-check-circle text-gray-400"></i>
                            </div>
                            <input type="password" name="password_confirmation" id="password_confirmation" required
                                   class="pl-10 pr-4 py-2.5 w-full border-0 focus:ring-0 focus:outline-none"
                                   placeholder="••••••••">
                        </div>
                    </div>

                    <!-- Bouton d'inscription -->
                    <div class="pt-2">
                        <button type="submit" class="btn-gradient w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-md text-white font-semibold focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all">
                            <i class="fas fa-user-plus mr-2"></i> Créer mon compte
                        </button>
                    </div>

                    <!-- Lien vers connexion -->
                    <p class="text-center text-sm text-gray-600 mt-4">
                        Déjà inscrit ?
                        <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                            Connectez-vous
                        </a>
                    </p>
                </form>

                <!-- Footer simple -->
                <div class="text-center text-xs text-gray-400 mt-8 pt-4 border-t border-gray-100">
                    &copy; {{ date('Y') }} IMACAB. Tous droits réservés.
                </div>
            </div>
        </div>
    </div>
    <!-- Footer amélioré -->
<footer id="contact" class="bg-gray-900 text-gray-300 py-12 border-t border-gray-800">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Colonne 1 : Logo et adresse -->
            <div>
                <div class="flex items-center space-x-3 mb-4">
                    <img src="{{ asset('images/image.png') }}" alt="IMACAB" class="h-12 w-auto">
                    <span class="text-xl font-bold text-white">IMACAB</span>
                </div>
                <p class="text-sm leading-relaxed">
                    Bd Ahl Loghlam, Q.I. Sidi Moumen 20630<br>
                    Casablanca - Maroc
                </p>
                <div class="mt-4 space-y-2 text-sm">
                    <p><i class="fas fa-phone-alt w-5 text-[#970d0d]"></i> +212 (05) 22 76 40 00 / 20 / 40</p>
                    <p><i class="fas fa-fax w-5 text-[#970d0d]"></i> +212 (05) 22 76 40 10</p>
                    <p><i class="fas fa-envelope w-5 text-[#970d0d]"></i> imacab@imacab.ma</p>
                </div>
            </div>

            <!-- Colonne 2 : Liens utiles -->
            <div>
                <h4 class="text-lg font-semibold text-white mb-4">Liens utiles</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="#directions" class="hover:text-[#970d0d] transition">Nos métiers</a></li>
                    <li><a href="#a-propos" class="hover:text-[#970d0d] transition">À propos</a></li>
                    <li><a href="#offres" class="hover:text-[#970d0d] transition">Offres</a></li>
                    <li><a href="#contact" class="hover:text-[#970d0d] transition">Contactez‑nous</a></li>
                </ul>
            </div>

            <!-- Colonne 3 : Newsletter -->
            <div>
                <h4 class="text-lg font-semibold text-white mb-4">Newsletter</h4>
                <p class="text-sm mb-3">Recevez nos dernières offres d’emploi</p>
                <form action="#" method="POST" class="flex flex-col sm:flex-row gap-2">
                    <input type="email" placeholder="Votre email" class="flex-1 px-4 py-2 rounded-lg bg-gray-800 border border-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-[#970d0d]">
                    <button type="submit" class="bg-[#970d0d] hover:bg-[#7a0a0a] px-5 py-2 rounded-lg transition">S’abonner</button>
                </form>
            </div>

            <!-- Colonne 4 : Réseaux sociaux -->
            <div>
                <h4 class="text-lg font-semibold text-white mb-4">Suivez‑nous</h4>
                <div class="flex space-x-4">
                    <a href="#" class="text-2xl hover:text-[#970d0d] transition"><i class="fab fa-linkedin"></i></a>
                    <a href="#" class="text-2xl hover:text-[#970d0d] transition"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="text-2xl hover:text-[#970d0d] transition"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-2xl hover:text-[#970d0d] transition"><i class="fab fa-instagram"></i></a>
                </div>
                <div class="mt-6">
                    <p class="text-sm">Restez connecté pour ne rien manquer !</p>
                </div>
            </div>
        </div>

        <!-- Bas de page (copyright) -->
        <div class="text-center border-t border-gray-800 mt-10 pt-6 text-sm text-gray-500">
            &copy; {{ date('Y') }} IMACAB .
        </div>
    </div>
</footer>
</body>
</html>