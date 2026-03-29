@extends('layouts.admin')

@section('header', 'Gestion des candidatures')

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
        background-color: #fef2f2; /* rouge très clair */
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
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8 animate-fade-in-up delay-1">
        <div class="stat-card bg-gradient-to-br from-[#970d0d] to-[#7a0a0a] text-white p-5 rounded-xl shadow-xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium opacity-90">Total</p>
                    <p class="text-3xl font-bold">{{ $stats['total'] }}</p>
                </div>
                <div class="bg-white/20 p-3 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
            </div>
        </div>
        <div class="stat-card bg-gradient-to-br from-emerald-600 to-emerald-700 text-white p-5 rounded-xl shadow-xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium opacity-90">Acceptées</p>
                    <p class="text-3xl font-bold">{{ $stats['acceptees'] }}</p>
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
                    <p class="text-sm font-medium opacity-90">Refusées</p>
                    <p class="text-3xl font-bold">{{ $stats['refusees'] }}</p>
                </div>
                <div class="bg-white/20 p-3 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>
            </div>
        </div>
        <div class="stat-card bg-gradient-to-br from-blue-600 to-blue-700 text-white p-5 rounded-xl shadow-xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium opacity-90">En attente</p>
                    <p class="text-3xl font-bold">{{ $stats['en_attente'] }}</p>
                </div>
                <div class="bg-white/20 p-3 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="flex flex-wrap md:flex-nowrap gap-6">
        <!-- Liste des directions avec compteurs -->
        <div class="w-full md:w-72 bg-white rounded-xl shadow-lg p-5 h-fit animate-fade-in-up delay-2">
            <h3 class="font-semibold text-lg mb-4 flex items-center">
                <span class="w-2 h-2 bg-[#970d0d] rounded-full mr-2"></span>
                Directions
            </h3>
            <ul class="space-y-1">
                @foreach($directions as $dir)
                    <li>
                        <a href="{{ route('admin.candidatures.index', ['direction_id' => $dir->id]) }}"
                           class="direction-item flex justify-between items-center p-3 rounded-lg {{ $selectedDirection && $selectedDirection->id == $dir->id ? 'bg-[#970d0d]/10 border-l-4 border-[#970d0d] font-medium' : 'hover:bg-gray-50' }}">
                            <span class="text-gray-800">{{ $dir->nom }}</span>
                            <span class="bg-gray-200 text-gray-700 px-2 py-0.5 rounded-full text-xs font-semibold">{{ $dir->candidatures_count }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Tableau des candidatures (colonne droite) -->
        <div class="flex-1 animate-fade-in-up delay-3">
            @if($selectedDirection)
                <div class="bg-white rounded-xl shadow-lg p-5">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-4">
                        <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                            <span class="w-2 h-2 bg-[#970d0d] rounded-full mr-2"></span>
                            Candidatures pour la direction : <span class="ml-1 text-[#970d0d]">{{ $selectedDirection->nom }}</span>
                        </h3>
                    </div>

                    <!-- Filtres -->
                    <form method="GET" class="flex flex-wrap gap-3 mb-6 p-4 bg-gray-50 rounded-lg">
                        <input type="hidden" name="direction_id" value="{{ $selectedDirection->id }}">
                        <div class="relative flex-1 min-w-[200px]">
                            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <input type="text" name="search" placeholder="Candidat ou offre..." value="{{ request('search') }}"
                                   class="pl-10 pr-4 py-2 border border-gray-200 rounded-lg w-full focus:ring-2 focus:ring-[#970d0d] focus:border-transparent">
                        </div>
                        <select name="statut" class="border border-gray-200 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#970d0d] focus:border-transparent">
                            <option value="">Tous statuts</option>
                            <option value="en_attente" {{ request('statut') == 'en_attente' ? 'selected' : '' }}>En attente</option>
                            <option value="acceptee" {{ request('statut') == 'acceptee' ? 'selected' : '' }}>Acceptée</option>
                            <option value="refusee" {{ request('statut') == 'refusee' ? 'selected' : '' }}>Refusée</option>
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
                                
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Candidat</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Offre</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Exp.</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Adresse</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Formation</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Commentaire RD</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Avis responsable</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Statut</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Entretien</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                            
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse($candidatures as $c)
                                <tr class="table-row">
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-8 w-8 bg-gradient-to-br from-[#970d0d] to-[#7a0a0a] rounded-full flex items-center justify-center text-white font-semibold text-xs">
                                                {{ strtoupper(substr($c->candidat->name, 0, 1)) }}{{ strtoupper(substr($c->candidat->prenom ?? '', 0, 1)) }}
                                            </div>
                                            <span class="ml-2 text-sm font-medium text-gray-900">{{ $c->candidat->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ $c->offre->titre }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ $c->niveau_experience ? Str::title(str_replace('_', ' ', $c->niveau_experience)) : '-' }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ Str::limit($c->adresse ?? '-', 15) }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ Str::limit($c->formation ?? '-', 15) }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ Str::limit($c->commentaire_rd ?? '-', 15) }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        @if($c->evaluation)
                                            <span class="px-3 py-1 text-xs rounded-full font-semibold
                                                @if($c->evaluation == 'favorable') bg-green-100 text-green-800
                                                @elseif($c->evaluation == 'defavorable') bg-red-100 text-red-800
                                                @endif">
                                                {{ ucfirst($c->evaluation) }}
                                            </span>
                                        @else
                                            <span class="text-gray-400 text-xs">Non évalué</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
    <form action="{{ route('admin.candidatures.updateStatut', $c) }}" method="POST" class="inline-flex items-center gap-1">
        @csrf
        <select name="statut" class="border border-gray-300 rounded text-sm py-1 px-2 focus:ring-[#970d0d] focus:border-[#970d0d]">
            <option value="en_attente" {{ $c->statut == 'en_attente' ? 'selected' : '' }}>En attente</option>
            <option value="acceptee" {{ $c->statut == 'acceptee' ? 'selected' : '' }}>Acceptée</option>
            <option value="refusee" {{ $c->statut == 'refusee' ? 'selected' : '' }}>Refusée</option>
        </select>
        <button type="submit" class="text-indigo-600 hover:text-indigo-900" title="Modifier le statut">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
            </svg>
        </button>
    </form>
</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">
                                        @if($c->entretien_planifie)
                                            <span class="text-green-600 font-medium">Oui</span>
                                        @else
                                            <span class="text-gray-400">Non</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('admin.candidatures.show', $c) }}" class="action-button text-indigo-600 hover:text-indigo-900 bg-indigo-50 p-2 rounded-lg" title="Voir">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>
                                            @if($c->statut == 'en_attente')
                                                <form action="{{ route('admin.candidatures.accepter', $c) }}" method="POST" class="inline" onsubmit="return confirm('Accepter cette candidature ?')">
                                                    @csrf
                                                    <button type="submit" class="action-button text-green-600 hover:text-green-900 bg-green-50 p-2 rounded-lg" title="Accepter">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                        </svg>
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.candidatures.refuser', $c) }}" method="POST" class="inline" onsubmit="return confirm('Refuser cette candidature ?')">
                                                    @csrf
                                                    <button type="submit" class="action-button text-red-600 hover:text-red-900 bg-red-50 p-2 rounded-lg" title="Refuser">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            @endif
                                            @if($c->cv_path)
                                                <a href="{{ route('admin.candidatures.cv', $c) }}" target="_blank" class="action-button text-blue-600 hover:text-blue-900 bg-blue-50 p-2 rounded-lg" title="CV">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                    </svg>
                                                </a>
                                            @endif
                                            <form action="{{ route('admin.candidatures.destroy', $c) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer cette candidature ?')">
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
                                    <td colspan="10" class="px-4 py-10 text-center text-gray-500">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <p class="mt-2 text-sm">Aucune candidature dans cette direction.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($candidatures->hasPages())
                    <div class="mt-4">
                        {{ $candidatures->appends(request()->query())->links() }}
                    </div>
                    @endif
                </div>
            @else
                <div class="bg-white rounded-xl shadow-lg p-10 text-center text-gray-500">
                    <svg class="mx-auto h-16 w-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <p class="mt-4 text-lg">Veuillez sélectionner une direction dans la liste de gauche.</p>
                </div>
            @endif
        </div>
    </div>
@endsection