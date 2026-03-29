{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.admin')

@section('header', 'Tableau de bord')

@push('styles')
<style>
    /* Variables de couleurs */
    :root {
        --primary: #3b82f6;
        --primary-dark: #2563eb;
        --success: #10b981;
        --warning: #f59e0b;
        --danger: #ef4444;
        --dark: #1f2937;
        --light: #f9fafb;
    }

    /* Animations */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes slideInRight {
        from { opacity: 0; transform: translateX(-20px); }
        to { opacity: 1; transform: translateX(0); }
    }

    .animate-fade-in-up {
        animation: fadeInUp 0.6s ease-out forwards;
        opacity: 0;
    }

    .animate-slide-in-right {
        animation: slideInRight 0.5s ease-out forwards;
        opacity: 0;
    }

    .delay-1 { animation-delay: 0.1s; }
    .delay-2 { animation-delay: 0.2s; }
    .delay-3 { animation-delay: 0.3s; }
    .delay-4 { animation-delay: 0.4s; }
    .delay-5 { animation-delay: 0.5s; }
    .delay-6 { animation-delay: 0.6s; }

    /* Cartes statistiques */
    .stat-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid rgba(255,255,255,0.1);
        position: relative;
        overflow: hidden;
    }

    .stat-card::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(255,255,255,0.2) 0%, transparent 50%);
        opacity: 0;
        transition: opacity 0.3s;
    }

    .stat-card:hover::after {
        opacity: 1;
    }

    .stat-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 30px -10px rgba(59, 130, 246, 0.4);
    }

    /* Éléments de liste */
    .list-item {
        transition: all 0.2s ease;
        border: 1px solid #e5e7eb;
        background: white;
    }

    .list-item:hover {
        background: #f8fafc;
        transform: translateX(5px);
        border-color: var(--primary);
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }

    /* Badges */
    .badge {
        transition: all 0.2s ease;
        display: inline-block;
    }

    .badge:hover {
        transform: scale(1.05);
        filter: brightness(0.95);
    }

    /* Boutons d'action rapide */
    .action-button {
        transition: all 0.3s ease;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        border: none;
        position: relative;
        overflow: hidden;
    }

    .action-button::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255,255,255,0.2);
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
    }

    .action-button:hover::before {
        width: 300px;
        height: 300px;
    }

    .action-button:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 25px -8px rgba(59, 130, 246, 0.5);
    }

    /* Titres de section */
    .section-title {
        position: relative;
        display: inline-block;
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 40px;
        height: 3px;
        background: var(--primary);
        border-radius: 2px;
    }
</style>
@endpush

@section('content')
    <!-- Cartes statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-8">
        <!-- Utilisateurs -->
        <div class="stat-card bg-gradient-to-br from-blue-600 to-blue-700 text-white p-5 rounded-xl shadow-xl animate-fade-in-up delay-1">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium opacity-90">Utilisateurs</p>
                    <p class="text-3xl font-bold">{{ $totalUtilisateurs }}</p>
                </div>
                <div class="bg-white/20 p-3 rounded-xl backdrop-blur-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs">
                <span class="bg-white/30 px-2.5 py-1 rounded-full font-medium">+12% ce mois</span>
                <svg class="w-4 h-4 ml-1 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                </svg>
            </div>
        </div>

        <!-- Offres -->
        <div class="stat-card bg-gradient-to-br from-indigo-600 to-indigo-700 text-white p-5 rounded-xl shadow-xl animate-fade-in-up delay-2">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium opacity-90">Offres</p>
                    <p class="text-3xl font-bold">{{ $totalOffres }}</p>
                </div>
                <div class="bg-white/20 p-3 rounded-xl backdrop-blur-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs">
                <span class="bg-white/30 px-2.5 py-1 rounded-full font-medium">+5% vs dernier mois</span>
            </div>
        </div>

        <!-- Candidatures -->
        <div class="stat-card bg-gradient-to-br from-purple-600 to-purple-700 text-white p-5 rounded-xl shadow-xl animate-fade-in-up delay-3">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium opacity-90">Candidatures</p>
                    <p class="text-3xl font-bold">{{ $totalCandidatures }}</p>
                </div>
                <div class="bg-white/20 p-3 rounded-xl backdrop-blur-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs">
                <span class="bg-white/30 px-2.5 py-1 rounded-full font-medium">+8%</span>
            </div>
        </div>
        <!-- Offres ouvertes -->
        <div class="stat-card bg-gradient-to-br from-green-600 to-green-700 text-white p-5 rounded-xl shadow-xl animate-fade-in-up delay-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium opacity-90">Offres ouvertes</p>
                    <p class="text-3xl font-bold">{{ $offresOuvertes }}</p>
                    
                </div>
                <div class="bg-white/20 p-3 rounded-xl backdrop-blur-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs">
                <span class="bg-white/30 px-2.5 py-1 rounded-full font-medium">+2%</span>
            </div>
        </div>

        <!-- Offres fermées -->
        <div class="stat-card bg-gradient-to-br from-amber-600 to-amber-700 text-white p-5 rounded-xl shadow-xl animate-fade-in-up delay-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium opacity-90">Offres fermées</p>
                    <p class="text-3xl font-bold">{{ $offresFermees }}</p>
                </div>
                <div class="bg-white/20 p-3 rounded-xl backdrop-blur-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs">
                <span class="bg-white/30 px-2.5 py-1 rounded-full font-medium">-3%</span>
            </div>
        </div>
    </div>

    <!-- Section : Responsables et Candidatures en attente -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Responsables en attente -->
        <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-all duration-300 animate-slide-in-right delay-1">
            <h3 class="section-title flex items-center">
                <span class="w-2 h-2 bg-yellow-400 rounded-full mr-2"></span>
                Responsables en attente
                <span class="ml-2 bg-yellow-100 text-yellow-800 text-xs font-medium px-2 py-0.5 rounded-full">{{ $responsablesEnAttente->count() }}</span>
            </h3>
            <div class="space-y-3">
                @forelse($responsablesEnAttente as $resp)
                    <div class="list-item flex items-center justify-between p-3 rounded-lg">
                        <div class="flex-1">
                            <p class="font-semibold text-gray-800">{{ $resp->name }}</p>
                            <p class="text-sm text-gray-500">{{ $resp->email }}</p>
                            @if($resp->direction)
                                <p class="text-xs text-gray-400 mt-1">Direction : {{ $resp->direction->nom }}</p>
                            @endif
                        </div>
                        <div class="flex gap-2">

    <!-- Accepter -->
    <form action="{{ route('admin.utilisateurs.valider', $resp->id) }}" method="POST">
        @csrf
        <button type="submit"
            class="bg-green-100 text-green-700 hover:bg-green-200 px-3 py-1.5 rounded-lg text-sm font-medium transition-all hover:scale-105 flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            Accepter
        </button>
    </form>

    <!-- Refuser -->
    <form action="{{ route('admin.utilisateurs.rejeter', $resp->id) }}" method="POST">
        @csrf
        <button type="submit"
            class="bg-red-100 text-red-700 hover:bg-red-200 px-3 py-1.5 rounded-lg text-sm font-medium transition-all hover:scale-105 flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
            Refuser
        </button>
    </form>

</div>

                    </div>
                @empty
                    <div class="text-center py-8 text-gray-500 bg-gray-50 rounded-lg">
                        <svg class="w-12 h-12 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p>Aucun responsable en attente</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Candidatures en attente -->
        <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-all duration-300 animate-slide-in-right delay-2">
            <h3 class="section-title flex items-center">
                <span class="w-2 h-2 bg-blue-400 rounded-full mr-2"></span>
                Candidatures en attente
                <span class="ml-2 bg-blue-100 text-blue-800 text-xs font-medium px-2 py-0.5 rounded-full">{{ $candidaturesEnAttente->count() }}</span>
            </h3>
            <div class="space-y-3">
                @forelse($candidaturesEnAttente as $c)
                    <div class="list-item flex items-center justify-between p-3 rounded-lg">
                        <div class="flex-1">
                            <p class="font-semibold text-gray-800">{{ $c->candidat->name }}</p>
                            <p class="text-sm text-gray-500">{{ $c->candidat->email }}</p>
                            <p class="text-xs text-gray-400 mt-1">Offre : {{ $c->offre->titre }}</p>
                        </div>
                        <div class="flex gap-2 items-center">
                            <form action="{{ route('admin.candidatures.accepter', $c) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="bg-green-100 text-green-700 hover:bg-green-200 px-3 py-1.5 rounded-lg text-sm font-medium transition-all hover:scale-105 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                    Accepter
                                </button>
                            </form>
                            <form action="{{ route('admin.candidatures.refuser', $c) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="bg-red-100 text-red-700 hover:bg-red-200 px-3 py-1.5 rounded-lg text-sm font-medium transition-all hover:scale-105 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                    Refuser
                                </button>
                            </form>
                            <a href="{{ route('admin.candidatures.cv', $c) }}" target="_blank" class="bg-blue-100 text-blue-700 hover:bg-blue-200 px-3 py-1.5 rounded-lg text-sm font-medium transition-all hover:scale-105 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                CV
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-gray-500 bg-gray-50 rounded-lg">
                        <svg class="w-12 h-12 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p>Aucune candidature en attente</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Section : Dernières offres et Activités récentes -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Dernières offres publiées -->
        <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-all duration-300 animate-slide-in-right delay-3">
            <div class="flex justify-between items-center mb-4">
                <h3 class="section-title flex items-center">
                    <span class="w-2 h-2 bg-indigo-400 rounded-full mr-2"></span>
                    Dernières offres
                </h3>
                <a href="{{ route('admin.offres.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium flex items-center gap-1">
                    Voir tout
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @forelse($dernieresOffres as $offre)
                    <div class="group bg-gradient-to-br from-gray-50 to-white border border-gray-200 rounded-xl p-4 hover:shadow-lg transition-all duration-300 hover:border-indigo-200">
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0 w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center text-indigo-700 font-bold text-sm">
                                {{ strtoupper(substr($offre->titre, 0, 2)) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="font-semibold text-gray-800 truncate">{{ $offre->titre }}</h4>
                                <p class="text-xs text-gray-500 mt-1">{{ $offre->direction->nom }}</p>
                            </div>
                        </div>
                        <div class="mt-3 flex items-center justify-between">
                            <span class="badge px-2 py-1 text-xs rounded-full {{ $offre->statut == 'ouverte' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                                {{ ucfirst($offre->statut) }}
                            </span>
                            <a href="{{ route('admin.offres.show', $offre->slug) }}" class="text-indigo-600 hover:text-indigo-800 text-xs font-medium">Détails →</a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-2 text-center py-8 text-gray-500 bg-gray-50 rounded-lg">
                        <svg class="w-12 h-12 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                        <p>Aucune offre récente</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Activités récentes -->
<div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-all duration-300 animate-slide-in-right delay-4">
    <div class="flex justify-between items-center mb-4">
        <h3 class="section-title flex items-center">
            <span class="w-2 h-2 bg-green-400 rounded-full mr-2"></span>
            Activités récentes
        </h3>
        <a href="{{ route('admin.activites.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium flex items-center gap-1">
            Voir tous
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </a>
    </div>
    <div class="space-y-3">
        @forelse($activites as $activite)
            <div class="flex items-center p-3 rounded-lg border border-gray-100 hover:bg-gray-50 transition-colors">
                <div class="w-8 h-8 rounded-full flex items-center justify-center {{ $activite->type == 'candidature' ? 'bg-green-100' : 'bg-blue-100' }} mr-3">
                    <svg class="w-4 h-4 {{ $activite->type == 'candidature' ? 'text-green-600' : 'text-blue-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        @if($activite->type == 'candidature')
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        @else
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        @endif
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="text-sm text-gray-700">{{ $activite->message }}</p>
                    <p class="text-xs text-gray-400 mt-1">{{ $activite->date }}</p>
                </div>
            </div>
        @empty
            <div class="text-center py-8 text-gray-500 bg-gray-50 rounded-lg">
                <svg class="w-12 h-12 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p>Aucune activité récente</p>
            </div>
        @endforelse
    </div>
</div>

    <!-- Actions rapides -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-5 mt-8 animate-fade-in-up delay-5">
    <a href="{{ route('admin.utilisateurs.create') }}" class="group relative bg-gradient-to-r from-indigo-600 to-indigo-700 text-white rounded-xl p-6 text-center flex flex-col items-center justify-center overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
        <span class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity duration-300"></span>
        <svg class="w-8 h-8 mb-2 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
        </svg>
        <span class="font-medium">Ajouter un utilisateur</span>
        <span class="text-xs opacity-80 mt-1">Nouveau compte</span>
    </a>
    <a href="{{ route('admin.offres.create') }}" class="group relative bg-gradient-to-r from-indigo-600 to-indigo-700 text-white rounded-xl p-6 text-center flex flex-col items-center justify-center overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
        <span class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity duration-300"></span>
        <svg class="w-8 h-8 mb-2 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
        </svg>
        <span class="font-medium">Ajouter une offre</span>
        <span class="text-xs opacity-80 mt-1">Publier une annonce</span>
    </a>
    <a href="{{ route('admin.candidatures.index') }}" class="group relative bg-gradient-to-r from-indigo-600 to-indigo-700 text-white rounded-xl p-6 text-center flex flex-col items-center justify-center overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
        <span class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity duration-300"></span>
        <svg class="w-8 h-8 mb-2 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
        </svg>
        <span class="font-medium">Voir candidatures</span>
        <span class="text-xs opacity-80 mt-1">Gérer les postulations</span>
    </a>
    <a href="{{ route('admin.statistiques.index') }}" class="group relative bg-gradient-to-r from-indigo-600 to-indigo-700 text-white rounded-xl p-6 text-center flex flex-col items-center justify-center overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
        <span class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity duration-300"></span>
        <svg class="w-8 h-8 mb-2 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
        </svg>
        <span class="font-medium">Statistiques</span>
        <span class="text-xs opacity-80 mt-1">Analyses détaillées</span>
    </a>
</div>
@endsection