@extends('layouts.admin')

@section('header', 'Gestion des entretiens')

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
@if($todayEntretiens->count())
    <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-4 rounded">
        ⚠️ Vous avez {{ $todayEntretiens->count() }} entretien(s) aujourd’hui !
    </div>
@endif
    <div class="flex justify-end mb-6 animate-fade-in-up delay-1">
        <a href="{{ route('admin.entretiens.create') }}" 
           class="bg-gradient-to-r from-[#970d0d] to-[#7a0a0a] text-white px-6 py-2.5 rounded-lg hover:from-[#7a0a0a] hover:to-[#5f0808] transition-all shadow-md hover:shadow-lg flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Planifier un entretien
        </a>
    </div>

    <!-- Filtres -->
    <div class="bg-white rounded-xl shadow-lg p-5 mb-8 animate-fade-in-up delay-2">
        <form method="GET"  action="{{ route('admin.entretiens.index') }}" class="flex flex-wrap gap-4 items-center" >
            <select name="statut" class="border border-gray-200 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#970d0d] focus:border-transparent">
                <option value="">Tous statuts</option>
                <option value="planifie" {{ request('statut') == 'planifie' ? 'selected' : '' }}>Planifié</option>
                <option value="passe" {{ request('statut') == 'passe' ? 'selected' : '' }}>Passé</option>
                <option value="annule" {{ request('statut') == 'annule' ? 'selected' : '' }}>Annulé</option>
            </select>
            <input type="date" name="date_debut" value="{{ request('date_debut') }}" 
                   class="border border-gray-200 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#970d0d] focus:border-transparent">
            <button type="submit" class="bg-[#970d0d] text-white px-6 py-2 rounded-lg hover:bg-[#7a0a0a] transition-colors shadow-md flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                </svg>
                Filtrer
            </button>
        </form>
    </div>

    <!-- Tableau -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden animate-fade-in-up delay-3">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Candidat</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Offre</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Heure</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Lieu</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Statut</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($entretiens as $e)
                    <tr class="table-row">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $e->candidature->candidat->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $e->candidature->offre->titre }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $e->date->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $e->heure->format('H:i') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $e->lieu ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 text-xs rounded-full font-semibold
                                @if($e->statut == 'planifie') bg-blue-100 text-blue-800
                                @elseif($e->statut == 'passe') bg-green-100 text-green-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ ucfirst($e->statut) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.entretiens.show', $e) }}" class="action-button text-indigo-600 hover:text-indigo-900 bg-indigo-50 p-2 rounded-lg" title="Voir">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>
                                <a href="{{ route('admin.entretiens.edit', $e) }}" class="action-button text-amber-600 hover:text-amber-900 bg-amber-50 p-2 rounded-lg" title="Modifier">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                <form action="{{ route('admin.entretiens.destroy', $e) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer cet entretien ?')">
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
                        <td colspan="7" class="px-6 py-10 text-center text-gray-500">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="mt-2 text-sm">Aucun entretien trouvé.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($entretiens->hasPages())
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
            {{ $entretiens->links() }}
        </div>
        @endif
    </div>
@endsection