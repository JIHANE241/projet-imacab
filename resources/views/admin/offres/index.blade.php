@extends('layouts.admin')

@section('header', 'Gestion des offres')

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
    .delay-4 { animation-delay: 0.4s; }

    .stat-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    .direction-item {
        transition: all 0.2s ease;
    }
    .direction-item:hover {
        background-color: #fef2f2;
        transform: translateX(5px);
    }

    .table-row {
        transition: background-color 0.2s ease;
    }
    .table-row:hover {
        background-color: #f9fafb;
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
    <!-- Cartes statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 animate-fade-in-up delay-1">
        <div class="stat-card bg-gradient-to-br from-[#970d0d] to-[#7a0a0a] text-white p-5 rounded-xl shadow-xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium opacity-90">Total offres</p>
                    <p class="text-3xl font-bold">{{ $stats['total'] }}</p>
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
                    <p class="text-sm font-medium opacity-90">Offres ouvertes</p>
                    <p class="text-3xl font-bold">{{ $stats['ouvertes'] }}</p>
                </div>
                <div class="bg-white/20 p-3 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
            </div>
        </div>
        <div class="stat-card bg-gradient-to-br from-amber-600 to-amber-700 text-white p-5 rounded-xl shadow-xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium opacity-90">Offres fermées</p>
                    <p class="text-3xl font-bold">{{ $stats['fermees'] }}</p>
                </div>
                <div class="bg-white/20 p-3 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="flex flex-wrap gap-6">
        <!-- Liste des directions avec compteurs -->
        <div class="w-full md:w-72 bg-white rounded-xl shadow-lg p-5 h-fit animate-fade-in-up delay-2">
            <h3 class="font-semibold text-lg mb-4 flex items-center">
                <span class="w-2 h-2 bg-[#970d0d] rounded-full mr-2"></span>
                Directions
            </h3>
            <ul class="space-y-1">
                @foreach($directions as $dir)
                    <li>
                        <a href="{{ route('admin.offres.index', ['direction_id' => $dir->id]) }}"
                           class="direction-item flex justify-between items-center p-3 rounded-lg {{ $selectedDirection && $selectedDirection->id == $dir->id ? 'bg-[#970d0d]/10 border-l-4 border-[#970d0d] font-medium' : 'hover:bg-gray-50' }}">
                            <span class="text-gray-800">{{ $dir->nom }}</span>
                            <span class="bg-gray-200 text-gray-700 px-2 py-0.5 rounded-full text-xs font-semibold">{{ $dir->offres_count }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Tableau des offres -->
        <div class="flex-1 animate-fade-in-up delay-3">
            @if($selectedDirection)
                <div class="bg-white rounded-xl shadow-lg p-5">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-4">
                        <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                            <span class="w-2 h-2 bg-[#970d0d] rounded-full mr-2"></span>
                            Offres de la direction : <span class="ml-1 text-[#970d0d]">{{ $selectedDirection->nom }}</span>
                        </h3>
                        <a href="{{ route('admin.offres.create', ['direction_id' => $selectedDirection->id]) }}" 
                           class="bg-gradient-to-r from-green-500 to-green-600 text-white px-5 py-2 rounded-lg hover:from-green-600 hover:to-green-700 transition-all shadow-md hover:shadow-lg flex items-center gap-2 self-start">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Nouvelle offre
                        </a>
                    </div>

                    <!-- Filtres -->
                    <form method="GET" class="flex flex-wrap gap-3 mb-6 p-4 bg-gray-50 rounded-lg">
                        <input type="hidden" name="direction_id" value="{{ $selectedDirection->id }}">
                        <div class="relative flex-1 min-w-[200px]">
                            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <input type="text" name="search" placeholder="Rechercher par titre..." value="{{ request('search') }}"
                                   class="pl-10 pr-4 py-2 border border-gray-200 rounded-lg w-full focus:ring-2 focus:ring-[#970d0d] focus:border-transparent">
                        </div>
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
                    </form>

                    <!-- Tableau -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
              
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Titre</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Contrat</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Expérience</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Statut</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Publication</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                                   </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse($offres as $offre)
                                <tr class="table-row">
                                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">{{ $offre->titre }} </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ $offre->typeContrat->nom ?? '-' }} </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ $offre->niveauExperience->nom ?? '-' }} </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="px-3 py-1 text-xs rounded-full font-semibold
                                            @if($offre->statut == 'ouverte') bg-green-100 text-green-800
                                            @elseif($offre->statut == 'fermée') bg-red-100 text-red-800
                                            @else bg-gray-100 text-gray-800 @endif">
                                            {{ ucfirst($offre->statut) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ $offre->date_publication->format('d/m/Y') }} </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('admin.offres.show', $offre->slug) }}" class="action-button text-indigo-600 hover:text-indigo-900 bg-indigo-50 p-2 rounded-lg" title="Voir">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>
                                            <a href="{{ route('admin.offres.edit', $offre) }}" class="action-button text-amber-600 hover:text-amber-900 bg-amber-50 p-2 rounded-lg" title="Modifier">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                            @if($offre->statut == 'brouillon')
                                                <form action="{{ route('admin.offres.valider', $offre) }}" method="POST" class="inline" onsubmit="return confirm('Valider cette offre ?')">
                                                    @csrf
                                                    <button type="submit" class="action-button text-green-600 hover:text-green-900 bg-green-50 p-2 rounded-lg" title="Valider">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            @endif
                                            @if($offre->statut == 'ouverte')
                                                <form action="{{ route('admin.offres.fermer', $offre) }}" method="POST" class="inline" onsubmit="return confirm('Fermer cette offre ?')">
                                                    @csrf
                                                    <button type="submit" class="action-button text-gray-600 hover:text-gray-900 bg-gray-50 p-2 rounded-lg" title="Fermer">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            @endif
                                            <form action="{{ route('admin.offres.destroy', $offre) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer cette offre ?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="action-button text-red-600 hover:text-red-900 bg-red-50 p-2 rounded-lg" title="Supprimer">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-10 text-center text-gray-500">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                        </svg>
                                        <p class="mt-2 text-sm">Aucune offre dans cette direction.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($offres->hasPages())
                    <div class="mt-4">
                        {{ $offres->appends(request()->query())->links() }}
                    </div>
                    @endif
                </div>
            @else
                <div class="bg-white rounded-xl shadow-lg p-10 text-center text-gray-500">
                    <svg class="mx-auto h-16 w-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <p class="mt-4 text-lg">Veuillez sélectionner une direction dans la liste de gauche.</p>
                </div>
            @endif
        </div>
    </div>
@endsection