@extends('layouts.responsable')

@section('header', 'Nouvelle offre')

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
<div class="max-w-4xl mx-auto animate-fade-in-up delay-1">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <!-- En-tête avec dégradé -->
        <div class="bg-gradient-to-r from-[#970d0d] to-[#7a0a0a] px-6 py-5 rounded-t-xl">
            <h2 class="text-xl font-bold text-white">Créer une nouvelle offre</h2>
            <p class="text-red-100 text-sm mt-1">Tous les champs marqués d’un astérisque (*) sont obligatoires</p>
        </div>

        <!-- Formulaire -->
        <div class="p-6">
            <form method="POST" action="{{ route('responsable.offres.store') }}">
                @csrf

                <!-- Ligne Titre / Catégorie -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="titre" class="block text-sm font-medium text-gray-700 mb-1">
                            Titre <span class="text-red-500">*</span>
                        </label>
                        <div class="relative input-icon border border-gray-200 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                                </svg>
                            </div>
                            <input type="text" name="titre" id="titre" value="{{ old('titre') }}" required
                                   class="pl-10 pr-4 py-2 w-full border-0 focus:ring-0 focus:outline-none"
                                   placeholder="Ex: Chef de projet">
                        </div>
                        @error('titre')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">
                            Catégorie <span class="text-red-500">*</span>
                        </label>
                        <div class="relative input-icon border border-gray-200 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l5 5a2 2 0 01.586 1.414V19a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z" />
                                </svg>
                            </div>
                            <select name="category_id" id="category_id" required
                                    class="pl-10 pr-8 py-2 w-full border-0 focus:ring-0 focus:outline-none appearance-none bg-white">
                                <option value="">Sélectionner</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->nom }}</option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                        @error('category_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Description -->
                <div class="mt-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                        Description <span class="text-red-500">*</span>
                    </label>
                    <div class="relative input-icon border border-gray-200 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500">
                        <div class="absolute top-3 left-3 flex items-start pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                            </svg>
                        </div>
                        <textarea name="description" id="description" rows="6" required
                                  class="pl-10 pr-4 py-2 w-full border-0 focus:ring-0 focus:outline-none"
                                  placeholder="Détails du poste...">{{ old('description') }}</textarea>
                    </div>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Ligne Type contrat / Niveau exp / Niveau études / Ville (4 colonnes) -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-6">
                    <div>
                        <label for="type_contrat_id" class="block text-sm font-medium text-gray-700 mb-1">
                            Type de contrat <span class="text-red-500">*</span>
                        </label>
                        <div class="relative input-icon border border-gray-200 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <select name="type_contrat_id" id="type_contrat_id" required
                                    class="pl-10 pr-8 py-2 w-full border-0 focus:ring-0 focus:outline-none appearance-none bg-white">
                                <option value="">Sélectionner</option>
                                @foreach($typesContrat as $tc)
                                    <option value="{{ $tc->id }}" {{ old('type_contrat_id') == $tc->id ? 'selected' : '' }}>{{ $tc->nom }}</option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                        @error('type_contrat_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="niveau_experience_id" class="block text-sm font-medium text-gray-700 mb-1">
                            Niveau d'expérience <span class="text-red-500">*</span>
                        </label>
                        <div class="relative input-icon border border-gray-200 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <select name="niveau_experience_id" id="niveau_experience_id" required
                                    class="pl-10 pr-8 py-2 w-full border-0 focus:ring-0 focus:outline-none appearance-none bg-white">
                                <option value="">Sélectionner</option>
                                @foreach($niveauxExperience as $ne)
                                    <option value="{{ $ne->id }}" {{ old('niveau_experience_id') == $ne->id ? 'selected' : '' }}>{{ $ne->nom }}</option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                        @error('niveau_experience_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="niveau_etude_id" class="block text-sm font-medium text-gray-700 mb-1">
                            Niveau d'études <span class="text-red-500">*</span>
                        </label>
                        <div class="relative input-icon border border-gray-200 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                                </svg>
                            </div>
                            <select name="niveau_etude_id" id="niveau_etude_id" required
                                    class="pl-10 pr-8 py-2 w-full border-0 focus:ring-0 focus:outline-none appearance-none bg-white">
                                <option value="">Sélectionner</option>
                                @foreach($niveauxEtude as $ne)
                                    <option value="{{ $ne->id }}" {{ old('niveau_etude_id') == $ne->id ? 'selected' : '' }}>{{ $ne->nom }}</option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                        @error('niveau_etude_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                <!-- Ligne Dates (publi / limite) + salaires (min / max) -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-6">
                    <div>
                        <label for="date_publication" class="block text-sm font-medium text-gray-700 mb-1">
                            Date de publication <span class="text-red-500">*</span>
                        </label>
                        <div class="relative input-icon border border-gray-200 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <input type="date" name="date_publication" id="date_publication" value="{{ old('date_publication', now()->format('Y-m-d')) }}" required
                                   class="pl-10 pr-4 py-2 w-full border-0 focus:ring-0 focus:outline-none">
                        </div>
                        @error('date_publication')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="date_limite" class="block text-sm font-medium text-gray-700 mb-1">Date limite</label>
                        <div class="relative input-icon border border-gray-200 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <input type="date" name="date_limite" id="date_limite" value="{{ old('date_limite') }}"
                                   class="pl-10 pr-4 py-2 w-full border-0 focus:ring-0 focus:outline-none">
                        </div>
                        @error('date_limite')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="salaire_min" class="block text-sm font-medium text-gray-700 mb-1">Salaire min (MAD)</label>
                        <div class="relative input-icon border border-gray-200 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <input type="number" name="salaire_min" id="salaire_min" value="{{ old('salaire_min') }}"
                                   class="pl-10 pr-4 py-2 w-full border-0 focus:ring-0 focus:outline-none"
                                   placeholder="0">
                        </div>
                        @error('salaire_min')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="salaire_max" class="block text-sm font-medium text-gray-700 mb-1">Salaire max (MAD)</label>
                        <div class="relative input-icon border border-gray-200 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <input type="number" name="salaire_max" id="salaire_max" value="{{ old('salaire_max') }}"
                                   class="pl-10 pr-4 py-2 w-full border-0 focus:ring-0 focus:outline-none"
                                   placeholder="0">
                        </div>
                        @error('salaire_max')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Champs supplémentaires : Missions et Profil -->
                <div class="mt-6">
                    <label for="missions" class="block text-sm font-medium text-gray-700 mb-1">Missions (optionnel)</label>
                    <textarea name="missions" id="missions" rows="4" class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#970d0d] focus:border-transparent">{{ old('missions') }}</textarea>
                </div>

                <div class="mt-6">
                    <label for="profil" class="block text-sm font-medium text-gray-700 mb-1">Profil recherché (optionnel)</label>
                    <textarea name="profil" id="profil" rows="4" class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#970d0d] focus:border-transparent">{{ old('profil') }}</textarea>
                </div>

                <!-- Boutons -->
                <div class="mt-8 flex items-center justify-end gap-4">
                    <a href="{{ route('responsable.offres.index') }}" 
                       class="px-6 py-2.5 border border-gray-200 rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors shadow-sm">
                        Annuler
                    </a>
                    <button type="submit" 
                            class="px-6 py-2.5 bg-gradient-to-r from-[#970d0d] to-[#7a0a0a] text-white rounded-lg hover:from-[#7a0a0a] hover:to-[#5f0808] transition-all shadow-md hover:shadow-lg flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Créer l'offre
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection