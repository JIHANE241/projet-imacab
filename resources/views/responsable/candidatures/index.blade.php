@extends('layouts.responsable')

@section('header', 'Candidatures')

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

    .table-row {
        transition: background-color 0.2s ease;
    }
    .table-row:hover {
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

    .action-icon {
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 2rem;
        height: 2rem;
        border-radius: 0.5rem;
        background-color: #f3f4f6;
        color: #4b5563;
    }
    .action-icon:hover {
        background-color: #e5e7eb;
        transform: scale(1.05);
    }
</style>
@endpush

@section('content')
<div class="max-w-7xl mx-auto animate-fade-in-up delay-1">
    <!-- Barre de filtres -->
    <div class="bg-white rounded-xl shadow-lg p-5 mb-8 filter-card">
        <form method="GET" class="flex flex-wrap gap-3 items-center">
            <div class="relative flex-1 min-w-[200px]">
                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                <input type="text" name="search" placeholder="Rechercher un candidat..." value="{{ request('search') }}"
                       class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#970d0d] focus:border-transparent">
            </div>
            <div class="relative">
                <i class="fas fa-filter absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                <select name="statut" class="pl-10 pr-8 py-2 border border-gray-200 rounded-lg appearance-none focus:ring-2 focus:ring-[#970d0d] focus:border-transparent bg-white">
                    <option value="">Tous statuts</option>
                    <option value="en_attente" {{ request('statut')=='en_attente' ? 'selected' : '' }}>En attente</option>
                    <option value="en_revision" {{ request('statut')=='en_revision' ? 'selected' : '' }}>En révision</option>
                    <option value="acceptee" {{ request('statut')=='acceptee' ? 'selected' : '' }}>Acceptée</option>
                    <option value="refusee" {{ request('statut')=='refusee' ? 'selected' : '' }}>Refusée</option>
                </select>
                <i class="fas fa-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none"></i>
            </div>
            <button type="submit" class="bg-gradient-to-r from-[#970d0d] to-[#7a0a0a] text-white px-6 py-2 rounded-lg hover:from-[#7a0a0a] hover:to-[#5f0808] transition shadow-md flex items-center gap-2">
                <i class="fas fa-filter"></i> Filtrer
            </button>
        </form>
    </div>

    <!-- Tableau des candidatures -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Candidat</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Offre</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Statut</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Mon avis</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Avis</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($candidatures as $c)
                    <tr class="table-row">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-gradient-to-br from-[#970d0d] to-[#7a0a0a] rounded-full flex items-center justify-center text-white text-xs font-bold">
                                    {{ strtoupper(substr($c->candidat->name, 0, 1)) }}{{ strtoupper(substr($c->candidat->prenom ?? '', 0, 1)) }}
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">{{ $c->candidat->name }} {{ $c->candidat->prenom }}</p>
                                    <p class="text-xs text-gray-500">{{ $c->candidat->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            {{ $c->offre->titre }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="badge
                                @if($c->statut == 'en_attente') bg-yellow-100 text-yellow-800
                                @elseif($c->statut == 'en_revision') bg-blue-100 text-blue-800
                                @elseif($c->statut == 'acceptee') bg-green-100 text-green-800
                                @else bg-red-100 text-red-800 @endif">
                                @if($c->statut == 'en_attente') <i class="fas fa-clock"></i>
                                @elseif($c->statut == 'en_revision') <i class="fas fa-edit"></i>
                                @elseif($c->statut == 'acceptee') <i class="fas fa-check-circle"></i>
                                @else <i class="fas fa-times-circle"></i> @endif
                                {{ ucfirst(str_replace('_', ' ', $c->statut)) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            {{ $c->created_at->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 max-w-[150px] truncate">
                            @if($c->commentaire_rd)
                                <span class="text-sm" title="{{ $c->commentaire_rd }}">{{ Str::limit($c->commentaire_rd, 40) }}</span>
                            @else
                                <span class="text-gray-400 text-xs">Non renseigné</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($c->evaluation)
                                <span class="badge
                                    @if($c->evaluation == 'favorable') bg-green-100 text-green-700
                                    @else bg-red-100 text-red-700 @endif">
                                    <i class="fas {{ $c->evaluation == 'favorable' ? 'fa-thumbs-up' : 'fa-thumbs-down' }}"></i>
                                    {{ ucfirst($c->evaluation) }}
                                </span>
                            @else
                                <span class="text-gray-400 text-xs">Non évalué</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('responsable.candidatures.show', $c) }}" class="action-icon inline-flex items-center justify-center" title="Voir la candidature">
                                <i class="fas fa-eye text-indigo-600"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                            <i class="fas fa-inbox text-4xl text-gray-300 mb-2 block"></i>
                            Aucune candidature trouvée.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($candidatures->hasPages())
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
            {{ $candidatures->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>
@endsection