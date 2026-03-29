@extends('layouts.candidat')

@section('header', 'Mon CV')

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
    .delay-5 { animation-delay: 0.5s; }
    .delay-6 { animation-delay: 0.6s; }
    .delay-7 { animation-delay: 0.7s; }
    .delay-8 { animation-delay: 0.8s; }

    .input-icon {
        transition: all 0.2s ease;
    }
    .input-icon:focus-within {
        border-color: #4f46e5;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
    }

    .profile-photo {
        transition: all 0.3s ease;
    }
    .profile-photo:hover {
        transform: scale(1.05);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    .progress-bar {
        height: 0.5rem;
        background: #e5e7eb;
        border-radius: 9999px;
        overflow: hidden;
    }
    .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, #4f46e5, #818cf8);
        border-radius: 9999px;
        transition: width 0.3s ease;
    }

    .btn-add, .btn-remove {
        transition: all 0.2s;
    }
    .btn-add:hover, .btn-remove:hover {
        transform: translateY(-2px);
    }

    .offer-card {
        transition: all 0.2s ease;
        border: 1px solid #e5e7eb;
    }
    .offer-card:hover {
        transform: translateY(-4px);
        border-color: #4f46e5;
        box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
    }
</style>
@endpush

@section('content')
    @php
        $user = Auth::user();
        // Calcul du pourcentage de complétion (exemple simplifié)
        $completion = 0;
        $fields = ['photo', 'niveau_etude_id', 'niveau_experience_global'];
        foreach ($fields as $field) {
            if ($user->$field) $completion += 20;
        }
        // On ajoute pour les formations, expériences, compétences, langues (simulé)
        $completion = min($completion, 100);

        // Données fictives pour la licence (à adapter selon votre modèle)
        $licenceExpiry = $user->licence_expiry ?? \Carbon\Carbon::now()->addYear();
    @endphp

    <div class="max-w-4xl mx-auto space-y-8">
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded-lg shadow-md animate-fade-in-up delay-1">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('candidat.cv.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- ================================================== -->
            <!-- MON PROFIL (photo + infos détaillées)              -->
            <!-- ================================================== -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden animate-fade-in-up delay-2">
                <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 px-6 py-5">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Mon profil
                    </h2>
                    <p class="text-indigo-100 text-sm mt-1">Complétez vos informations professionnelles</p>
                </div>
                <div class="p-6">
                    <!-- Photo -->
                    <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6 mb-8 pb-6 border-b border-gray-100">
                        <div class="relative">
                            @if($user->photo)
                                <img src="{{ asset('storage/'.$user->photo) }}" alt="Photo" class="profile-photo h-20 w-20 rounded-full object-cover border-2 border-gray-200 shadow-md">
                            @else
                                <div class="profile-photo h-20 w-20 rounded-full bg-gradient-to-br from-indigo-500 to-indigo-600 flex items-center justify-center text-white text-2xl font-bold shadow-md">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}{{ strtoupper(substr($user->prenom ?? '', 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Photo de profil</label>
                            <input type="file" name="photo" accept="image/*"
                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition">
                            <p class="text-xs text-gray-400 mt-1">Formats acceptés : JPG, PNG. Max 2 Mo.</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-sm text-gray-500">Nom</p>
                            <p class="font-semibold text-gray-800">{{ $user->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Prénom</p>
                            <p class="font-semibold text-gray-800">{{ $user->prenom }}</p>
                        </div>
                    </div>

                    <!-- Niveau d'études -->
                    <div class="mb-6">
                        <label for="niveau_etude_id" class="block text-sm font-medium text-gray-700 mb-1">Niveau d'études</label>
                        <div class="relative input-icon border border-gray-200 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                                </svg>
                            </div>
                            <select name="niveau_etude_id" id="niveau_etude_id"
                                    class="pl-10 pr-8 py-2 w-full border-0 focus:ring-0 focus:outline-none appearance-none bg-white">
                                <option value="">Sélectionnez</option>
                                @foreach($niveauxEtudes as $ne)
                                    <option value="{{ $ne->id }}" {{ $user->niveau_etude_id == $ne->id ? 'selected' : '' }}>{{ $ne->nom }}</option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Niveau d'expérience global -->
                    <div>
                        <label for="niveau_experience_global" class="block text-sm font-medium text-gray-700 mb-1">Niveau d'expérience global</label>
                        <div class="relative input-icon border border-gray-200 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <select name="niveau_experience_global" id="niveau_experience_global"
                                    class="pl-10 pr-8 py-2 w-full border-0 focus:ring-0 focus:outline-none appearance-none bg-white">
                                <option value="">Sélectionnez</option>
                                <option value="etudiant" {{ $user->niveau_experience_global == 'etudiant' ? 'selected' : '' }}>Étudiant, jeune diplômé</option>
                                <option value="debutant_moins_2" {{ $user->niveau_experience_global == 'debutant_moins_2' ? 'selected' : '' }}>Débutant < 2 ans</option>
                                <option value="entre_2_5" {{ $user->niveau_experience_global == 'entre_2_5' ? 'selected' : '' }}>Expérience entre 2 ans et 5 ans</option>
                                <option value="entre_5_10" {{ $user->niveau_experience_global == 'entre_5_10' ? 'selected' : '' }}>Expérience entre 5 ans et 10 ans</option>
                                <option value="plus_10" {{ $user->niveau_experience_global == 'plus_10' ? 'selected' : '' }}>Expérience > 10 ans</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

           <!-- Formations -->
<div class="bg-white rounded-xl shadow-lg overflow-hidden animate-fade-in-up delay-3" id="formations-section">
    <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 px-6 py-5">
        <h2 class="text-xl font-bold text-white flex items-center">
            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
            </svg>
            Formations
        </h2>
        <p class="text-indigo-100 text-sm mt-1">Ajoutez vos diplômes et formations</p>
    </div>
    <div class="p-6">
        <div id="formations-container" class="space-y-6">
            @forelse($formations as $index => $formation)
                <div class="formation-item border border-gray-200 rounded-xl overflow-hidden hover:shadow-md transition-shadow">
                    <div class="bg-gray-50 px-4 py-2 border-b border-gray-200 flex justify-between items-center">
                        <span class="text-sm font-medium text-gray-600">Formation #{{ $loop->iteration }}</span>
                        <button type="button" class="btn-remove text-red-500 hover:text-red-700 text-sm flex items-center gap-1" onclick="this.closest('.formation-item').remove()">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Supprimer
                        </button>
                    </div>
                    <div class="p-4 space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Date de début -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Date de début</label>
                                <div class="flex gap-2">
                                    <div class="relative flex-1 input-icon border border-gray-200 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <select name="formations[{{ $index }}][debut_mois]" class="pl-10 pr-8 py-2 w-full border-0 focus:ring-0 focus:outline-none appearance-none bg-white">
                                            @for($m=1; $m<=12; $m++)
                                                <option value="{{ $m }}" {{ $formation->debut_mois == $m ? 'selected' : '' }}>{{ str_pad($m,2,'0',STR_PAD_LEFT) }}</option>
                                            @endfor
                                        </select>
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="relative flex-1 input-icon border border-gray-200 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <select name="formations[{{ $index }}][debut_annee]" class="pl-10 pr-8 py-2 w-full border-0 focus:ring-0 focus:outline-none appearance-none bg-white">
                                            @for($y=date('Y'); $y>=1950; $y--)
                                                <option value="{{ $y }}" {{ $formation->debut_annee == $y ? 'selected' : '' }}>{{ $y }}</option>
                                            @endfor
                                        </select>
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Date de fin -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Date de fin</label>
                                <div class="flex gap-2 items-center">
                                    <div class="relative flex-1 input-icon border border-gray-200 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <select name="formations[{{ $index }}][fin_mois]" class="pl-10 pr-8 py-2 w-full border-0 focus:ring-0 focus:outline-none appearance-none bg-white">
                                            <option value="">-</option>
                                            @for($m=1; $m<=12; $m++)
                                                <option value="{{ $m }}" {{ $formation->fin_mois == $m ? 'selected' : '' }}>{{ str_pad($m,2,'0',STR_PAD_LEFT) }}</option>
                                            @endfor
                                        </select>
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="relative flex-1 input-icon border border-gray-200 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <select name="formations[{{ $index }}][fin_annee]" class="pl-10 pr-8 py-2 w-full border-0 focus:ring-0 focus:outline-none appearance-none bg-white">
                                            <option value="">-</option>
                                            @for($y=date('Y'); $y>=1950; $y--)
                                                <option value="{{ $y }}" {{ $formation->fin_annee == $y ? 'selected' : '' }}>{{ $y }}</option>
                                            @endfor
                                        </select>
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </div>
                                    </div>
                                    <label class="inline-flex items-center text-sm ml-2 whitespace-nowrap">
                                        <input type="checkbox" name="formations[{{ $index }}][encours]" value="1" {{ $formation->encours ? 'checked' : '' }} class="mr-1 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"> à aujourd'hui
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Intitulé -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Intitulé de la formation</label>
                                <div class="relative input-icon border border-gray-200 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                                        </svg>
                                    </div>
                                    <input type="text" name="formations[{{ $index }}][titre]" value="{{ $formation->titre }}" 
                                           class="pl-10 pr-4 py-2 w-full border-0 focus:ring-0 focus:outline-none"
                                           placeholder="Ex: Master en Informatique">
                                </div>
                            </div>
                            <!-- Établissement -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">École / Établissement</label>
                                <div class="relative input-icon border border-gray-200 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                    </div>
                                    <input type="text" name="formations[{{ $index }}][etablissement]" value="{{ $formation->etablissement }}" 
                                           class="pl-10 pr-4 py-2 w-full border-0 focus:ring-0 focus:outline-none"
                                           placeholder="Nom de l'école ou université">
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Description (optionnel)</label>
                            <div class="relative input-icon border border-gray-200 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500">
                                <div class="absolute top-3 left-3 flex items-start pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                                    </svg>
                                </div>
                                <textarea name="formations[{{ $index }}][description]" rows="3" 
                                          class="pl-10 pr-4 py-2 w-full border-0 focus:ring-0 focus:outline-none"
                                          placeholder="Décrivez brièvement cette formation...">{{ $formation->description }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-8 text-gray-500 bg-gray-50 rounded-lg border border-gray-200">
                    <svg class="w-12 h-12 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                    </svg>
                    <p>Aucune formation renseignée.</p>
                </div>
            @endforelse
        </div>
        <button type="button" class="mt-6 w-full sm:w-auto bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 transition flex items-center justify-center gap-2 border border-gray-300" onclick="addFormation()">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Ajouter une formation
        </button>
    </div>
</div>

            <!-- Expériences professionnelles -->
<div class="bg-white rounded-xl shadow-lg overflow-hidden animate-fade-in-up delay-4" id="experiences-section">
    <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 px-6 py-5">
        <h2 class="text-xl font-bold text-white flex items-center">
            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
            Expériences professionnelles
        </h2>
        <p class="text-indigo-100 text-sm mt-1">Ajoutez vos postes et missions</p>
    </div>
    <div class="p-6">
        <div id="experiences-container" class="space-y-6">
            @forelse($experiences as $index => $exp)
                <div class="experience-item border border-gray-200 rounded-xl overflow-hidden hover:shadow-md transition-shadow">
                    <div class="bg-gray-50 px-4 py-2 border-b border-gray-200 flex justify-between items-center">
                        <span class="text-sm font-medium text-gray-600">Expérience #{{ $loop->iteration }}</span>
                        <button type="button" class="btn-remove text-red-500 hover:text-red-700 text-sm flex items-center gap-1" onclick="this.closest('.experience-item').remove()">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Supprimer
                        </button>
                    </div>
                    <div class="p-4 space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Date de début -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Date de début</label>
                                <div class="flex gap-2">
                                    <div class="relative flex-1 input-icon border border-gray-200 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <select name="experiences[{{ $index }}][debut_mois]" class="pl-10 pr-8 py-2 w-full border-0 focus:ring-0 focus:outline-none appearance-none bg-white">
                                            @for($m=1; $m<=12; $m++)
                                                <option value="{{ $m }}" {{ $exp->debut_mois == $m ? 'selected' : '' }}>{{ str_pad($m,2,'0',STR_PAD_LEFT) }}</option>
                                            @endfor
                                        </select>
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="relative flex-1 input-icon border border-gray-200 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <select name="experiences[{{ $index }}][debut_annee]" class="pl-10 pr-8 py-2 w-full border-0 focus:ring-0 focus:outline-none appearance-none bg-white">
                                            @for($y=date('Y'); $y>=1950; $y--)
                                                <option value="{{ $y }}" {{ $exp->debut_annee == $y ? 'selected' : '' }}>{{ $y }}</option>
                                            @endfor
                                        </select>
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Date de fin -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Date de fin</label>
                                <div class="flex gap-2 items-center">
                                    <div class="relative flex-1 input-icon border border-gray-200 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <select name="experiences[{{ $index }}][fin_mois]" class="pl-10 pr-8 py-2 w-full border-0 focus:ring-0 focus:outline-none appearance-none bg-white">
                                            <option value="">-</option>
                                            @for($m=1; $m<=12; $m++)
                                                <option value="{{ $m }}" {{ $exp->fin_mois == $m ? 'selected' : '' }}>{{ str_pad($m,2,'0',STR_PAD_LEFT) }}</option>
                                            @endfor
                                        </select>
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="relative flex-1 input-icon border border-gray-200 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <select name="experiences[{{ $index }}][fin_annee]" class="pl-10 pr-8 py-2 w-full border-0 focus:ring-0 focus:outline-none appearance-none bg-white">
                                            <option value="">-</option>
                                            @for($y=date('Y'); $y>=1950; $y--)
                                                <option value="{{ $y }}" {{ $exp->fin_annee == $y ? 'selected' : '' }}>{{ $y }}</option>
                                            @endfor
                                        </select>
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </div>
                                    </div>
                                    <label class="inline-flex items-center text-sm ml-2 whitespace-nowrap">
                                        <input type="checkbox" name="experiences[{{ $index }}][encours]" value="1" {{ $exp->encours ? 'checked' : '' }} class="mr-1 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"> à aujourd'hui
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Intitulé du poste -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Intitulé du poste</label>
                                <div class="relative input-icon border border-gray-200 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                    <input type="text" name="experiences[{{ $index }}][poste]" value="{{ $exp->poste }}" 
                                           class="pl-10 pr-4 py-2 w-full border-0 focus:ring-0 focus:outline-none"
                                           placeholder="Ex: Développeur Full Stack">
                                </div>
                            </div>
                            <!-- Entreprise -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Entreprise</label>
                                <div class="relative input-icon border border-gray-200 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                    </div>
                                    <input type="text" name="experiences[{{ $index }}][entreprise]" value="{{ $exp->entreprise }}" 
                                           class="pl-10 pr-4 py-2 w-full border-0 focus:ring-0 focus:outline-none"
                                           placeholder="Nom de l'entreprise">
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Description (optionnel)</label>
                            <div class="relative input-icon border border-gray-200 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500">
                                <div class="absolute top-3 left-3 flex items-start pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                                    </svg>
                                </div>
                                <textarea name="experiences[{{ $index }}][description]" rows="3" 
                                          class="pl-10 pr-4 py-2 w-full border-0 focus:ring-0 focus:outline-none"
                                          placeholder="Décrivez vos missions et responsabilités...">{{ $exp->description }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-8 text-gray-500 bg-gray-50 rounded-lg border border-gray-200">
                    <svg class="w-12 h-12 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <p>Aucune expérience renseignée.</p>
                </div>
            @endforelse
        </div>
        <button type="button" class="mt-6 w-full sm:w-auto bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 transition flex items-center justify-center gap-2 border border-gray-300" onclick="addExperience()">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Ajouter une expérience
        </button>
    </div>
</div>

            <!-- Compétences -->
<div class="bg-white rounded-xl shadow-lg overflow-hidden animate-fade-in-up delay-5">
    <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 px-6 py-5">
        <h2 class="text-xl font-bold text-white flex items-center">
            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            Mes compétences
        </h2>
        <p class="text-indigo-100 text-sm mt-1">Listez vos compétences techniques et humaines</p>
    </div>
    <div class="p-6">
        <div class="relative input-icon border border-gray-200 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <input type="text" name="competences" value="{{ $competences->pluck('nom')->implode(', ') }}" 
                   class="pl-10 pr-4 py-2 w-full border-0 focus:ring-0 focus:outline-none"
                   placeholder="Ex: PHP, gestion de projet, travail en équipe">
        </div>
    </div>
</div>

            <!-- Langues parlées -->
<div class="bg-white rounded-xl shadow-lg overflow-hidden animate-fade-in-up delay-6">
    <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 px-6 py-5">
        <h2 class="text-xl font-bold text-white flex items-center">
            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129" />
            </svg>
            Langues parlées
        </h2>
        <p class="text-indigo-100 text-sm mt-1">Indiquez les langues que vous maîtrisez</p>
    </div>
    <div class="p-6">
        <div id="langues-container" class="space-y-4">
            @forelse($languesUser as $index => $lu)
                <div class="langue-item flex flex-col sm:flex-row gap-4 items-start sm:items-center p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <div class="relative flex-1 input-icon border border-gray-200 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500 bg-white">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129" />
                            </svg>
                        </div>
                        <select name="langues[{{ $index }}][langue_id]" class="pl-10 pr-8 py-2 w-full border-0 focus:ring-0 focus:outline-none appearance-none bg-white">
                            <option value="">Choisissez</option>
                            @foreach($langues as $langue)
                                <option value="{{ $langue->id }}" {{ $lu->id == $langue->id ? 'selected' : '' }}>{{ $langue->nom }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                    <div class="relative w-48 input-icon border border-gray-200 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500 bg-white">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <select name="langues[{{ $index }}][niveau]" class="pl-10 pr-8 py-2 w-full border-0 focus:ring-0 focus:outline-none appearance-none bg-white">
                            <option value="debutant" {{ $lu->pivot->niveau == 'debutant' ? 'selected' : '' }}>Débutant</option>
                            <option value="intermediaire" {{ $lu->pivot->niveau == 'intermediaire' ? 'selected' : '' }}>Intermédiaire</option>
                            <option value="courant" {{ $lu->pivot->niveau == 'courant' ? 'selected' : '' }}>Courant</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                    <button type="button" class="btn-remove text-red-600 hover:text-red-800 p-2" onclick="this.closest('.langue-item').remove()">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            @empty
                <div class="text-center py-8 text-gray-500 bg-gray-50 rounded-lg border border-gray-200">
                    <svg class="w-12 h-12 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129" />
                    </svg>
                    <p>Aucune langue sélectionnée.</p>
                </div>
            @endforelse
        </div>
        <button type="button" class="mt-6 w-full sm:w-auto bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 transition flex items-center justify-center gap-2 border border-gray-300" onclick="addLangue()">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Ajouter une langue
        </button>
    </div>
</div>

            <!-- Offres d'emploi pour moi -->
            @if(isset($offresSuggestions) && $offresSuggestions->count() > 0)
            <div class="bg-white rounded-xl shadow-lg overflow-hidden animate-fade-in-up delay-7">
                <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 px-6 py-5">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        Offres d'emploi pour moi
                    </h2>
                    <p class="text-indigo-100 text-sm mt-1">Des offres qui pourraient vous intéresser</p>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($offresSuggestions as $offre)
                            <div class="offer-card p-4 rounded-lg border border-gray-200 hover:shadow-md transition">
                                <h3 class="font-semibold text-lg text-gray-800">{{ $offre->titre }}</h3>
                                <p class="text-sm text-gray-600">{{ $offre->entreprise ?? $offre->direction->nom ?? 'N.C' }}</p>
                                <div class="mt-2 text-xs text-gray-500 space-y-1">
                                    <p><span class="font-medium">Référence :</span> {{ $offre->reference ?? 'N.C' }}</p>
                                    <p><span class="font-medium">Date de création :</span> {{ $offre->date_publication ? $offre->date_publication->format('d.m.Y') : '17.01.2025' }}</p>
                                </div>
                                <p class="text-sm mt-2 text-gray-700">{{ Str::limit($offre->description, 80) }}</p>
                                <p class="text-xs text-gray-500 mt-1">
                                    <span class="font-medium">Région de :</span> {{ $offre->region ?? $offre->direction->region ?? 'Casablanca' }}
                                </p>
                                <div class="mt-3">
                                    <a href="{{ route('candidat.offres.show', $offre) }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium flex items-center gap-1">
                                        Voir la détail
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4 text-right">
                        <a href="{{ route('candidat.offres.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium inline-flex items-center gap-1">
                            Voir plus d'informations sur l'emploi
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            @endif

            <!-- Bouton Enregistrer -->
            <div class="flex justify-end animate-fade-in-up delay-8">
                <button type="submit" class="bg-gradient-to-r from-indigo-600 to-indigo-700 text-white px-8 py-3 rounded-lg hover:from-indigo-700 hover:to-indigo-800 transition-all shadow-md hover:shadow-lg flex items-center gap-2">
                    <i class="fas fa-save"></i> Enregistrer et continuer
                </button>
            </div>
        </form>
    </div>

    <!-- Scripts JavaScript pour ajouter dynamiquement des blocs (inchangés) -->
    <script>
        let formationIndex = {{ count($formations) }};
        let experienceIndex = {{ count($experiences) }};
        let langueIndex = {{ count($languesUser) }};

        function addFormation() {
    const container = document.getElementById('formations-container');
    const template = `
        <div class="formation-item border border-gray-200 rounded-xl overflow-hidden hover:shadow-md transition-shadow">
            <div class="bg-gray-50 px-4 py-2 border-b border-gray-200 flex justify-between items-center">
                <span class="text-sm font-medium text-gray-600">Formation #${formationIndex + 1}</span>
                <button type="button" class="btn-remove text-red-500 hover:text-red-700 text-sm flex items-center gap-1" onclick="this.closest('.formation-item').remove()">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Supprimer
                </button>
            </div>
            <div class="p-4 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Date de début</label>
                        <div class="flex gap-2">
                            <div class="relative flex-1 input-icon border border-gray-200 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <select name="formations[${formationIndex}][debut_mois]" class="pl-10 pr-8 py-2 w-full border-0 focus:ring-0 focus:outline-none appearance-none bg-white">
                                    ${monthOptions()}
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                            <div class="relative flex-1 input-icon border border-gray-200 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <select name="formations[${formationIndex}][debut_annee]" class="pl-10 pr-8 py-2 w-full border-0 focus:ring-0 focus:outline-none appearance-none bg-white">
                                    ${yearOptions()}
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Date de fin</label>
                        <div class="flex gap-2 items-center">
                            <div class="relative flex-1 input-icon border border-gray-200 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <select name="formations[${formationIndex}][fin_mois]" class="pl-10 pr-8 py-2 w-full border-0 focus:ring-0 focus:outline-none appearance-none bg-white">
                                    <option value="">-</option>
                                    ${monthOptions()}
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                            <div class="relative flex-1 input-icon border border-gray-200 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <select name="formations[${formationIndex}][fin_annee]" class="pl-10 pr-8 py-2 w-full border-0 focus:ring-0 focus:outline-none appearance-none bg-white">
                                    <option value="">-</option>
                                    ${yearOptions()}
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                            <label class="inline-flex items-center text-sm ml-2 whitespace-nowrap">
                                <input type="checkbox" name="formations[${formationIndex}][encours]" value="1" class="mr-1 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"> à aujourd'hui
                            </label>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Intitulé de la formation</label>
                        <div class="relative input-icon border border-gray-200 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                                </svg>
                            </div>
                            <input type="text" name="formations[${formationIndex}][titre]" class="pl-10 pr-4 py-2 w-full border-0 focus:ring-0 focus:outline-none" placeholder="Ex: Master en Informatique">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">École / Établissement</label>
                        <div class="relative input-icon border border-gray-200 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                            <input type="text" name="formations[${formationIndex}][etablissement]" class="pl-10 pr-4 py-2 w-full border-0 focus:ring-0 focus:outline-none" placeholder="Nom de l'école ou université">
                        </div>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description (optionnel)</label>
                    <div class="relative input-icon border border-gray-200 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500">
                        <div class="absolute top-3 left-3 flex items-start pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                            </svg>
                        </div>
                        <textarea name="formations[${formationIndex}][description]" rows="3" class="pl-10 pr-4 py-2 w-full border-0 focus:ring-0 focus:outline-none" placeholder="Décrivez brièvement cette formation..."></textarea>
                    </div>
                </div>
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', template);
    formationIndex++;
}

        function addExperience() {
    const container = document.getElementById('experiences-container');
    const template = `
        <div class="experience-item border border-gray-200 rounded-xl overflow-hidden hover:shadow-md transition-shadow">
            <div class="bg-gray-50 px-4 py-2 border-b border-gray-200 flex justify-between items-center">
                <span class="text-sm font-medium text-gray-600">Expérience #${experienceIndex + 1}</span>
                <button type="button" class="btn-remove text-red-500 hover:text-red-700 text-sm flex items-center gap-1" onclick="this.closest('.experience-item').remove()">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Supprimer
                </button>
            </div>
            <div class="p-4 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Date de début</label>
                        <div class="flex gap-2">
                            <div class="relative flex-1 input-icon border border-gray-200 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <select name="experiences[${experienceIndex}][debut_mois]" class="pl-10 pr-8 py-2 w-full border-0 focus:ring-0 focus:outline-none appearance-none bg-white">
                                    ${monthOptions()}
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                            <div class="relative flex-1 input-icon border border-gray-200 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <select name="experiences[${experienceIndex}][debut_annee]" class="pl-10 pr-8 py-2 w-full border-0 focus:ring-0 focus:outline-none appearance-none bg-white">
                                    ${yearOptions()}
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Date de fin</label>
                        <div class="flex gap-2 items-center">
                            <div class="relative flex-1 input-icon border border-gray-200 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <select name="experiences[${experienceIndex}][fin_mois]" class="pl-10 pr-8 py-2 w-full border-0 focus:ring-0 focus:outline-none appearance-none bg-white">
                                    <option value="">-</option>
                                    ${monthOptions()}
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                            <div class="relative flex-1 input-icon border border-gray-200 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <select name="experiences[${experienceIndex}][fin_annee]" class="pl-10 pr-8 py-2 w-full border-0 focus:ring-0 focus:outline-none appearance-none bg-white">
                                    <option value="">-</option>
                                    ${yearOptions()}
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                            <label class="inline-flex items-center text-sm ml-2 whitespace-nowrap">
                                <input type="checkbox" name="experiences[${experienceIndex}][encours]" value="1" class="mr-1 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"> à aujourd'hui
                            </label>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Intitulé du poste</label>
                        <div class="relative input-icon border border-gray-200 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <input type="text" name="experiences[${experienceIndex}][poste]" class="pl-10 pr-4 py-2 w-full border-0 focus:ring-0 focus:outline-none" placeholder="Ex: Développeur Full Stack">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Entreprise</label>
                        <div class="relative input-icon border border-gray-200 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                            <input type="text" name="experiences[${experienceIndex}][entreprise]" class="pl-10 pr-4 py-2 w-full border-0 focus:ring-0 focus:outline-none" placeholder="Nom de l'entreprise">
                        </div>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description (optionnel)</label>
                    <div class="relative input-icon border border-gray-200 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500">
                        <div class="absolute top-3 left-3 flex items-start pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                            </svg>
                        </div>
                        <textarea name="experiences[${experienceIndex}][description]" rows="3" class="pl-10 pr-4 py-2 w-full border-0 focus:ring-0 focus:outline-none" placeholder="Décrivez vos missions et responsabilités..."></textarea>
                    </div>
                </div>
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', template);
    experienceIndex++;
}

function addLangue() {
    const container = document.getElementById('langues-container');
    const template = `
        <div class="langue-item flex flex-col sm:flex-row gap-4 items-start sm:items-center p-4 bg-gray-50 rounded-lg border border-gray-200">
            <div class="relative flex-1 input-icon border border-gray-200 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500 bg-white">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129" />
                    </svg>
                </div>
                <select name="langues[${langueIndex}][langue_id]" class="pl-10 pr-8 py-2 w-full border-0 focus:ring-0 focus:outline-none appearance-none bg-white">
                    <option value="">Choisissez</option>
                    @foreach($langues as $langue)
                        <option value="{{ $langue->id }}">{{ $langue->nom }}</option>
                    @endforeach
                </select>
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>
            </div>
            <div class="relative w-48 input-icon border border-gray-200 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500 bg-white">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <select name="langues[${langueIndex}][niveau]" class="pl-10 pr-8 py-2 w-full border-0 focus:ring-0 focus:outline-none appearance-none bg-white">
                    <option value="debutant">Débutant</option>
                    <option value="intermediaire">Intermédiaire</option>
                    <option value="courant">Courant</option>
                </select>
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>
            </div>
            <button type="button" class="btn-remove text-red-600 hover:text-red-800 p-2" onclick="this.closest('.langue-item').remove()">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', template);
    langueIndex++;
}

        function monthOptions() {
            let options = '';
            for (let m = 1; m <= 12; m++) {
                let val = m.toString().padStart(2, '0');
                options += `<option value="${m}">${val}</option>`;
            }
            return options;
        }

        function yearOptions() {
            let options = '';
            let currentYear = new Date().getFullYear();
            for (let y = currentYear; y >= 1950; y--) {
                options += `<option value="${y}">${y}</option>`;
            }
            return options;
        }
    </script>
@endsection