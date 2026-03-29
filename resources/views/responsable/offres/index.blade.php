@extends('layouts.responsable')

@section('header', 'Gestion des offres')

@push('styles')
<style>
    .badge {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    .table-row {
        transition: background-color 0.2s;
    }
    .table-row:hover {
        background-color: #f9fafb;
    }
    .action-button {
        transition: all 0.2s;
    }
    .action-button:hover {
        transform: scale(1.05);
    }
</style>
@endpush

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-6 animate-fade-in-up delay-1">
        <h1 class="text-2xl font-bold text-gray-800">Offres d'emploi</h1>
        <a href="{{ route('responsable.offres.create') }}" 
           class="bg-[#970d0d] text-white px-4 py-2 rounded-lg hover:bg-[#7a0a0a] transition-colors flex items-center gap-2 shadow-md">
            <i class="fas fa-plus-circle"></i> Nouvelle offre
        </a>
    </div>

    <!-- Filtres -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-8 animate-fade-in-up delay-2">
        <form method="GET" action="{{ route('responsable.offres.index') }}" class="flex flex-wrap gap-4">
            <div class="flex-1 min-w-[200px]">
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input type="text" name="search" placeholder="Rechercher par titre..." value="{{ request('search') }}"
                           class="pl-10 pr-4 py-2 border border-gray-200 rounded-lg w-full focus:ring-2 focus:ring-[#970d0d] focus:border-transparent">
                </div>
            </div>
            <select name="type_contrat" class="border border-gray-200 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#970d0d] focus:border-transparent">
                <option value="">Type de contrat</option>
                @foreach($typeContrats as $tc)
                    <option value="{{ $tc->id }}" {{ request('type_contrat') == $tc->id ? 'selected' : '' }}>{{ $tc->nom }}</option>
                @endforeach
            </select>
            <select name="statut" class="border border-gray-200 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#970d0d] focus:border-transparent">
                <option value="">Tous statuts</option>
                <option value="ouverte" {{ request('statut') == 'ouverte' ? 'selected' : '' }}>Ouverte</option>
                <option value="fermée" {{ request('statut') == 'fermée' ? 'selected' : '' }}>Fermée</option>
                <option value="brouillon" {{ request('statut') == 'brouillon' ? 'selected' : '' }}>Brouillon</option>
            </select>
            <button type="submit" class="bg-[#970d0d] text-white px-6 py-2 rounded-lg hover:bg-[#7a0a0a] transition-colors shadow-md flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                </svg>
                Filtrer
            </button>
            <a href="{{ route('responsable.offres.index') }}" class="text-[#970d0d] hover:text-[#7a0a0a] self-center">Réinitialiser</a>
        </form>
    </div>

    <!-- Tableau -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden animate-fade-in-up delay-3">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    32
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Titre</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Contrat</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Expérience</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Statut</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Publication</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Actions</th>
                    40
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($offres as $offre)
                    <tr class="table-row">
                        <td class="px-6 py-4">
                            <div class="font-medium text-gray-900">{{ $offre->titre }}</div>
                            <!-- La direction n'est plus affichée car elle est implicite -->
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $offre->typeContrat->nom ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $offre->niveauExperience->nom ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="badge 
                                @if($offre->statut == 'ouverte') bg-green-100 text-green-700
                                @elseif($offre->statut == 'fermée') bg-red-100 text-red-700
                                @else bg-gray-100 text-gray-700 @endif">
                                {{ ucfirst($offre->statut) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $offre->date_publication->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <div class="flex space-x-2">
                                <a href="{{ route('responsable.offres.show', $offre->slug) }}" class="text-indigo-600 hover:text-indigo-900" title="Voir">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('responsable.offres.edit', $offre) }}" class="text-amber-600 hover:text-amber-900" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('responsable.offres.destroy', $offre) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer cette offre ?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" title="Supprimer">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                            <i class="fas fa-briefcase text-4xl mb-2 text-gray-300"></i>
                            <p>Aucune offre trouvée.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($offres->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $offres->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>
@endsection