@extends('layouts.admin')

@section('header', 'Gestion des directions')

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
    .delay-3 { animation-delay: 0.3s; }

    .stat-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    .table-row {
        transition: background-color 0.2s ease;
    }
    .table-row:hover {
        background-color: #fef2f2; /* rouge très clair */
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
    <!-- Mini statistiques facultatives (pour renforcer le style) -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 animate-fade-in-up delay-1">
        <div class="stat-card bg-gradient-to-br from-[#970d0d] to-[#7a0a0a] text-white p-5 rounded-xl shadow-xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium opacity-90">Total directions</p>
                    <p class="text-3xl font-bold">{{ $directions->count() }}</p>
                </div>
                <div class="bg-white/20 p-3 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
            </div>
        </div>
        <div class="stat-card bg-gradient-to-br from-amber-600 to-amber-700 text-white p-5 rounded-xl shadow-xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium opacity-90">Avec responsable</p>
                    <p class="text-3xl font-bold">{{ $directions->filter(fn($d) => $d->responsable)->count() }}</p>
                </div>
                <div class="bg-white/20 p-3 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
            </div>
        </div>
        <div class="stat-card bg-gradient-to-br from-emerald-600 to-emerald-700 text-white p-5 rounded-xl shadow-xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium opacity-90">Total offres</p>
                    <p class="text-3xl font-bold">{{ $directions->sum('offres_count') }}</p>
                </div>
                <div class="bg-white/20 p-3 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Barre d'outils -->
    <div class="bg-white rounded-xl shadow-lg p-5 mb-8 flex flex-col md:flex-row gap-4 items-center justify-between animate-fade-in-up delay-2">
        <div class="flex items-center gap-2 text-gray-700">
            <svg class="w-5 h-5 text-[#970d0d]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
            </svg>
            <span class="font-medium">Liste des directions</span>
        </div>
        <a href="{{ route('admin.directions.create') }}" 
           class="bg-gradient-to-r from-[#970d0d] to-[#7a0a0a] text-white px-6 py-2.5 rounded-lg hover:from-[#7a0a0a] hover:to-[#5f0808] transition-all shadow-md hover:shadow-lg flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Nouvelle direction
        </a>
    </div>

    <!-- Tableau -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden animate-fade-in-up delay-3">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nom</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Responsable</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Offres</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Candidatures</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($directions as $direction)
                    <tr class="table-row">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 bg-gradient-to-br from-[#970d0d] to-[#7a0a0a] rounded-lg flex items-center justify-center text-white font-bold text-sm">
                                    {{ strtoupper(substr($direction->nom, 0, 2)) }}
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $direction->nom }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($direction->responsable)
                                <div class="flex items-center">
                                    <div class="h-8 w-8 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-800 font-semibold text-xs">
                                        {{ strtoupper(substr($direction->responsable->name, 0, 1)) }}{{ strtoupper(substr($direction->responsable->prenom ?? '', 0, 1)) }}
                                    </div>
                                    <span class="ml-2 text-sm text-gray-700">{{ $direction->responsable->name }} {{ $direction->responsable->prenom }}</span>
                                </div>
                            @else
                                <span class="text-sm text-gray-400 italic">Non assigné</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-semibold">{{ $direction->offres_count }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold">{{ $direction->candidatures_count }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.directions.show', $direction) }}" class="action-button text-indigo-600 hover:text-indigo-900 bg-indigo-50 p-2 rounded-lg" title="Voir">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>
                                <a href="{{ route('admin.directions.edit', $direction) }}" class="action-button text-amber-600 hover:text-amber-900 bg-amber-50 p-2 rounded-lg" title="Modifier">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                <form action="{{ route('admin.directions.destroy', $direction) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer cette direction ?')">
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
                        <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            <p class="mt-2 text-sm">Aucune direction trouvée.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($directions instanceof \Illuminate\Pagination\LengthAwarePaginator && $directions->hasPages())
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
            {{ $directions->links() }}
        </div>
        @endif
    </div>
@endsection