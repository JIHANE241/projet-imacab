@extends('layouts.responsable')

@section('header', 'Profil du candidat')

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
        line-height: 1;
    }
    .badge i {
        margin-right: 0.25rem;
        font-size: 0.7rem;
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
                    <h2 class="text-xl font-bold text-white">Profil du candidat</h2>
                    <p class="text-red-100 text-sm mt-1">{{ $candidat->email }}</p>
                </div>
            </div>
        </div>

        <div class="p-6">
            <!-- Informations personnelles -->
            <div class="flex flex-col md:flex-row items-start md:items-center gap-6 border-b border-gray-200 pb-6 mb-6">
                <div class="w-28 h-28 rounded-full bg-gradient-to-br from-[#970d0d] to-[#7a0a0a] flex items-center justify-center text-white text-3xl font-bold shadow-lg">
                    {{ strtoupper(substr($candidat->name, 0, 1)) }}{{ strtoupper(substr($candidat->prenom ?? '', 0, 1)) }}
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">{{ $candidat->name }} {{ $candidat->prenom }}</h1>
                    <div class="flex items-center gap-2 mt-1">
                        <i class="fas fa-envelope text-gray-400"></i>
                        <span class="text-gray-600">{{ $candidat->email }}</span>
                    </div>
                    <div class="flex items-center gap-2 mt-1">
                        <i class="fas fa-phone text-gray-400"></i>
                        <span class="text-gray-600">{{ $candidat->telephone ?? 'Non renseigné' }}</span>
                    </div>
                </div>
            </div>

            <!-- Candidatures dans le département -->
            <div>
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-briefcase text-[#970d0d] mr-2"></i>
                    Candidatures dans votre département
                </h3>
                <div class="space-y-3">
                    @forelse($candidatures as $c)
                    <div class="info-item border border-gray-100 rounded-lg p-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 transition-all">
                        <div>
                            <p class="font-medium text-gray-800">{{ $c->offre->titre }}</p>
                            <p class="text-sm text-gray-500 mt-1">
                                <i class="far fa-calendar-alt mr-1"></i> Postulée le {{ $c->created_at->format('d/m/Y') }}
                            </p>
                            <p class="text-xs text-gray-400 mt-1">
                                <i class="fas fa-building mr-1"></i> {{ $c->offre->direction->nom }}
                            </p>
                        </div>
                        <div>
                            <span class="badge
                                @if($c->statut == 'acceptee') bg-green-100 text-green-700
                                @elseif($c->statut == 'refusee') bg-red-100 text-red-700
                                @elseif($c->statut == 'en_revision') bg-blue-100 text-blue-700
                                @else bg-yellow-100 text-yellow-700 @endif">
                                @if($c->statut == 'acceptee') <i class="fas fa-check-circle"></i>
                                @elseif($c->statut == 'refusee') <i class="fas fa-times-circle"></i>
                                @elseif($c->statut == 'en_revision') <i class="fas fa-edit"></i>
                                @else <i class="fas fa-clock"></i> @endif
                                {{ ucfirst(str_replace('_', ' ', $c->statut)) }}
                            </span>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8 text-gray-500 bg-gray-50 rounded-lg">
                        <i class="fas fa-inbox text-3xl text-gray-300 mb-2"></i>
                        <p>Aucune candidature trouvée dans votre département.</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Bouton retour -->
            <div class="mt-8 pt-4 border-t border-gray-100 flex justify-end">
                <a href="{{ route('responsable.candidats.index') }}" 
                   class="px-6 py-2.5 border border-gray-200 rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors shadow-sm flex items-center gap-2">
                    <i class="fas fa-arrow-left"></i> Retour à la liste
                </a>
            </div>
        </div>
    </div>
</div>
@endsection