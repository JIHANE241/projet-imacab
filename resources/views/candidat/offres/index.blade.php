@extends('layouts.candidat')

@section('header', 'Offres d\'emploi')

@push('styles')
<style>
    /* Variables de couleurs - reprises du layout candidat */
    :root {
        --primary: #4f46e5; /* indigo-600 */
        --primary-dark: #4338ca; /* indigo-700 */
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
        animation: fadeInUp 0.5s ease-out forwards;
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

    /* Cartes statistiques (optionnelles) */
    .stat-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    /* Élément de direction dans la sidebar */
    .direction-item {
        transition: all 0.2s ease;
        border-radius: 0.5rem;
    }
    .direction-item:hover {
        background-color: #eef2ff;
        transform: translateX(5px);
    }
    .direction-item.active {
        background-color: #e0e7ff;
        border-left: 4px solid var(--primary);
        font-weight: 500;
    }

    /* Élément d'offre (carte) */
    .offer-card {
        transition: all 0.2s ease;
        border: 1px solid #e5e7eb;
        background: white;
    }
    .offer-card:hover {
        background: #f8fafc;
        transform: translateY(-4px);
        border-color: var(--primary);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
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

    /* Boutons d'action */
    .action-button {
        transition: all 0.2s ease;
    }
    .action-button:hover {
        transform: scale(1.05);
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
    <!-- Éventuelle petite carte stats (optionnelle) -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 animate-fade-in-up delay-1">
        <div class="stat-card bg-gradient-to-br from-indigo-600 to-indigo-700 text-white p-5 rounded-xl shadow-xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium opacity-90">Total offres</p>
                    <p class="text-3xl font-bold">{{ $offres->total() }}</p>
                </div>
                <div class="bg-white/20 p-3 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>
        </div>
        <div class="stat-card bg-gradient-to-br from-emerald-600 to-emerald-700 text-white p-5 rounded-xl shadow-xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium opacity-90">Nouvelles cette semaine</p>
                    <p class="text-3xl font-bold">{{ $nouvellesSemaine ?? 0 }}</p>
                </div>
                <div class="bg-white/20 p-3 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>
        <div class="stat-card bg-gradient-to-br from-amber-600 to-amber-700 text-white p-5 rounded-xl shadow-xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium opacity-90">CDI</p>
                    <p class="text-3xl font-bold">{{ $cdiCount ?? 0 }}</p>
                </div>
                <div class="bg-white/20 p-3 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenu principal : deux colonnes -->
    <div class="flex flex-wrap gap-6">
        <!-- Colonne de gauche : Directions et filtres -->
        <div class="w-full md:w-72 bg-white rounded-xl shadow-lg p-5 h-fit animate-slide-in-right delay-2">
            <h3 class="section-title flex items-center">
                <span class="w-2 h-2 bg-indigo-600 rounded-full mr-2"></span>
                Directions
            </h3>
            <ul class="space-y-1 mb-6">
                <li>
                    <a href="{{ route('candidat.offres.index', request()->except('direction')) }}"
                       class="direction-item flex justify-between items-center p-3 rounded-lg {{ !request('direction') ? 'active' : 'hover:bg-indigo-50' }}">
                        <span class="text-gray-800">Toutes les directions</span>
                        <span class="bg-gray-200 text-gray-700 px-2 py-0.5 rounded-full text-xs font-semibold">{{ $totalToutesDirections }}</span>
                    </a>
                </li>
                @foreach($directions as $direction)
                    <li>
                        <a href="{{ route('candidat.offres.index', ['direction' => $direction->id] + request()->except('direction')) }}"
                           class="direction-item flex justify-between items-center p-3 rounded-lg {{ request('direction') == $direction->id ? 'active' : 'hover:bg-indigo-50' }}">
                            <span class="text-gray-800">{{ $direction->nom }}</span>
                            <span class="bg-gray-200 text-gray-700 px-2 py-0.5 rounded-full text-xs font-semibold">{{ $direction->offres_count }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Colonne de droite : Liste des offres -->
        <div class="flex-1 animate-fade-in-up delay-3">
            <div class="bg-white rounded-xl shadow-lg p-5">
                <!-- Barre de recherche -->
                <form method="GET" action="{{ route('candidat.offres.index') }}" class="mb-6">
                    <div class="flex flex-wrap gap-3">
                        <input type="hidden" name="direction" value="{{ request('direction') }}">
                        
                        <!-- Champ de recherche -->
                        <div class="relative flex-1 min-w-[200px]">
                            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-400" ...></svg>
                            <input type="text" name="search" placeholder="Rechercher par titre..." value="{{ request('search') }}"
                                   class="pl-10 pr-4 py-2 border border-gray-200 rounded-lg w-full focus:ring-2 focus:ring-indigo-600 focus:border-transparent">
                        </div>

                        <!-- Sélecteur type de contrat -->
                        <select name="type_contrat" class="border border-gray-200 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-600 focus:border-transparent">
                            <option value="">Tous les contrats</option>
                            @foreach($typeContrats as $tc)
                                <option value="{{ $tc->id }}" {{ request('type_contrat') == $tc->id ? 'selected' : '' }}>{{ $tc->nom }}</option>
                            @endforeach
                        </select>

                        <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition-colors shadow-md flex items-center gap-2">
                            <svg class="w-5 h-5" ...></svg>
                            Rechercher
                        </button>
                    </div>
                </form>

                <!-- Grille des offres -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 gap-4">
                    @forelse($offres as $offre)
                        <div class="offer-card rounded-xl p-5">
                            <div class="flex items-start justify-between">
                                <h3 class="font-semibold text-lg text-gray-800">{{ $offre->titre }}</h3>
                                <span class="badge bg-indigo-100 text-indigo-800 text-xs px-2 py-1 rounded-full">{{ $offre->typeContrat->nom ?? 'CDI' }}</span>
                            </div>
                            <p class="text-sm text-gray-500 mt-1">{{ $offre->direction->nom }}</p>
                            <p class="text-sm text-gray-500 flex items-center mt-2">
                                <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                {{ $offre->ville->nom ?? 'Non spécifié' }}
                            </p>
                            <p class="text-sm text-gray-500 flex items-center">
                                <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                {{ $offre->niveauExperience->nom ?? 'Non précisé' }}
                            </p>
                            <p class="text-xs text-gray-400 mt-3">Publiée le {{ $offre->date_publication->format('d/m/Y') }}</p>
                            <div class="mt-4 flex justify-between items-center">
                                <a href="{{ route('candidat.offres.show', $offre->slug) }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium flex items-center gap-1">
                                    Voir les détails
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                                <span class="badge bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full">Ouverte</span>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-10 text-gray-500">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                            </svg>
                            <p class="mt-2">Aucune offre ne correspond à vos critères.</p>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if($offres->hasPages())
                    <div class="mt-6">
                        {{ $offres->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection