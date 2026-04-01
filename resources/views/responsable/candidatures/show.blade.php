@extends('layouts.responsable')

@section('header', 'Détail de la candidature')

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
        background-color: #fef2f2;
    }

    .action-button {
        transition: all 0.2s ease;
    }
    .action-button:hover {
        transform: scale(1.05);
    }

    /* Styles pour les radios personnalisés */
    .radio-group {
        display: flex;
        gap: 1rem;
    }
    .radio-label {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 2rem;
        background-color: #f3f4f6;
        color: #374151;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
    }
    .radio-label input {
        display: none;
    }
    .radio-label.active {
        background-color: #970d0d;
        color: white;
        box-shadow: 0 2px 8px rgba(151, 13, 13, 0.3);
    }
    .radio-label.active .fa {
        color: white;
    }
    .radio-label .fa {
        font-size: 1rem;
        color: #6b7280;
    }
    .radio-label.active .fa {
        color: white;
    }
</style>
@endpush

@section('content')
<div class="max-w-4xl mx-auto animate-fade-in-up delay-1">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <!-- En-tête avec dégradé et statut -->
        <div class="bg-gradient-to-r from-[#970d0d] to-[#7a0a0a] px-6 py-5">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h2 class="text-xl font-bold text-white">{{ $candidature->candidat->name }} {{ $candidature->candidat->prenom }}</h2>
                    <p class="text-red-100 text-sm mt-1">Candidature à l'offre : {{ $candidature->offre->titre }}</p>
                </div>
                <div class="mt-2 md:mt-0">
                    <span class="px-4 py-2 text-sm font-semibold rounded-full shadow-lg
                        @if($candidature->statut == 'en_attente') bg-yellow-500 text-white
                        @elseif($candidature->statut == 'en_revision') bg-blue-500 text-white
                        @elseif($candidature->statut == 'acceptee') bg-green-500 text-white
                        @else bg-red-500 text-white @endif">
                        {{ ucfirst(str_replace('_', ' ', $candidature->statut)) }}
                    </span>
                </div>
            </div>
        </div>

        <div class="p-6">
            <!-- Informations candidat et offre -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Candidat -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-user-circle text-[#970d0d] mr-2"></i>
                        Informations du candidat
                    </h3>
                    <div class="space-y-2">
                        <div class="info-item p-3 rounded-lg border border-gray-100">
                            <dt class="text-sm font-medium text-gray-500 flex items-center">
                                <i class="fas fa-envelope w-4 h-4 mr-2 text-[#970d0d]"></i>
                                Email
                            </dt>
                            <dd class="text-base text-gray-900">{{ $candidature->candidat->email }}</dd>
                        </div>
                        <div class="info-item p-3 rounded-lg border border-gray-100">
                            <dt class="text-sm font-medium text-gray-500 flex items-center">
                                <i class="fas fa-phone w-4 h-4 mr-2 text-[#970d0d]"></i>
                                Téléphone
                            </dt>
                            <dd class="text-base text-gray-900">{{ $candidature->candidat->telephone ?? '-' }}</dd>
                        </div>
                        <div class="info-item p-3 rounded-lg border border-gray-100">
                            <dt class="text-sm font-medium text-gray-500 flex items-center">
                                <i class="fas fa-briefcase w-4 h-4 mr-2 text-[#970d0d]"></i>
                                Expérience
                            </dt>
                            <dd class="text-base text-gray-900">{{ $candidature->experience ?? '-' }} ans</dd>
                        </div>
                        <div class="info-item p-3 rounded-lg border border-gray-100">
                            <dt class="text-sm font-medium text-gray-500 flex items-center">
                                <i class="fas fa-graduation-cap w-4 h-4 mr-2 text-[#970d0d]"></i>
                                Formation
                            </dt>
                            <dd class="text-base text-gray-900">{{ $candidature->formation ?? '-' }}</dd>
                        </div>
                        <div class="info-item p-3 rounded-lg border border-gray-100">
                            <dt class="text-sm font-medium text-gray-500 flex items-center">
                                <i class="fas fa-map-marker-alt w-4 h-4 mr-2 text-[#970d0d]"></i>
                                Adresse
                            </dt>
                            <dd class="text-base text-gray-900">{{ $candidature->adresse ?? '-' }}</dd>
                        </div>
                    </div>
                </div>

                <!-- Offre -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-briefcase text-[#970d0d] mr-2"></i>
                        Offre postulée
                    </h3>
                    <div class="space-y-2">
                        <div class="info-item p-3 rounded-lg border border-gray-100">
                            <dt class="text-sm font-medium text-gray-500 flex items-center">
                                <i class="fas fa-tag w-4 h-4 mr-2 text-[#970d0d]"></i>
                                Titre
                            </dt>
                            <dd class="text-base text-gray-900">{{ $candidature->offre->titre }}</dd>
                        </div>
                        <div class="info-item p-3 rounded-lg border border-gray-100">
                            <dt class="text-sm font-medium text-gray-500 flex items-center">
                                <i class="fas fa-building w-4 h-4 mr-2 text-[#970d0d]"></i>
                                Direction
                            </dt>
                            <dd class="text-base text-gray-900">{{ $candidature->offre->direction->nom }}</dd>
                        </div>
                        <div class="info-item p-3 rounded-lg border border-gray-100">
                            <dt class="text-sm font-medium text-gray-500 flex items-center">
                                <i class="fas fa-file-signature w-4 h-4 mr-2 text-[#970d0d]"></i>
                                Type de contrat
                            </dt>
                            <dd class="text-base text-gray-900">{{ $candidature->offre->typeContrat->nom }}</dd>
                        </div>
                        <div class="info-item p-3 rounded-lg border border-gray-100">
                            <dt class="text-sm font-medium text-gray-500 flex items-center">
                                <i class="fas fa-calendar-alt w-4 h-4 mr-2 text-[#970d0d]"></i>
                                Postulée le
                            </dt>
                            <dd class="text-base text-gray-900">{{ $candidature->created_at->format('d/m/Y') }}</dd>
                        </div>
                        @if($candidature->cv_path)
                        <div class="info-item p-3 rounded-lg border border-gray-100">
                            <dt class="text-sm font-medium text-gray-500 flex items-center">
                                <i class="fas fa-file-pdf w-4 h-4 mr-2 text-[#970d0d]"></i>
                                CV
                            </dt>
                            <dd class="text-base text-gray-900">
                                <a href="{{ route('admin.candidatures.cv', $candidature->id) }}" target="_blank" class="text-[#970d0d] hover:underline flex items-center gap-1">
                                    <i class="fas fa-download"></i> Télécharger
                                </a>
                            </dd>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Évaluation existante -->
            @if($candidature->evaluation)
            <div class="mt-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                <div class="flex items-center gap-2">
                    <i class="fas fa-star text-yellow-500"></i>
                    <span class="font-semibold text-gray-700">Votre évaluation</span>
                    <span class="text-sm text-gray-400">({{ $candidature->evaluated_at->format('d/m/Y H:i') }})</span>
                </div>
                <div class="mt-2">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                        @if($candidature->evaluation == 'favorable') bg-green-100 text-green-700
                        @else bg-red-100 text-red-700 @endif">
                        <i class="fas {{ $candidature->evaluation == 'favorable' ? 'fa-thumbs-up' : 'fa-thumbs-down' }} mr-1"></i>
                        {{ ucfirst($candidature->evaluation) }}
                    </span>
                </div>
            </div>
            @endif

            <!-- Formulaire d'avis -->
            @if(!$candidature->evaluation)
            <div class="mt-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                    <i class="fas fa-chalkboard-user text-[#970d0d] mr-2"></i>
                    Donner votre avis
                </h3>
                <form action="{{ route('responsable.candidatures.evaluate', $candidature) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Avis *</label>
                        <div class="radio-group" id="evaluationRadios">
                            <label class="radio-label" data-value="favorable">
                                <i class="fas fa-thumbs-up"></i> Favorable
                                <input type="radio" name="evaluation" value="favorable" required>
                            </label>
                            <label class="radio-label" data-value="defavorable">
                                <i class="fas fa-thumbs-down"></i> Défavorable
                                <input type="radio" name="evaluation" value="defavorable" required>
                            </label>
                        </div>
                        @error('evaluation') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="bg-[#970d0d] text-white px-6 py-2 rounded-lg hover:bg-[#7a0a0a] transition shadow-md">
                            <i class="fas fa-check-circle mr-1"></i> Envoyer mon avis
                        </button>
                    </div>
                </form>
            </div>
            @endif

            <!-- Avis écrit existant -->
            @if($candidature->commentaire_rd)
            <div class="mt-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                <div class="flex items-center gap-2">
                    <i class="fas fa-comment-dots text-blue-500"></i>
                    <span class="font-semibold text-gray-700">Mon avis écrit</span>
                    <span class="text-sm text-gray-400">({{ $candidature->comment_updated_at?->format('d/m/Y H:i') }})</span>
                </div>
                <p class="mt-2 text-gray-700">{{ $candidature->commentaire_rd }}</p>
            </div>
            @endif

            <!-- Formulaire d'avis écrit -->
            <div class="mt-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                    <i class="fas fa-pen text-[#970d0d] mr-2"></i>
                    {{ $candidature->commentaire_rd ? 'Modifier mon avis' : 'Ajouter un avis écrit' }}
                </h3>
                <form action="{{ route('responsable.candidatures.comment', $candidature) }}" method="POST">
                    @csrf
                    <textarea name="commentaire_rd" rows="5" class="w-full border border-gray-200 rounded-lg p-3 focus:ring-2 focus:ring-[#970d0d] focus:border-transparent" placeholder="Votre avis sur cette candidature...">{{ old('commentaire_rd', $candidature->commentaire_rd) }}</textarea>
                    @error('commentaire_rd') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    <div class="mt-4 flex justify-end">
                        <button type="submit" class="bg-gradient-to-r from-amber-500 to-amber-600 text-white px-6 py-2 rounded-lg hover:from-amber-600 hover:to-amber-700 transition shadow-md flex items-center gap-2">
                            <i class="fas fa-save"></i>
                            {{ $candidature->commentaire_rd ? 'Modifier mon avis' : 'Donner mon avis' }}
                        </button>
                    </div>
                </form>
            </div>

            <!-- Bouton retour -->
            <div class="mt-8 flex justify-end">
                <a href="{{ route('responsable.candidatures.index') }}" class="px-6 py-2.5 border border-gray-200 rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors shadow-sm flex items-center gap-2">
                    <i class="fas fa-arrow-left"></i> Retour à la liste
                </a>
            </div>
        </div>
    </div>
</div>

<script>
   
    document.querySelectorAll('.radio-label').forEach(label => {
        const radio = label.querySelector('input[type="radio"]');
        if (radio.checked) label.classList.add('active');

        label.addEventListener('click', () => {
           
            document.querySelectorAll('.radio-label').forEach(l => l.classList.remove('active'));
            label.classList.add('active');
            radio.checked = true;
        });
    });
</script>
@endsection