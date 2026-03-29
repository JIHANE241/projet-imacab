@extends('layouts.admin')

@section('header', 'Détails de la direction')

@push('styles')
<style>
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
    .animate-fade-in-up {
        animation: fadeInUp 0.5s ease-out forwards;
    }
    .delay-1 { animation-delay: 0.1s; }
    .delay-2 { animation-delay: 0.2s; }

    .stat-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    .info-item {
        transition: background-color 0.2s ease;
    }
    .info-item:hover {
        background-color: #fef2f2; /* rouge très clair */
    }
</style>
@endpush

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Colonne de gauche : Avatar et informations synthétiques -->
    <div class="lg:col-span-1 animate-fade-in-up delay-1">
        <div class="bg-white rounded-xl shadow-lg p-6">

<div class="flex flex-col items-center text-center">

<div class="w-28 h-28 bg-gradient-to-br from-[#970d0d] to-[#7a0a0a] rounded-xl flex items-center justify-center text-white text-4xl font-bold shadow-lg mb-4">
{{ strtoupper(substr($direction->nom,0,2)) }}
</div>

<h2 class="text-2xl font-bold text-gray-800">{{ $direction->nom }}</h2>

<span class="mt-2 px-4 py-1.5 text-sm rounded-full border border-gray-200 bg-gray-50">
Direction
</span>

</div>
<!-- Colonne de droite : Informations détaillées -->
    <div class="lg:col-span-2 space-y-6 animate-fade-in-up delay-2">
        <!-- Carte des informations -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <span class="w-1.5 h-1.5 bg-[#970d0d] rounded-full mr-2"></span>
                Informations détaillées
            </h3>
            <dl class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nom -->
                <div class="info-item p-3 rounded-lg border border-gray-100">
                    <dt class="text-sm font-medium text-gray-500 flex items-center">
                        <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        Nom de la direction
                    </dt>
                    <dd class="mt-1 text-base text-gray-900 font-medium">{{ $direction->nom }}</dd>
                </div>

                <!-- Responsable -->
                <div class="info-item p-3 rounded-lg border border-gray-100">
                    <dt class="text-sm font-medium text-gray-500 flex items-center">
                        <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Responsable
                    </dt>
                    <dd class="mt-1 text-base text-gray-900">
                        @if($direction->responsable)
                            <div class="flex items-center">
                                <div class="h-6 w-6 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-800 font-semibold text-xs mr-2">
                                    {{ strtoupper(substr($direction->responsable->name, 0, 1)) }}{{ strtoupper(substr($direction->responsable->prenom ?? '', 0, 1)) }}
                                </div>
                                {{ $direction->responsable->name }} {{ $direction->responsable->prenom }}
                            </div>
                        @else
                            <span class="text-gray-400 italic">Non assigné</span>
                        @endif
                    </dd>
                </div>

                <!-- Nombre d'offres -->
                <div class="info-item p-3 rounded-lg border border-gray-100">
                    <dt class="text-sm font-medium text-gray-500 flex items-center">
                        <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        Nombre d'offres
                    </dt>
                    <dd class="mt-1 text-base text-gray-900 font-medium">{{ $direction->offres_count ?? $direction->offres->count() }}</dd>
                </div>

                <!-- Nombre de candidatures -->
                <div class="info-item p-3 rounded-lg border border-gray-100">
                    <dt class="text-sm font-medium text-gray-500 flex items-center">
                        <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Nombre de candidatures
                    </dt>
                    <dd class="mt-1 text-base text-gray-900 font-medium">{{ $direction->candidatures_count ?? $direction->candidatures->count() }}</dd>
                </div>

                <!-- Date de création -->
                <div class="info-item p-3 rounded-lg border border-gray-100">
                    <dt class="text-sm font-medium text-gray-500 flex items-center">
                        <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Date de création
                    </dt>
                    <dd class="mt-1 text-base text-gray-900">{{ $direction->created_at->format('d/m/Y H:i') }}</dd>
                </div>

                <!-- Dernière modification -->
                <div class="info-item p-3 rounded-lg border border-gray-100">
                    <dt class="text-sm font-medium text-gray-500 flex items-center">
                        <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Dernière modification
                    </dt>
                    <dd class="mt-1 text-base text-gray-900">{{ $direction->updated_at->format('d/m/Y H:i') }}</dd>
                </div>
            </dl>
        </div>

        <!-- Éventuellement : dernières offres ou activités (optionnel) -->
        @if($direction->offres->isNotEmpty())
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <span class="w-1.5 h-1.5 bg-blue-500 rounded-full mr-2"></span>
                Dernières offres de cette direction
            </h3>
            <div class="space-y-3">
                @foreach($direction->offres->take(5) as $offre)
                <div class="flex items-center justify-between p-3 border border-gray-100 rounded-lg">
                    <div>
                        <p class="font-medium text-gray-800">{{ $offre->titre }}</p>
                        <p class="text-xs text-gray-500">{{ $offre->created_at->format('d/m/Y') }}</p>
                    </div>
                    <span class="px-3 py-1 text-xs rounded-full {{ $offre->statut == 'ouverte' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                        {{ ucfirst($offre->statut) }}
                    </span>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>

                <!-- Mini statistiques -->
                <div class="w-full mt-6 grid grid-cols-2 gap-3">
                    <div class="stat-card bg-gradient-to-br from-blue-500 to-blue-600 text-white p-4 rounded-lg">
                        <p class="text-xs opacity-90">Offres</p>
                        <p class="text-xl font-bold">{{ $direction->offres_count ?? $direction->offres->count() }}</p>
                    </div>
                    <div class="stat-card bg-gradient-to-br from-green-500 to-green-600 text-white p-4 rounded-lg">
                        <p class="text-xs opacity-90">Candidatures</p>
                        <p class="text-xl font-bold">{{ $direction->candidatures_count ?? $direction->candidatures->count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Actions rapides -->
            <div class="mt-6 flex flex-col gap-2">
                <a href="{{ route('admin.directions.edit', $direction) }}" 
                   class="flex items-center justify-center gap-2 bg-gradient-to-r from-amber-500 to-amber-600 text-white px-4 py-3 rounded-lg hover:from-amber-600 hover:to-amber-700 transition-all shadow-md hover:shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Modifier la direction
                </a>
                <a href="{{ route('admin.directions.index') }}" 
                   class="flex items-center justify-center gap-2 bg-gray-100 text-gray-700 px-4 py-3 rounded-lg hover:bg-gray-200 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Retour à la liste
                </a>
            </div>
        </div>
    </div>

    
</div>
@endsection