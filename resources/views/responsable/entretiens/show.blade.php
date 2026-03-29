@extends('layouts.responsable')

@section('header', 'Détail de l\'entretien')

@push('styles')
<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-up {
        animation: fadeInUp 0.5s ease-out forwards;
    }
    .delay-1 { animation-delay: 0.1s; }
    .delay-2 { animation-delay: 0.2s; }

    .info-item {
        transition: background-color 0.2s ease;
    }
    .info-item:hover {
        background-color: #fef2f2;
    }

    .badge {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .action-button {
        transition: all 0.2s ease;
    }
    .action-button:hover {
        transform: scale(1.05);
    }
</style>
@endpush

@section('content')
<div class="max-w-4xl mx-auto animate-fade-in-up delay-1">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <!-- En-tête avec dégradé -->
        <div class="bg-gradient-to-r from-[#970d0d] to-[#7a0a0a] px-6 py-5">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h2 class="text-xl font-bold text-white">Entretien avec {{ $entretien->candidature->candidat->name }}</h2>
                    <p class="text-red-100 text-sm mt-1">{{ $entretien->candidature->offre->titre }} · {{ $entretien->candidature->offre->direction->nom }}</p>
                </div>
                <div class="mt-2 md:mt-0">
                    <span class="px-4 py-2 text-sm font-semibold rounded-full shadow-lg
                        @if($entretien->statut == 'planifie') bg-blue-500 text-white
                        @elseif($entretien->statut == 'passe') bg-green-500 text-white
                        @else bg-gray-500 text-white @endif">
                        {{ ucfirst($entretien->statut) }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Corps des informations -->
        <div class="p-6">
            <dl class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Date -->
                <div class="info-item p-4 rounded-lg border border-gray-100">
                    <dt class="text-sm font-medium text-gray-500 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-[#970d0d]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Date
                    </dt>
                    <dd class="mt-1 text-base text-gray-900 font-medium">{{ $entretien->date->format('d/m/Y') }}</dd>
                </div>

                <!-- Heure -->
                <div class="info-item p-4 rounded-lg border border-gray-100">
                    <dt class="text-sm font-medium text-gray-500 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-[#970d0d]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Heure
                    </dt>
                    <dd class="mt-1 text-base text-gray-900">{{ $entretien->heure ? \Carbon\Carbon::parse($entretien->heure)->format('H:i') : 'Non définie' }}</dd>
                </div>

                <!-- Lieu -->
                <div class="info-item p-4 rounded-lg border border-gray-100 md:col-span-2">
                    <dt class="text-sm font-medium text-gray-500 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-[#970d0d]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Lieu / Visio
                    </dt>
                    <dd class="mt-1 text-base text-gray-900">{{ $entretien->lieu ?? 'Non spécifié' }}</dd>
                </div>
            </dl>

            <div class="mt-8 border-t border-gray-200 pt-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Informations associées</h3>
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Candidat -->
                    <div class="info-item p-4 rounded-lg border border-gray-100">
                        <dt class="text-sm font-medium text-gray-500 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-[#970d0d]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Candidat
                        </dt>
                        <dd class="mt-1 text-base text-gray-900">{{ $entretien->candidature->candidat->name }} {{ $entretien->candidature->candidat->prenom }}</dd>
                        <dd class="text-sm text-gray-500">{{ $entretien->candidature->candidat->email }}</dd>
                    </div>

                    <!-- Offre -->
                    <div class="info-item p-4 rounded-lg border border-gray-100">
                        <dt class="text-sm font-medium text-gray-500 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-[#970d0d]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            Offre
                        </dt>
                        <dd class="mt-1 text-base text-gray-900">{{ $entretien->candidature->offre->titre }}</dd>
                        <dd class="text-sm text-gray-500">{{ $entretien->candidature->offre->typeContrat->nom ?? '-' }}</dd>
                    </div>
                </dl>
            </div>

            <!-- Boutons d'action -->
            <div class="mt-8 flex flex-wrap items-center justify-end gap-4">
                <a href="{{ route('responsable.entretiens.edit', $entretien) }}" 
                   class="px-6 py-2.5 bg-gradient-to-r from-[#970d0d] to-[#7a0a0a] text-white rounded-lg hover:from-[#7a0a0a] hover:to-[#5f0808] transition-all shadow-md hover:shadow-lg flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Modifier
                </a>
                <a href="{{ route('responsable.entretiens.index') }}" 
                   class="px-6 py-2.5 border border-gray-200 rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors shadow-sm flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Retour
                </a>
            </div>
        </div>
    </div>
</div>
@endsection