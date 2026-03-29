@extends('layouts.responsable')

@section('header', 'Gestion des entretiens')

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
    .delay-3 { animation-delay: 0.3s; }

    .filter-card {
        transition: all 0.2s ease;
    }
    .filter-card:hover {
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }

    .interview-card {
        transition: all 0.3s ease;
    }
    .interview-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
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

    .action-link {
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.25rem 0.75rem;
        border-radius: 0.5rem;
    }
    .action-link:hover {
        transform: translateY(-2px);
    }
</style>
@endpush

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- En-tête avec bouton -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8 animate-fade-in-up delay-1">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Entretiens</h1>
            <p class="text-gray-500 text-sm mt-1">Gérez les entretiens planifiés avec les candidats</p>
        </div>
        <a href="{{ route('responsable.entretiens.create') }}" 
           class="bg-gradient-to-r from-[#970d0d] to-[#7a0a0a] text-white px-5 py-2.5 rounded-lg hover:from-[#7a0a0a] hover:to-[#5f0808] transition shadow-md flex items-center gap-2">
            <i class="fas fa-plus-circle"></i> Planifier un entretien
        </a>
    </div>

    <!-- Filtres -->
    <div class="bg-white rounded-xl shadow-lg p-5 mb-8 filter-card animate-fade-in-up delay-2">
        <form method="GET" action="{{ route('responsable.entretiens.index') }}" class="flex flex-wrap gap-4 items-center">
            <div class="relative flex-1 min-w-[200px]">
                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                <input type="text" name="search" placeholder="Rechercher par offre..." value="{{ request('search') }}"
                       class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#970d0d] focus:border-transparent">
            </div>
            <div class="relative">
                <i class="fas fa-filter absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                <select name="statut" class="pl-10 pr-8 py-2 border border-gray-200 rounded-lg appearance-none focus:ring-2 focus:ring-[#970d0d] focus:border-transparent bg-white">
                    <option value="">Tous statuts</option>
                    <option value="planifie" {{ request('statut') == 'planifie' ? 'selected' : '' }}>Planifié</option>
                    <option value="passe" {{ request('statut') == 'passe' ? 'selected' : '' }}>Passé</option>
                    <option value="annule" {{ request('statut') == 'annule' ? 'selected' : '' }}>Annulé</option>
                </select>
                <i class="fas fa-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none"></i>
            </div>
            <button type="submit" class="bg-gradient-to-r from-[#970d0d] to-[#7a0a0a] text-white px-6 py-2 rounded-lg hover:from-[#7a0a0a] hover:to-[#5f0808] transition shadow-md flex items-center gap-2">
                <i class="fas fa-filter"></i> Filtrer
            </button>
            <a href="{{ route('responsable.entretiens.index') }}" class="text-gray-500 hover:text-[#970d0d] transition flex items-center gap-1">
                <i class="fas fa-undo-alt"></i> Réinitialiser
            </a>
        </form>
    </div>

    <!-- Liste des entretiens (cartes) -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @forelse($entretiens as $e)
        <div class="bg-white rounded-xl shadow-lg overflow-hidden interview-card animate-fade-in-up delay-3">
            <!-- En-tête de carte avec statut -->
            <div class="bg-gradient-to-r from-gray-50 to-white border-b border-gray-100 px-6 py-4">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="font-semibold text-lg text-gray-800">{{ $e->candidature->offre->titre }}</h3>
                        <p class="text-sm text-gray-500 mt-0.5">
                            <i class="fas fa-user-circle mr-1"></i> 
                            {{ $e->candidature->candidat->name }} {{ $e->candidature->candidat->prenom }}
                        </p>
                    </div>
                    <span class="badge 
                        @if($e->statut == 'planifie') bg-blue-100 text-blue-700
                        @elseif($e->statut == 'passe') bg-green-100 text-green-700
                        @else bg-red-100 text-red-700 @endif">
                        @if($e->statut == 'planifie') <i class="fas fa-calendar-check"></i>
                        @elseif($e->statut == 'passe') <i class="fas fa-check-circle"></i>
                        @else <i class="fas fa-ban"></i> @endif
                        {{ ucfirst($e->statut) }}
                    </span>
                </div>
            </div>

            <!-- Corps de la carte -->
            <div class="p-6">
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div class="flex items-center text-gray-700">
                        <i class="far fa-calendar-alt w-5 text-[#970d0d]"></i>
                        <span class="ml-2 text-sm">{{ $e->date->format('d/m/Y') }}</span>
                    </div>
                    <div class="flex items-center text-gray-700">
                        <i class="far fa-clock w-5 text-[#970d0d]"></i>
                        <span class="ml-2 text-sm">{{ $e->heure ? $e->heure->format('H:i') : 'Non précisée' }}</span>
                    </div>
                    <div class="flex items-center text-gray-700 col-span-2">
                        <i class="fas fa-map-marker-alt w-5 text-[#970d0d]"></i>
                        <span class="ml-2 text-sm">{{ $e->lieu ?? 'Lieu non spécifié' }}</span>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex flex-wrap gap-2 pt-2 border-t border-gray-100">
                    <a href="{{ route('responsable.entretiens.show', $e) }}" class="action-link text-indigo-600 hover:bg-indigo-50">
                        <i class="fas fa-eye"></i> Détails
                    </a>
                    <a href="{{ route('responsable.entretiens.edit', $e) }}" class="action-link text-amber-600 hover:bg-amber-50">
                        <i class="fas fa-edit"></i> Modifier
                    </a>
                    <form action="{{ route('responsable.entretiens.destroy', $e) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer cet entretien ?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="action-link text-red-600 hover:bg-red-50">
                            <i class="fas fa-trash-alt"></i> Supprimer
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-2 text-center py-16 text-gray-500 bg-white rounded-xl shadow-lg">
            <i class="fas fa-calendar-times text-5xl mb-3 text-gray-300"></i>
            <p class="text-lg">Aucun entretien trouvé.</p>
            <a href="{{ route('responsable.entretiens.create') }}" class="mt-4 inline-flex items-center gap-2 text-[#970d0d] hover:underline">
                <i class="fas fa-plus-circle"></i> Planifier un entretien
            </a>
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