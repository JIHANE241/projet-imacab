@extends('layouts.admin')

@section('header', 'Modifier l\'entretien')

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
        <div class="bg-gradient-to-r from-[#970d0d] to-[#7a0a0a] px-6 py-5 rounded-t-xl">
            <h2 class="text-xl font-bold text-white">Modifier l'entretien</h2>
            <p class="text-red-100 text-sm mt-1">Tous les champs marqués d’un astérisque (*) sont obligatoires</p>
        </div>
        <div class="p-6">
            <form method="POST" action="{{ route('admin.entretiens.update', $entretien) }}">
                @csrf
                @method('PUT')

                <!-- Candidature (lecture seule) -->
                <div>
                    <label for="candidature_id_display" class="block text-sm font-medium text-gray-700 mb-1">Candidature</label>
                    <div class="relative border border-gray-200 rounded-lg bg-gray-50 overflow-hidden">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <input type="text" id="candidature_id_display"
                               value="{{ optional($entretien->candidature?->candidat)->name ?? '---' }} - {{ optional($entretien->candidature?->offre)->titre ?? '---' }}"
                               class="pl-10 pr-4 py-2 w-full border-0 bg-transparent focus:ring-0 text-gray-700" disabled>
                    </div>
                    <input type="hidden" name="candidature_id" value="{{ $entretien->candidature_id }}">
                </div>

                <!-- Date et Heure -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <div>
                        <label for="date" class="block text-sm font-medium text-gray-700 mb-1">
                            Date <span class="text-red-500">*</span>
                        </label>
                        <div class="relative input-icon border border-gray-200 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <input type="date" name="date" id="date" value="{{ old('date', $entretien->date->format('Y-m-d')) }}" required
                                   class="pl-10 pr-4 py-2 w-full border-0 focus:ring-0 focus:outline-none">
                        </div>
                        @error('date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="heure" class="block text-sm font-medium text-gray-700 mb-1">
                            Heure <span class="text-red-500">*</span>
                        </label>
                        <div class="relative input-icon border border-gray-200 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <input type="time" name="heure" id="heure" value="{{ old('heure', $entretien->heure->format('H:i')) }}" required
                                   class="pl-10 pr-4 py-2 w-full border-0 focus:ring-0 focus:outline-none">
                        </div>
                        @error('heure')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Lieu -->
                <div class="mt-6">
                    <label for="lieu" class="block text-sm font-medium text-gray-700 mb-1">Lieu / Lien visio</label>
                    <div class="relative input-icon border border-gray-200 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <input type="text" name="lieu" id="lieu" value="{{ old('lieu', $entretien->lieu) }}"
                               class="pl-10 pr-4 py-2 w-full border-0 focus:ring-0 focus:outline-none"
                               placeholder="Ex: Salle 3 ou lien Zoom">
                    </div>
                    @error('lieu')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Statut -->
                <div class="mt-6">
                    <label for="statut" class="block text-sm font-medium text-gray-700 mb-1">
                        Statut <span class="text-red-500">*</span>
                    </label>
                    <div class="relative input-icon border border-gray-200 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <select name="statut" id="statut" required
                                class="pl-10 pr-8 py-2 w-full border-0 focus:ring-0 focus:outline-none appearance-none bg-white">
                            <option value="planifie" {{ old('statut', $entretien->statut) == 'planifie' ? 'selected' : '' }}>Planifié</option>
                            <option value="passe" {{ old('statut', $entretien->statut) == 'passe' ? 'selected' : '' }}>Passé</option>
                            <option value="annule" {{ old('statut', $entretien->statut) == 'annule' ? 'selected' : '' }}>Annulé</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                    @error('statut')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Boutons -->
                <div class="mt-8 flex items-center justify-end gap-4">
                    <a href="{{ route('admin.entretiens.index') }}" 
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