@extends('layouts.candidat')

@section('header', $offre->titre)

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

    .info-item {
        transition: background-color 0.2s ease;
    }
    .info-item:hover {
        background-color: #eef2ff;
    }

    /* Formulaire */
    .form-group {
        margin-bottom: 1.25rem;
    }
    .form-label {
        display: block;
        font-size: 0.875rem;
        font-weight: 500;
        color: #374151;
        margin-bottom: 0.5rem;
    }
    .form-control {
        width: 100%;
        border: 1px solid #e5e7eb;
        border-radius: 0.75rem;
        padding: 0.75rem 1rem;
        transition: all 0.2s;
        background-color: white;
    }
    .form-control:focus {
        outline: none;
        border-color: #4f46e5;
        box-shadow: 0 0 0 3px #e0e7ff;
    }
    .form-control {
        background-color: #f9fafb;
    }

    /* Champ de fichier personnalisé */
    .custom-file-input {
        position: relative;
        width: 100%;
    }
    .custom-file-input input[type="file"] {
        position: absolute;
        width: 1px;
        height: 1px;
        padding: 0;
        margin: -1px;
        overflow: hidden;
        clip: rect(0,0,0,0);
        border: 0;
    }
    .custom-file-label {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        border: 1px solid #e5e7eb;
        border-radius: 0.75rem;
        padding: 0.75rem 1rem;
        background-color: white;
        cursor: pointer;
        transition: all 0.2s;
    }
    .custom-file-label:hover {
        border-color: #4f46e5;
    }
    .custom-file-label span:first-child {
        color: #6b7280;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        max-width: 70%;
    }
    .custom-file-label span:last-child {
        background-color: #f3f4f6;
        padding: 0.25rem 0.75rem;
        border-radius: 0.5rem;
        font-size: 0.75rem;
        color: #374151;
    }
</style>
@endpush

@section('content')
<div class="max-w-4xl mx-auto animate-fade-in-up delay-1">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <!-- En-tête -->
        <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 px-6 py-5">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h2 class="text-xl font-bold text-white">{{ $offre->titre }}</h2>
                    <p class="text-indigo-100 text-sm mt-1">{{ $offre->direction->nom }}</p>
                </div>
                <div class="mt-2 md:mt-0">
                    <span class="px-4 py-2 text-sm font-semibold rounded-full shadow-lg
                        @if($offre->statut == 'ouverte') bg-green-500 text-white
                        @elseif($offre->statut == 'fermée') bg-gray-600 text-white
                        @else bg-gray-400 text-white @endif">
                        {{ ucfirst($offre->statut) }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Corps des informations -->
        <div class="p-6">
            <dl class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Direction -->
                <div class="info-item p-4 rounded-lg border border-gray-100">
                    <dt class="text-sm font-medium text-gray-500 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                        Direction
                    </dt>
                    <dd class="mt-1 text-base text-gray-900 font-medium">{{ $offre->direction->nom }}</dd>
                </div>

                <!-- Catégorie -->
                <div class="info-item p-4 rounded-lg border border-gray-100">
                    <dt class="text-sm font-medium text-gray-500 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l5 5a2 2 0 01.586 1.414V19a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z" /></svg>
                        Catégorie
                    </dt>
                    <dd class="mt-1 text-base text-gray-900">{{ $offre->category->nom }}</dd>
                </div>

                <!-- Type de contrat -->
                <div class="info-item p-4 rounded-lg border border-gray-100">
                    <dt class="text-sm font-medium text-gray-500 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                        Type de contrat
                    </dt>
                    <dd class="mt-1 text-base text-gray-900">{{ $offre->typeContrat->nom }}</dd>
                </div>

                <!-- Niveau d'expérience -->
                <div class="info-item p-4 rounded-lg border border-gray-100">
                    <dt class="text-sm font-medium text-gray-500 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                        Niveau d'expérience
                    </dt>
                    <dd class="mt-1 text-base text-gray-900">{{ $offre->niveauExperience->nom }}</dd>
                </div>

                <!-- Niveau d'études -->
                <div class="info-item p-4 rounded-lg border border-gray-100">
                    <dt class="text-sm font-medium text-gray-500 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" /></svg>
                        Niveau d'études
                    </dt>
                    <dd class="mt-1 text-base text-gray-900">{{ $offre->niveauEtude->nom ?? 'Non précisé' }}</dd>
                </div>

                <!-- Date de publication -->
                <div class="info-item p-4 rounded-lg border border-gray-100">
                    <dt class="text-sm font-medium text-gray-500 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        Date de publication
                    </dt>
                    <dd class="mt-1 text-base text-gray-900">{{ $offre->date_publication->format('d/m/Y') }}</dd>
                </div>

                <!-- Date limite -->
                <div class="info-item p-4 rounded-lg border border-gray-100">
                    <dt class="text-sm font-medium text-gray-500 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        Date limite
                    </dt>
                    <dd class="mt-1 text-base text-gray-900">{{ $offre->date_limite ? $offre->date_limite->format('d/m/Y') : 'Non définie' }}</dd>
                </div>

                <!-- Ville -->
                <div class="info-item p-4 rounded-lg border border-gray-100">
                    <dt class="text-sm font-medium text-gray-500 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        Ville
                    </dt>
                    <dd class="mt-1 text-base text-gray-900">{{ $offre->ville->nom ?? 'Non spécifiée' }}</dd>
                </div>

                <!-- Salaire -->
                <div class="info-item p-4 rounded-lg border border-gray-100">
                    <dt class="text-sm font-medium text-gray-500 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        Salaire
                    </dt>
                    <dd class="mt-1 text-base text-gray-900">
                        @if($offre->salaire_min && $offre->salaire_max)
                            {{ number_format($offre->salaire_min, 0, ',', ' ') }} - {{ number_format($offre->salaire_max, 0, ',', ' ') }} MAD
                        @elseif($offre->salaire_min)
                            À partir de {{ number_format($offre->salaire_min, 0, ',', ' ') }} MAD
                        @elseif($offre->salaire_max)
                            Jusqu'à {{ number_format($offre->salaire_max, 0, ',', ' ') }} MAD
                        @else
                            Non spécifié
                        @endif
                    </dd>
                </div>

                <!-- Description -->
                <div class="md:col-span-2">
                    <div class="info-item p-4 rounded-lg border border-gray-100">
                        <dt class="text-sm font-medium text-gray-500 flex items-center mb-2">
                            <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" /></svg>
                            Description
                        </dt>
                        <dd class="text-base text-gray-900 whitespace-pre-line">{{ $offre->description }}</dd>
                    </div>
                </div>

                <!-- Missions -->
                @if($offre->missions)
                <div class="md:col-span-2">
                    <div class="info-item p-4 rounded-lg border border-gray-100">
                        <dt class="text-sm font-medium text-gray-500 flex items-center mb-2">
                            <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" /></svg>
                            Missions
                        </dt>
                        <dd class="text-base text-gray-900 whitespace-pre-line">{{ $offre->missions }}</dd>
                    </div>
                </div>
                @endif

                <!-- Profil recherché -->
                @if($offre->profil)
                <div class="md:col-span-2">
                    <div class="info-item p-4 rounded-lg border border-gray-100">
                        <dt class="text-sm font-medium text-gray-500 flex items-center mb-2">
                            <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" /></svg>
                            Profil recherché
                        </dt>
                        <dd class="text-base text-gray-900 whitespace-pre-line">{{ $offre->profil }}</dd>
                    </div>
                </div>
                @endif
            </dl>

            <!-- Section Entreprise -->
            <div class="mt-6 p-4 rounded-lg border border-gray-100 bg-gray-50">
                <div class="flex items-center space-x-3 mb-3">
                    <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center text-indigo-700 font-bold text-lg">
                        {{ substr($offre->direction->nom, 0, 2) }}
                    </div>
                    <div>
                        <p class="font-medium text-gray-800">{{ $offre->direction->nom }}</p>
                        <p class="text-xs text-gray-500">{{ $offre->direction->secteur_activite ?? 'Secteur non spécifié' }}</p>
                    </div>
                </div>
                @if($offre->direction->description)
                    <p class="text-sm text-gray-600">{{ $offre->direction->description }}</p>
                @else
                    <p class="text-sm text-gray-400 italic">Aucune description fournie.</p>
                @endif
                @if($offre->direction->site_web)
                    <a href="{{ $offre->direction->site_web }}" target="_blank" class="inline-flex items-center mt-3 text-indigo-600 hover:text-indigo-800 text-sm">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
                        Site web
                    </a>
                @endif
            </div>

            <!-- Bouton Postuler avec Alpine.js -->
            <div class="mt-8 text-center" x-data="{ open: false }">
                @if($dejaPostule)
                    <div class="inline-flex items-center gap-2 bg-green-50 text-green-700 px-6 py-3 rounded-full">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        Vous avez déjà postulé le {{ $candidature->created_at->format('d/m/Y') }}
                    </div>
                    <a href="{{ route('candidat.candidatures.show', $candidature) }}" class="block mt-2 text-indigo-600 hover:underline">
                        Voir ma candidature
                    </a>
                @else
                    <button @click="open = true" class="px-6 py-2.5 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white rounded-lg hover:from-indigo-700 hover:to-indigo-800 transition-all shadow-md hover:shadow-lg flex items-center gap-2 mx-auto">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                        Postuler maintenant
                    </button>
                @endif

                <!-- Modal Alpine.js -->
                <div x-show="open" x-transition.opacity.duration.300ms class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm" style="display: none;" @click.away="open = false">
                    <div class="bg-white rounded-2xl shadow-2xl p-6 md:p-8 w-full max-w-lg transform transition-all" x-show="open" x-transition:enter="transform transition duration-300 ease-out" x-transition:enter-start="scale-95 opacity-0" x-transition:enter-end="scale-100 opacity-100" x-transition:leave="transform transition duration-200 ease-in" x-transition:leave-start="scale-100 opacity-100" x-transition:leave-end="scale-95 opacity-0">
                        <div class="flex justify-between items-center border-b border-gray-200 pb-4 mb-4">
                            <h2 class="text-2xl font-bold text-gray-800">Postuler à l'offre</h2>
                            <button @click="open = false" class="text-gray-400 hover:text-gray-600 transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>
                        </div>
                         @if ($errors->any())
                            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                                <ul>
                                   @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                  @endforeach
                               </ul>
                         </div>
                      @endif
                        <form action="{{ route('candidat.offres.postuler', $offre) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="space-y-6">
        <!-- Nom complet (lecture seule) -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nom complet</label>
            <input type="text" name="nom_complet" value="{{ Auth::user()->name }} {{ Auth::user()->prenom }}"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-500 cursor-not-allowed">
        </div>

        <!-- Niveau d'étude -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Niveau d'étude</label>
            <select name="niveau_etude"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                @foreach($niveauxEtudes as $ne)
                    <option value="{{ $ne->id }}" {{ Auth::user()->niveau_etude_id == $ne->id ? 'selected' : '' }}>
                        {{ $ne->nom }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Niveau d'expérience -->
<div>
    <label class="block text-sm font-medium text-gray-700 mb-1">Niveau d'expérience</label>
    <select name="niveau_experience" required
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
        <option value="etudiant">Étudiant, jeune diplômé</option>
        <option value="debutant_moins_2">Débutant &lt; 2 ans</option>
        <option value="entre_2_5">Expérience entre 2 ans et 5 ans</option>
        <option value="entre_5_10">Expérience entre 5 ans et 10 ans</option>
        <option value="plus_10">Expérience &gt; 10 ans</option>
    </select>
</div>
<!-- Adresse -->
<div>
    <label class="block text-sm font-medium text-gray-700 mb-1">Adresse</label>
    <input type="text" name="adresse" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500" placeholder="Ville, quartier..." required>
</div>

<!-- Formation -->
<div>
    <label class="block text-sm font-medium text-gray-700 mb-1">Formation</label>
    <input type="text" name="formation" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500" placeholder="Dernier diplôme obtenu" required>
</div>


        <!-- CV (fichier) -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">CV (PDF, DOC, DOCX)</label>
            <div class="relative">
                <input type="file" name="cv" id="cvFile" accept=".pdf,.doc,.docx" required
                       class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                <div class="w-full flex items-center justify-between px-4 py-2 border border-gray-300 rounded-lg bg-white hover:bg-gray-50 transition">
                    <span id="cvFileName" class="text-gray-500">Aucun fichier sélectionné</span>
                    <span class="px-3 py-1 text-sm font-medium text-indigo-600 bg-indigo-50 rounded-full">Parcourir</span>
                </div>
            </div>
            <p class="text-xs text-gray-400 mt-1">Taille max : 2 Mo</p>
        </div>
    </div>

    <div class="flex justify-end gap-3 mt-8">
        <button type="button" @click="open = false"
                class="px-6 py-2 border border-gray-300 rounded-full text-gray-700 hover:bg-gray-50 transition-colors">
            Annuler
        </button>
        <button type="submit"
                class="px-6 py-2 bg-indigo-600 text-white rounded-full hover:bg-indigo-700 transition-colors shadow-md focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
            Envoyer ma candidature
        </button>
    </div>
</form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Gestion du nom du fichier sélectionné
    const fileInput = document.getElementById('cvFile');
    const fileNameSpan = document.getElementById('cvFileName');
    if (fileInput) {
        fileInput.addEventListener('change', function() {
            if (this.files && this.files.length > 0) {
                fileNameSpan.textContent = this.files[0].name;
            } else {
                fileNameSpan.textContent = 'Choisir un fichier';
            }
        });
    }
</script>
@endsection