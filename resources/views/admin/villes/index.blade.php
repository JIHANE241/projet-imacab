@extends('layouts.admin')

@section('header', 'Gestion des villes')

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

    .input-icon {
        transition: all 0.2s ease;
    }
    .input-icon:focus-within {
        border-color: #970d0d;
        box-shadow: 0 0 0 3px rgba(151, 13, 13, 0.2);
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
    <!-- Formulaire d'ajout -->
    <div class="max-w-2xl mx-auto animate-fade-in-up delay-1">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-[#970d0d] to-[#7a0a0a] px-6 py-4">
                <h2 class="text-lg font-semibold text-white flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Ajouter une ville
                </h2>
            </div>
            <div class="p-5">
                <form method="POST" action="{{ route('admin.villes.store') }}" class="flex gap-2">
                    @csrf
                    <div class="relative input-icon border border-gray-200 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500 flex-1">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <input type="text" name="nom" placeholder="Ex: Casablanca, Rabat, Tanger..." 
                               class="pl-10 pr-4 py-2 w-full border-0 focus:ring-0 focus:outline-none" 
                               required>
                    </div>
                    <button type="submit" 
                            class="bg-gradient-to-r from-[#970d0d] to-[#7a0a0a] text-white px-5 py-2 rounded-lg hover:from-[#7a0a0a] hover:to-[#5f0808] transition-all shadow-md hover:shadow-lg flex items-center gap-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Ajouter
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Liste des villes -->
    <div class="max-w-2xl mx-auto mt-8 animate-fade-in-up delay-2">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-[#970d0d] to-[#7a0a0a] px-6 py-4">
                <h2 class="text-lg font-semibold text-white flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                    </svg>
                    Villes existantes
                </h2>
            </div>
            <div class="p-5">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nom</th>
                                <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach($villes as $ville)
                            <tr class="table-row">
                                <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">{{ $ville->nom }}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-right">
                                    <div class="flex items-center justify-end space-x-2">
                                        <!-- Formulaire de modification inline -->
                                        <form action="{{ route('admin.villes.update', $ville) }}" method="POST" class="inline">
                                            @csrf @method('PUT')
                                            <div class="flex items-center space-x-1">
                                                <input type="text" name="nom" value="{{ $ville->nom }}" 
                                                       class="border border-gray-200 rounded-lg px-2 py-1 text-sm w-24 focus:ring-2 focus:ring-[#970d0d] focus:border-transparent">
                                                <button type="submit" class="action-button text-green-600 hover:text-green-900 bg-green-50 p-1.5 rounded-lg" title="Modifier">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </form>
                                        <!-- Formulaire de suppression -->
                                        <form action="{{ route('admin.villes.destroy', $ville) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer cette ville ?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="action-button text-red-600 hover:text-red-900 bg-red-50 p-1.5 rounded-lg" title="Supprimer">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if($villes->isEmpty())
                        <p class="text-center text-gray-500 py-4">Aucune ville enregistrée.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection