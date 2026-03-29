@extends('layouts.responsable')

@section('header', 'Candidats')

@push('styles')
<style>
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
    }
    .animate-slide-in-right {
        animation: slideInRight 0.5s ease-out forwards;
    }
    .delay-1 { animation-delay: 0.1s; }
    .delay-2 { animation-delay: 0.2s; }
    .delay-3 { animation-delay: 0.3s; }

    .candidate-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .candidate-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(151, 13, 13, 0.2), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    .stat-card {
        transition: all 0.3s ease;
    }
    .stat-card:hover {
        transform: translateY(-3px);
    }
</style>
@endpush

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Mini statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 animate-fade-in-up delay-1">
        <div class="stat-card bg-gradient-to-br from-[#970d0d] to-[#7a0a0a] text-white p-5 rounded-xl shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium opacity-90">Total candidats</p>
                    <p class="text-3xl font-bold">{{ $candidats->total() }}</p>
                </div>
                <i class="fas fa-users text-3xl opacity-80"></i>
            </div>
        </div>
        <div class="stat-card bg-white p-5 rounded-xl shadow-lg border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Candidatures totales</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalCandidatures ?? 0 }}</p>
                </div>
                <i class="fas fa-file-alt text-3xl text-gray-400"></i>
            </div>
        </div>
        <div class="stat-card bg-white p-5 rounded-xl shadow-lg border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Dernière inscription</p>
                    <p class="text-lg font-bold text-gray-800">{{ $derniereInscription ?? 'Aucune' }}</p>
                </div>
                <i class="fas fa-calendar-alt text-3xl text-gray-400"></i>
            </div>
        </div>
    </div>

    <!-- Barre de recherche -->
    <div class="bg-white rounded-xl shadow-lg p-5 mb-8 animate-slide-in-right delay-2">
        <form method="GET" action="{{ route('responsable.candidats.index') }}" class="flex flex-wrap gap-4 items-center">
            <div class="relative flex-1 min-w-[200px]">
                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                <input type="text" name="search" placeholder="Rechercher par nom, prénom ou email..." value="{{ request('search') }}"
                       class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#970d0d] focus:border-transparent">
            </div>
            <button type="submit" class="bg-gradient-to-r from-[#970d0d] to-[#7a0a0a] text-white px-6 py-2 rounded-lg hover:from-[#7a0a0a] hover:to-[#5f0808] transition shadow-md flex items-center gap-2">
                <i class="fas fa-search"></i> Rechercher
            </button>
            <a href="{{ route('responsable.candidats.index') }}" class="text-gray-500 hover:text-[#970d0d] transition flex items-center gap-1">
                <i class="fas fa-undo-alt"></i> Réinitialiser
            </a>
        </form>
    </div>

    <!-- Liste des candidats (cartes) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 animate-fade-in-up delay-3">
        @forelse($candidats as $c)
        <div class="candidate-card bg-white rounded-xl shadow-lg overflow-hidden transition-all duration-300">
            <!-- En-tête avec avatar -->
            <div class="bg-gradient-to-r from-gray-50 to-white border-b border-gray-100 px-6 py-4">
                <div class="flex items-center space-x-4">
                    <div class="w-14 h-14 rounded-full bg-gradient-to-br from-[#970d0d] to-[#7a0a0a] flex items-center justify-center text-white font-bold text-xl shadow-md">
                        {{ strtoupper(substr($c->name, 0, 1)) }}{{ strtoupper(substr($c->prenom ?? '', 0, 1)) }}
                    </div>
                    <div>
                        <h3 class="font-semibold text-lg text-gray-800">{{ $c->name }} {{ $c->prenom }}</h3>
                        <p class="text-sm text-gray-500">{{ $c->email }}</p>
                    </div>
                </div>
            </div>

            <!-- Corps de la carte -->
            <div class="p-5">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-sm text-gray-600">
                        <i class="fas fa-briefcase text-[#970d0d] mr-1"></i> 
                        {{ $c->candidatures->count() }} candidature(s)
                    </span>
                    <span class="text-sm text-gray-500">
                        <i class="fas fa-calendar-alt text-gray-400 mr-1"></i>
                        {{ $c->created_at->format('d/m/Y') }}
                    </span>
                </div>

                <!-- Dernière candidature (exemple) -->
                @if($c->candidatures->isNotEmpty())
                <div class="mt-3 p-3 bg-gray-50 rounded-lg">
                    <p class="text-xs text-gray-500">Dernière candidature</p>
                    <p class="text-sm font-medium text-gray-700 truncate">{{ $c->candidatures->last()->offre->titre ?? '-' }}</p>
                    <p class="text-xs text-gray-400 mt-1">Postulée le {{ $c->candidatures->last()->created_at->format('d/m/Y') }}</p>
                </div>
                @endif

                <!-- Bouton profil -->
                <div class="mt-4 pt-3 border-t border-gray-100">
                    <a href="{{ route('responsable.candidats.show', $c) }}" 
                       class="inline-flex items-center text-[#970d0d] hover:text-[#7a0a0a] font-medium group">
                        Voir le profil 
                        <i class="fas fa-arrow-right ml-1 group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-16 text-gray-500 bg-white rounded-xl shadow-lg">
            <i class="fas fa-user-slash text-5xl mb-3 text-gray-300"></i>
            <p class="text-lg">Aucun candidat trouvé.</p>
            <p class="text-sm text-gray-400 mt-1">Modifiez vos critères de recherche ou réinitialisez le filtre.</p>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($candidats->hasPages())
    <div class="mt-8 animate-fade-in-up delay-4">
        {{ $candidats->appends(request()->query())->links() }}
    </div>
    @endif
</div>
@endsection