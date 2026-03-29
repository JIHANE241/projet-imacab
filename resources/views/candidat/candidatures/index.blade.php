@extends('layouts.candidat')

@section('header', 'Mes candidatures')

@push('styles')
<style>
    /* Variables de couleurs - reprises du layout candidat */
    :root {
        --primary: #4f46e5;
        --primary-dark: #4338ca;
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

    /* Cartes statistiques */
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

    /* Carte de candidature */
    .candidature-card {
        transition: all 0.2s ease;
        border: 1px solid #e5e7eb;
        background: white;
        border-radius: 1rem;
        overflow: hidden;
    }
    .candidature-card:hover {
        transform: translateY(-4px);
        border-color: var(--primary);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    /* Badges */
    .badge {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
        line-height: 1;
        transition: all 0.2s ease;
    }
    .badge i {
        margin-right: 0.25rem;
        font-size: 0.75rem;
    }
    .badge:hover {
        transform: scale(1.05);
        filter: brightness(0.95);
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
<div class="max-w-7xl mx-auto">
    <!-- Statistiques -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 animate-fade-in-up delay-1">
        <!-- Total -->
        <div class="stat-card bg-gradient-to-br from-indigo-600 to-indigo-700 text-white p-5 rounded-xl shadow-xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium opacity-90">Total candidatures</p>
                    <p class="text-3xl font-bold">{{ $total }}</p>
                </div>
                <div class="bg-white/20 p-3 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
            </div>
        </div>
        <!-- Acceptées -->
        <div class="stat-card bg-gradient-to-br from-green-600 to-green-700 text-white p-5 rounded-xl shadow-xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium opacity-90">Acceptées</p>
                    <p class="text-3xl font-bold">{{ $acceptees }}</p>
                </div>
                <div class="bg-white/20 p-3 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
            </div>
        </div>
        <!-- Refusées -->
        <div class="stat-card bg-gradient-to-br from-red-600 to-red-700 text-white p-5 rounded-xl shadow-xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium opacity-90">Refusées</p>
                    <p class="text-3xl font-bold">{{ $refusees }}</p>
                </div>
                <div class="bg-white/20 p-3 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>
            </div>
        </div>
        <!-- En attente -->
        <div class="stat-card bg-gradient-to-br from-yellow-600 to-yellow-700 text-white p-5 rounded-xl shadow-xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium opacity-90">En attente</p>
                    <p class="text-3xl font-bold">{{ $enAttente }}</p>
                </div>
                <div class="bg-white/20 p-3 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenu principal : deux colonnes -->
    <div class="flex flex-wrap gap-6">
        <!-- Colonne de gauche : Directions avec compteurs dynamiques -->
        <div class="w-full md:w-72 bg-white rounded-xl shadow-lg p-5 h-fit animate-slide-in-right delay-2">
            <h3 class="section-title flex items-center">
                <span class="w-2 h-2 bg-indigo-600 rounded-full mr-2"></span>
                Directions
            </h3>
            <ul class="space-y-1 mb-6">
                <li>
                    <a href="{{ route('candidat.candidatures.index', request()->except('direction')) }}"
                       class="direction-item flex justify-between items-center p-3 rounded-lg {{ !request('direction') ? 'active' : 'hover:bg-indigo-50' }}">
                        <span class="text-gray-800">Toutes les directions</span>
                        <span class="bg-gray-200 text-gray-700 px-2 py-0.5 rounded-full text-xs font-semibold">{{ $totalToutesDirections }}</span>
                    </a>
                </li>
                @foreach($directions as $direction)
                    <li>
                        <a href="{{ route('candidat.candidatures.index', ['direction' => $direction->id] + request()->except('direction')) }}"
                           class="direction-item flex justify-between items-center p-3 rounded-lg {{ request('direction') == $direction->id ? 'active' : 'hover:bg-indigo-50' }}">
                            <span class="text-gray-800">{{ $direction->nom }}</span>
                            <span class="bg-gray-200 text-gray-700 px-2 py-0.5 rounded-full text-xs font-semibold">{{ $direction->candidatures_count }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Colonne de droite : Liste des candidatures -->
        <div class="flex-1 animate-fade-in-up delay-3">
            <div class="bg-white rounded-xl shadow-lg p-5">
                <!-- Filtres et recherche -->
                <form method="GET" action="{{ route('candidat.candidatures.index') }}" class="mb-6">
                    <div class="flex flex-wrap gap-3">
                        <input type="hidden" name="direction" value="{{ request('direction') }}">
                        
                        <!-- Champ de recherche -->
                        <div class="relative flex-1 min-w-[200px]">
                            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <input type="text" name="search" placeholder="Titre de l'offre..." value="{{ request('search') }}"
                                   class="pl-10 pr-4 py-2 border border-gray-200 rounded-lg w-full focus:ring-2 focus:ring-indigo-600 focus:border-transparent">
                        </div>

                        <!-- Sélecteur statut -->
                        <select name="statut" class="border border-gray-200 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-600 focus:border-transparent">
                            <option value="">Tous les statuts</option>
                            <option value="en_attente" {{ request('statut') == 'en_attente' ? 'selected' : '' }}>En attente</option>
                            <option value="acceptee" {{ request('statut') == 'acceptee' ? 'selected' : '' }}>Acceptée</option>
                            <option value="refusee" {{ request('statut') == 'refusee' ? 'selected' : '' }}>Refusée</option>
                        </select>

                        <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition-colors shadow-md flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                            </svg>
                            Filtrer
                        </button>

                        <a href="{{ route('candidat.candidatures.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium self-center">Réinitialiser</a>
                    </div>
                </form>

                <!-- Cartes des candidatures -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($candidatures as $c)
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-xl font-bold text-gray-800">
                {{ optional($c->offre)->titre ?? 'Offre indisponible' }}
            </h3>
            <p class="text-sm text-gray-500">
                {{ optional(optional($c->offre)->direction)->nom ?? 'Direction inconnue' }}
            </p>
            <p class="text-sm text-gray-500">Postulée le {{ $c->created_at->format('d/m/Y') }}</p>
            <div class="mt-4">
                @if($c->statut == 'acceptee')
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4" role="alert">
                        <p>Félicitations, votre candidature a été acceptée !</p>
                    </div>
                @elseif($c->statut == 'refusee')
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4" role="alert">
                        <p>Malheureusement, votre candidature n'a pas été retenue.</p>
                    </div>
                @else
                    <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4" role="alert">
                        <p>Votre candidature est en cours d'examen.</p>
                    </div>
                @endif
            </div>
            <div class="mt-4">
                <span class="badge px-2 py-1 text-xs rounded-full 
                    @if($c->statut == 'acceptee') bg-green-100 text-green-700
                    @elseif($c->statut == 'refusee') bg-red-100 text-red-700
                    @else bg-yellow-100 text-yellow-700 @endif">
                    {{ ucfirst($c->statut) }}
                </span>
            </div>
        </div>
    @empty
        <p class="col-span-3 text-center text-gray-500">Aucune candidature trouvée.</p>
    @endforelse
</div>

                <!-- Pagination -->
                @if($candidatures->hasPages())
                    <div class="mt-6">
                        {{ $candidatures->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection