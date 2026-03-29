@extends('layouts.candidat')

@section('header', 'Détail de la candidature')

@push('styles')
<style>
    :root {
        --primary: #4f46e5;
        --primary-light: #818cf8;
        --primary-soft: #e0e7ff;
        --gray-50: #f9fafb;
        --gray-100: #f3f4f6;
        --gray-200: #e5e7eb;
        --gray-600: #4b5563;
        --gray-700: #374151;
        --gray-800: #1f2937;
        --gray-900: #111827;
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes slideInRight {
        from { opacity: 0; transform: translateX(-20px); }
        to { opacity: 1; transform: translateX(0); }
    }

    .animate-fade-in-up {
        animation: fadeInUp 0.6s ease-out forwards;
        opacity: 0;
    }
    .animate-slide-in-right {
        animation: slideInRight 0.5s ease-out forwards;
        opacity: 0;
    }
    .delay-1 { animation-delay: 0.1s; }
    .delay-2 { animation-delay: 0.2s; }
    .delay-3 { animation-delay: 0.3s; }
    .delay-4 { animation-delay: 0.4s; }
    .delay-5 { animation-delay: 0.5s; }

    .card {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        transition: box-shadow 0.2s ease, transform 0.2s ease;
    }
    .card:hover {
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        transform: translateY(-2px);
    }

    .badge {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
        line-height: 1;
    }
    .badge i {
        margin-right: 0.25rem;
        font-size: 0.75rem;
    }

    .detail-row {
        display: flex;
        justify-content: space-between;
        padding: 0.75rem 0;
        border-bottom: 1px solid var(--gray-200);
    }
    .detail-row:last-child {
        border-bottom: none;
    }
    .detail-label {
        color: var(--gray-600);
        font-size: 0.875rem;
    }
    .detail-value {
        font-weight: 500;
        color: var(--gray-800);
        text-align: right;
    }

    .message-acceptee {
        background-color: #d1fae5;
        border-left: 4px solid #10b981;
        color: #065f46;
    }
    .message-refusee {
        background-color: #fee2e2;
        border-left: 4px solid #ef4444;
        color: #991b1b;
    }
    .message-attente {
        background-color: #fef3c7;
        border-left: 4px solid #f59e0b;
        color: #92400e;
    }
</style>
@endpush

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Fil d'Ariane -->
    <nav class="text-sm text-gray-500 mb-6 animate-fade-in-up delay-1">
        <a href="{{ route('candidat.candidatures.index') }}" class="hover:text-indigo-600 transition-colors">Mes candidatures</a>
        <span class="mx-2">/</span>
        <span class="text-gray-700 font-medium">{{ $candidature->offre->titre }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Colonne principale (2/3) : détails de l'offre et message -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Message de statut -->
            <div class="card p-6 animate-fade-in-up delay-2">
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0">
                        @if($candidature->statut == 'acceptee')
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center text-green-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        @elseif($candidature->statut == 'refusee')
                            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center text-red-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        @else
                            <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center text-yellow-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        @endif
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-gray-800 mb-1">
                            @if($candidature->statut == 'acceptee')
                                Félicitations ! Votre candidature a été acceptée.
                            @elseif($candidature->statut == 'refusee')
                                Nous sommes désolés, votre candidature n'a pas été retenue.
                            @else
                                Votre candidature est en cours d'examen.
                            @endif
                        </h3>
                        <p class="text-sm text-gray-600">
                            @if($candidature->statut == 'acceptee')
                                Le recruteur vous contactera très prochainement pour la suite du processus.
                            @elseif($candidature->statut == 'refusee')
                                Ne vous découragez pas, de nombreuses autres offres sont disponibles.
                            @else
                                Merci de votre patience. Nous traitons actuellement votre dossier.
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <!-- Carte : rappel de l'offre -->
            <div class="card p-6 animate-fade-in-up delay-3">
                <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                    <span class="w-1.5 h-1.5 bg-indigo-600 rounded-full mr-2"></span>
                    Offre associée
                </h2>
                <div class="flex items-start space-x-4">
                    <div class="w-16 h-16 bg-indigo-100 rounded-xl flex items-center justify-center text-indigo-700 font-bold text-2xl">
                        {{ substr($candidature->offre->titre, 0, 2) }}
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-bold text-gray-800">{{ $candidature->offre->titre }}</h3>
                        <p class="text-sm text-gray-500">{{ $candidature->offre->direction->nom }}</p>
                        <div class="flex flex-wrap gap-2 mt-2">
                            <span class="badge bg-gray-100 text-gray-700">
                                <i class="fas fa-map-marker-alt text-indigo-500 mr-1"></i> {{ $candidature->offre->ville->nom ?? 'Non spécifié' }}
                            </span>
                            <span class="badge bg-gray-100 text-gray-700">
                                <i class="fas fa-briefcase text-indigo-500 mr-1"></i> {{ $candidature->offre->typeContrat->nom ?? 'Non spécifié' }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <a href="{{ route('candidat.offres.show', $candidature->offre) }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 font-medium">
                        Voir l'offre en détail
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Description rapide de l'offre -->
            <div class="card p-6 animate-fade-in-up delay-4">
                <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                    <span class="w-1.5 h-1.5 bg-indigo-600 rounded-full mr-2"></span>
                    Description du poste
                </h2>
                <p class="text-gray-700 line-clamp-3">{{ $candidature->offre->description }}</p>
                <div class="mt-3">
                    <a href="{{ route('candidat.offres.show', $candidature->offre) }}" class="text-indigo-600 hover:underline text-sm">Lire la suite</a>
                </div>
            </div>
        </div>

        <!-- Colonne latérale (1/3) : informations de la candidature -->
        <div class="space-y-6">
            <!-- Carte informations candidature -->
            <div class="card p-6 animate-slide-in-right delay-2 sticky top-24">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Informations de candidature</h3>
                <dl class="space-y-3">
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <dt class="text-sm text-gray-500">Date de postulation</dt>
                        <dd class="font-medium text-gray-800">{{ $candidature->created_at->format('d/m/Y à H:i') }}</dd>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <dt class="text-sm text-gray-500">Statut</dt>
                        <dd>
                            <span class="badge 
                                @if($candidature->statut == 'acceptee') bg-green-100 text-green-700
                                @elseif($candidature->statut == 'refusee') bg-red-100 text-red-700
                                @else bg-yellow-100 text-yellow-700 @endif">
                                @if($candidature->statut == 'acceptee')
                                    <i class="fas fa-check-circle"></i>
                                @elseif($candidature->statut == 'refusee')
                                    <i class="fas fa-times-circle"></i>
                                @else
                                    <i class="fas fa-clock"></i>
                                @endif
                                {{ ucfirst($candidature->statut) }}
                            </span>
                        </dd>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <dt class="text-sm text-gray-500">Niveau d'études</dt>
                        <dd class="font-medium text-gray-800">{{ $candidature->niveau_etude->nom ?? 'Non renseigné' }}</dd>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <dt class="text-sm text-gray-500">Expérience</dt>
                        <dd class="font-medium text-gray-800">
                            @switch($candidature->niveau_experience)
                                @case('etudiant') Étudiant / jeune diplômé @break
                                @case('debutant_moins_2') Débutant (< 2 ans) @break
                                @case('entre_2_5') 2 à 5 ans @break
                                @case('entre_5_10') 5 à 10 ans @break
                                @case('plus_10') Plus de 10 ans @break
                                @default Non précisé
                            @endswitch
                        </dd>
                    </div>
                </dl>
                <div class="mt-6">
                    <a href="{{ route('candidat.candidatures.index') }}" class="w-full bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 transition-colors text-center block">
                        Retour à mes candidatures
                    </a>
                </div>
            </div>

            <!-- Carte entreprise (rappel) -->
            <div class="card p-6 animate-slide-in-right delay-3">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Entreprise</h3>
                <div class="flex items-center space-x-3 mb-3">
                    <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center text-indigo-700 font-bold">
                        {{ substr($candidature->offre->direction->nom, 0, 2) }}
                    </div>
                    <div>
                        <p class="font-medium text-gray-800">{{ $candidature->offre->direction->nom }}</p>
                        <p class="text-xs text-gray-500">{{ $candidature->offre->direction->secteur_activite ?? 'Secteur non spécifié' }}</p>
                    </div>
                </div>
                @if($candidature->offre->direction->site_web)
                    <a href="{{ $candidature->offre->direction->site_web }}" target="_blank" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 text-sm">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                        Site web
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection