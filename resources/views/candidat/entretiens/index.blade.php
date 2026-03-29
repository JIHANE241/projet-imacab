@extends('layouts.candidat')

@section('header', 'Mes entretiens')

@push('styles')
<style>
    /* Variables de couleurs */
    :root {
        --primary: #4f46e5;
        --primary-light: #818cf8;
        --primary-soft: #e0e7ff;
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

    /* Carte d'entretien */
    .interview-card {
        transition: all 0.2s ease;
        border: 1px solid #e5e7eb;
        background: white;
        border-radius: 1rem;
        overflow: hidden;
    }
    .interview-card:hover {
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

    /* Filtres */
    .filter-input {
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        padding: 0.5rem 1rem;
        transition: all 0.2s;
    }
    .filter-input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
    }
</style>
@endpush

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Statistiques -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 animate-fade-in-up delay-1">
        <div class="stat-card bg-gradient-to-br from-indigo-600 to-indigo-700 text-white p-5 rounded-xl shadow-xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium opacity-90">Total entretiens</p>
                    <p class="text-3xl font-bold">{{ $total ?? $entretiens->total() }}</p>
                </div>
                <div class="bg-white/20 p-3 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>
        </div>
        <div class="stat-card bg-gradient-to-br from-blue-600 to-blue-700 text-white p-5 rounded-xl shadow-xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium opacity-90">Planifiés</p>
                    <p class="text-3xl font-bold">{{ $planifies ?? 0 }}</p>
                </div>
                <div class="bg-white/20 p-3 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>
        <div class="stat-card bg-gradient-to-br from-green-600 to-green-700 text-white p-5 rounded-xl shadow-xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium opacity-90">Passés</p>
                    <p class="text-3xl font-bold">{{ $passes ?? 0 }}</p>
                </div>
                <div class="bg-white/20 p-3 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
            </div>
        </div>
        <div class="stat-card bg-gradient-to-br from-red-600 to-red-700 text-white p-5 rounded-xl shadow-xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium opacity-90">Annulés</p>
                    <p class="text-3xl font-bold">{{ $annules ?? 0 }}</p>
                </div>
                <div class="bg-white/20 p-3 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtres et recherche -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-8 animate-fade-in-up delay-2">
        <form method="GET" action="{{ route('candidat.entretiens.index') }}" class="flex flex-wrap items-end gap-4">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-sm font-medium text-gray-700 mb-1">Recherche</label>
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input type="text" name="search" placeholder="Titre de l'offre..." value="{{ request('search') }}"
                           class="filter-input pl-10 pr-4 py-2 w-full">
                </div>
            </div>
            <div class="w-48">
                <label class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                <select name="statut" class="filter-input w-full">
                    <option value="">Tous</option>
                    <option value="planifie" {{ request('statut') == 'planifie' ? 'selected' : '' }}>Planifié</option>
                    <option value="passe" {{ request('statut') == 'passe' ? 'selected' : '' }}>Passé</option>
                    <option value="annule" {{ request('statut') == 'annule' ? 'selected' : '' }}>Annulé</option>
                </select>
            </div>
            <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition-colors shadow-md flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                </svg>
                Filtrer
            </button>
        </form>
    </div>

    <!-- Liste des entretiens -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 animate-fade-in-up delay-3">
        @forelse($entretiens as $e)
            <div class="interview-card p-5">
                <!-- En-tête : offre et statut -->
                <div class="flex items-start justify-between mb-3">
                    <h3 class="font-semibold text-lg text-gray-800">{{ $e->candidature->offre->titre }}</h3>
                    <span class="badge 
                        @if($e->statut == 'planifie') bg-blue-100 text-blue-700
                        @elseif($e->statut == 'passe') bg-green-100 text-green-700
                        @else bg-red-100 text-red-700 @endif">
                        @if($e->statut == 'planifie')
                            <i class="fas fa-calendar-check"></i>
                        @elseif($e->statut == 'passe')
                            <i class="fas fa-check-circle"></i>
                        @else
                            <i class="fas fa-times-circle"></i>
                        @endif
                        {{ ucfirst($e->statut) }}
                    </span>
                </div>

                <!-- Entreprise -->
                <div class="flex items-center space-x-2 mb-3">
                    <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center text-indigo-700 font-bold text-sm">
                        {{ substr($e->candidature->offre->direction->nom, 0, 2) }}
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-800">{{ $e->candidature->offre->direction->nom }}</p>
                    </div>
                </div>

                <!-- Détails date, heure, lieu -->
                <div class="text-sm text-gray-600 space-y-2 mb-4">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span>{{ $e->date->format('d/m/Y') }}</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ $e->heure ? $e->heure->format('H:i') : 'Non précisée' }}</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span>{{ $e->lieu ?? 'Lieu non spécifié' }}</span>
                    </div>
                </div>

                <!-- Lien vers le détail de l'entretien -->
               <div class="mt-2">
                  <a href="{{ route('candidat.entretiens.show', $e) }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium flex items-center gap-1">
                      Voir détail
                       <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                     </svg>
                  </a>
             </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12 text-gray-500">
                <svg class="mx-auto h-16 w-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <p class="mt-4 text-lg">Aucun entretien trouvé.</p>
                <a href="{{ route('candidat.offres.index') }}" class="inline-block mt-4 text-indigo-600 hover:underline">Parcourir les offres</a>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($entretiens->hasPages())
        <div class="mt-8 animate-fade-in-up delay-4">
            {{ $entretiens->appends(request()->query())->links() }}
        </div>
    @endif
</div>
@endsection