@extends('layouts.admin')

@section('header', 'Nouvel utilisateur')

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

    .input-icon {
        transition: all 0.2s ease;
    }
    .input-icon:focus-within {
        border-color: #970d0d;
        box-shadow: 0 0 0 3px rgba(138, 4, 4, 0.856);
    }
</style>
@endpush

@section('content')
<div class="max-w-3xl mx-auto animate-fade-in-up delay-1">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <!-- En-tête avec dégradé -->
        <div class="bg-gradient-to-r from-[#970d0d] to-[#7a0a0a] px-6 py-5 rounded-t-xl">
            <h2 class="text-xl font-bold text-white">Créer un nouvel utilisateur</h2>
            <p class="text-indigo-100 text-sm mt-1">Tous les champs marqués d’un astérisque (*) sont obligatoires</p>
        </div>

        <!-- Formulaire -->
        <div class="p-6">
            <form method="POST" action="{{ route('admin.utilisateurs.store') }}">
                @csrf

                <!-- Ligne Nom / Prénom -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                            Nom <span class="text-red-500">*</span>
                        </label>
                        <div class="relative input-icon border border-gray-200 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                class="pl-10 pr-4 py-2 w-full border-0 focus:ring-0 focus:outline-none"
                                placeholder="Dupont">
                        </div>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="prenom" class="block text-sm font-medium text-gray-700 mb-1">Prénom</label>
                        <div class="relative input-icon border border-gray-200 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <input type="text" name="prenom" id="prenom" value="{{ old('prenom') }}"
                                class="pl-10 pr-4 py-2 w-full border-0 focus:ring-0 focus:outline-none"
                                placeholder="Jean">
                        </div>
                    </div>
                </div>

                <!-- Email -->
                <div class="mt-6">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                        Adresse email <span class="text-red-500">*</span>
                    </label>
                    <div class="relative input-icon border border-gray-200 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required
                            class="pl-10 pr-4 py-2 w-full border-0 focus:ring-0 focus:outline-none"
                            placeholder="admin@imacab.com">
                    </div>
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Téléphone -->
                <div class="mt-6">
                    <label for="telephone" class="block text-sm font-medium text-gray-700 mb-1">Téléphone</label>
                    <div class="relative input-icon border border-gray-200 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </div>
                        <input type="text" name="telephone" id="telephone" value="{{ old('telephone') }}"
                            class="pl-10 pr-4 py-2 w-full border-0 focus:ring-0 focus:outline-none"
                            placeholder="+212 6 12 34 56 78">
                    </div>
                </div>

                <!-- Rôle -->
                <div class="mt-6">
                    <label for="role" class="block text-sm font-medium text-gray-700 mb-1">
                        Rôle <span class="text-red-500">*</span>
                    </label>
                    <div class="relative input-icon border border-gray-200 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <select name="role" id="role" required
                            class="pl-10 pr-8 py-2 w-full border-0 focus:ring-0 focus:outline-none appearance-none bg-white">
                            <option value="">Sélectionner un rôle</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin RH</option>
                            <option value="responsable" {{ old('role') == 'responsable' ? 'selected' : '' }}>Responsable département</option>
                            <option value="candidat" {{ old('role') == 'candidat' ? 'selected' : '' }}>Candidat</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                    @error('role')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Direction (toujours visible, inchangé) -->
                <div class="mt-6">
                    <label for="direction_id" class="block text-sm font-medium text-gray-700 mb-1">
                        Direction (pour responsable)
                    </label>
                    <div class="relative input-icon border border-gray-200 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <select name="direction_id" id="direction_id"
                            class="pl-10 pr-8 py-2 w-full border-0 focus:ring-0 focus:outline-none appearance-none bg-white">
                            <option value="">Aucune</option>
                            @foreach($directions as $direction)
                                <option value="{{ $direction->id }}" {{ old('direction_id') == $direction->id ? 'selected' : '' }}>{{ $direction->nom }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Séparation -->
                <hr class="my-8 border-gray-200">

                <!-- Section Sécurité -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-[#970d0d]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        Sécurité du compte
                    </h3>

                    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                                Mot de passe <span class="text-red-500">*</span>
                            </label>
                            <div class="relative input-icon border border-gray-200 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                                <input type="password" name="password" id="password" required
                                    class="pl-10 pr-4 py-2 w-full border-0 focus:ring-0 focus:outline-none"
                                    placeholder="*********">
                            </div>
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                                Confirmer le mot de passe <span class="text-red-500">*</span>
                            </label>
                            <div class="relative input-icon border border-gray-200 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                                <input type="password" name="password_confirmation" id="password_confirmation" required
                                    class="pl-10 pr-4 py-2 w-full border-0 focus:ring-0 focus:outline-none"
                                    placeholder="*********">
                            </div>
                        </div>
                    </div>

                    <!-- Conseil de sécurité -->
                    <div class="mt-4 p-4 bg-red-50 rounded-lg border border-red-100 flex items-start">
    <svg class="w-5 h-5 text-[#970d0d] mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
    </svg>

    <p class="text-sm text-red-900">
        <span class="font-medium">Conseil de sécurité :</span> Utilisez au moins 8 caractères avec des lettres majuscules, minuscules, chiffres et symboles.
    </p>
</div>

                <!-- Boutons d'action -->
                <div class="mt-8 flex items-center justify-end gap-4">
                    <a href="{{ route('admin.utilisateurs.index') }}" 
                       class="px-6 py-2.5 border border-gray-200 rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors shadow-sm">
                        Annuler
                    </a>
                    <button type="submit" 
class="px-6 py-2.5 bg-gradient-to-r from-[#970d0d] to-[#7a0a0a] text-white rounded-lg hover:from-[#7a0a0a] hover:to-[#5f0808] transition-all shadow-md hover:shadow-lg flex items-center gap-2">

    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
    </svg>

    Créer l'utilisateur
</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection