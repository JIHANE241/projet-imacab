@extends('layouts.admin')

@section('header', 'Modifier une direction')

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
</style>
@endpush

@section('content')
<div class="max-w-2xl mx-auto animate-fade-in-up delay-1">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <!-- En-tête avec dégradé -->
        <div class="bg-gradient-to-r from-[#970d0d] to-[#7a0a0a] px-6 py-5 rounded-t-xl">
            <h2 class="text-xl font-bold text-white">Modifier une direction</h2>
            <p class="text-red-100 text-sm mt-1">Tous les champs marqués d’un astérisque (*) sont obligatoires</p>
        </div>

        <!-- Formulaire -->
        <div class="p-6">
            <form method="POST" action="{{ route('admin.directions.update', $direction) }}">
                @csrf
                @method('PUT')

                <!-- Nom de la direction -->
                <div>
                    <label for="nom" class="block text-sm font-medium text-gray-700 mb-1">
                        Nom de la direction <span class="text-red-500">*</span>
                    </label>
                    <div class="relative input-icon border border-gray-200 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <input type="text" name="nom" id="nom" value="{{ old('nom', $direction->nom) }}" required
                               class="pl-10 pr-4 py-2 w-full border-0 focus:ring-0 focus:outline-none"
                               placeholder="Ex: Direction financière">
                    </div>
                    @error('nom')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Responsable (select) -->
                <div class="mt-6">
                    <label for="responsable_id" class="block text-sm font-medium text-gray-700 mb-1">
                        Responsable (optionnel)
                    </label>
                    <div class="relative input-icon border border-gray-200 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <select name="responsable_id" id="responsable_id"
                                class="pl-10 pr-8 py-2 w-full border-0 focus:ring-0 focus:outline-none appearance-none bg-white">
                            <option value="">Aucun responsable</option>
                            @foreach($responsables as $resp)
                                <option value="{{ $resp->id }}" {{ old('responsable_id', $direction->responsable->id ?? '') == $resp->id ? 'selected' : '' }}>
                                    {{ $resp->name }} {{ $resp->prenom ?? '' }}
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                    @error('responsable_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Boutons d'action -->
                <div class="mt-8 flex items-center justify-end gap-4">
                    <a href="{{ route('admin.directions.index') }}" 
                       class="px-6 py-2.5 border border-gray-200 rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors shadow-sm">
                        Annuler
                    </a>
                    <button type="submit" 
                            class="px-6 py-2.5 bg-gradient-to-r from-[#970d0d] to-[#7a0a0a] text-white rounded-lg hover:from-[#7a0a0a] hover:to-[#5f0808] transition-all shadow-md hover:shadow-lg flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection