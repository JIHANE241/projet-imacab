@extends('layouts.admin')

@section('header', 'Détails de la candidature')

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

    .info-item {
        transition: background-color 0.2s ease;
    }
    .info-item:hover {
        background-color: #fef2f2; /* rouge très clair */
    }

    .action-button {
        transition: all 0.2s ease;
    }
    .action-button:hover {
        transform: scale(1.05);
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
</style>
@endpush

@section('content')
<div class="max-w-4xl mx-auto animate-fade-in-up delay-1">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <!-- En-tête avec dégradé et statut -->
        <div class="bg-gradient-to-r from-[#970d0d] to-[#7a0a0a] px-6 py-5">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h2 class="text-xl font-bold text-white">Candidature de {{ $candidature->candidat->name }}</h2>
                    <p class="text-red-100 text-sm mt-1">{{ $candidature->offre->titre }} · {{ $candidature->offre->direction->nom }}</p>
                </div>
                <div class="mt-2 md:mt-0">
                    <span class="px-4 py-2 text-sm font-semibold rounded-full shadow-lg
                        @if($candidature->statut == 'acceptee') bg-green-500 text-white
                        @elseif($candidature->statut == 'refusee') bg-red-500 text-white
                        @else bg-yellow-500 text-white @endif">
                        {{ ucfirst(str_replace('_', ' ', $candidature->statut)) }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Corps des informations -->
        <div class="p-6">
            <dl class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Candidat -->
                <div class="info-item p-4 rounded-lg border border-gray-100">
                    <dt class="text-sm font-medium text-gray-500 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-[#970d0d]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Candidat
                    </dt>
                    <dd class="mt-1 text-base text-gray-900 font-medium">{{ $candidature->candidat->name }}</dd>
                </div>

                <!-- Offre -->
                <div class="info-item p-4 rounded-lg border border-gray-100">
                    <dt class="text-sm font-medium text-gray-500 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-[#970d0d]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        Offre
                    </dt>
                    <dd class="mt-1 text-base text-gray-900">{{ $candidature->offre->titre }}</dd>
                </div>

                <!-- Expérience -->
                <div class="info-item p-4 rounded-lg border border-gray-100">
                    <dt class="text-sm font-medium text-gray-500 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-[#970d0d]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        Expérience
                    </dt>
                    <dd class="mt-1 text-base text-gray-900">{{ $candidature->experience ?? 'Non renseignée' }} ans</dd>
                </div>

                <!-- Adresse -->
                <div class="info-item p-4 rounded-lg border border-gray-100">
                    <dt class="text-sm font-medium text-gray-500 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-[#970d0d]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Adresse
                    </dt>
                    <dd class="mt-1 text-base text-gray-900">{{ $candidature->adresse ?? '-' }}</dd>
                </div>

                <!-- Formation -->
                <div class="info-item p-4 rounded-lg border border-gray-100">
                    <dt class="text-sm font-medium text-gray-500 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-[#970d0d]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                        </svg>
                        Formation
                    </dt>
                    <dd class="mt-1 text-base text-gray-900">{{ $candidature->formation ?? '-' }}</dd>
                </div>

                <!-- Statut -->
                <div class="info-item p-4 rounded-lg border border-gray-100">
                    <dt class="text-sm font-medium text-gray-500 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-[#970d0d]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Statut
                    </dt>
                    <dd class="mt-1">
                        <span class="px-3 py-1 text-xs rounded-full font-semibold
                            @if($candidature->statut == 'acceptee') bg-green-100 text-green-800
                            @elseif($candidature->statut == 'refusee') bg-red-100 text-red-800
                            @else bg-yellow-100 text-yellow-800 @endif">
                            {{ ucfirst(str_replace('_', ' ', $candidature->statut)) }}
                        </span>
                    </dd>
                </div>

                <!-- Entretien planifié -->
                <div class="info-item p-4 rounded-lg border border-gray-100">
                    <dt class="text-sm font-medium text-gray-500 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-[#970d0d]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Entretien planifié
                    </dt>
                    <dd class="mt-1 text-base text-gray-900">
                        @if($candidature->entretien_planifie)
                            <span class="text-green-600 font-medium">Oui</span>
                        @else
                            <span class="text-gray-400">Non</span>
                        @endif
                    </dd>
                </div>

                <!-- Date de candidature -->
                <div class="info-item p-4 rounded-lg border border-gray-100">
                    <dt class="text-sm font-medium text-gray-500 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-[#970d0d]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Date de candidature
                    </dt>
                    <dd class="mt-1 text-base text-gray-900">{{ $candidature->created_at->format('d/m/Y H:i') }}</dd>
                </div>
            </dl>

           <div class="mt-6">
    <div class="info-item p-4 rounded-lg border border-gray-100">
        <dt class="text-sm font-medium text-gray-500 flex items-center mb-2">
            <svg class="w-4 h-4 mr-2 text-[#970d0d]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
            </svg>
            Commentaire du responsable
            @if($candidature->comment_updated_at)
                <span class="text-xs text-gray-400 ml-2">({{ $candidature->comment_updated_at->format('d/m/Y H:i') }})</span>
            @endif
        </dt>
        <dd class="text-base text-gray-900 whitespace-pre-line">
            {{ $candidature->commentaire_rd ?? 'Aucun commentaire pour le moment.' }}
        </dd>
    </div>
</div>

           <div class="mt-6">
    <div class="info-item p-4 rounded-lg border border-gray-100">
        <dt class="text-sm font-medium text-gray-500 flex items-center mb-2">
            <svg class="w-4 h-4 mr-2 text-[#970d0d]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Évaluation du responsable
            @if($candidature->evaluated_at)
                <span class="text-xs text-gray-400 ml-2">({{ $candidature->evaluated_at->format('d/m/Y H:i') }})</span>
            @endif
        </dt>
        <dd>
            @if($candidature->evaluation)
                <span class="badge {{ $candidature->evaluation == 'favorable' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                    {{ ucfirst($candidature->evaluation) }}
                </span>
            @else
                <span class="text-gray-400">Non encore évalué</span>
            @endif
        </dd>
        @if($candidature->evaluation_comment)
            <dd class="mt-2 text-gray-700">{{ $candidature->evaluation_comment }}</dd>
        @elseif(!$candidature->evaluation)
            <dd class="mt-2 text-gray-500 italic">Aucun commentaire pour le moment.</dd>
        @endif
    </div>
</div>

            <!-- CV -->
            @if($candidature->cv_path)
            <div class="mt-6">
                <div class="info-item p-4 rounded-lg border border-gray-100">
                    <dt class="text-sm font-medium text-gray-500 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-[#970d0d]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        CV
                    </dt>
                    <dd class="mt-1">
                        <a href="{{ route('admin.candidatures.cv', $candidature) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-[#970d0d]/10 text-[#970d0d] rounded-lg hover:bg-[#970d0d]/20 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Télécharger le CV
                        </a>
                    </dd>
                </div>
            </div>
            @endif

            <!-- Boutons d'action -->
            <div class="mt-8 flex flex-wrap items-center justify-end gap-4">
                <a href="{{ route('admin.candidatures.index', ['direction_id' => $candidature->offre->direction_id]) }}" 
                   class="px-6 py-2.5 border border-gray-200 rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors shadow-sm flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Retour
                </a>

                @if($candidature->statut == 'en_attente')
                    <form action="{{ route('admin.candidatures.accepter', $candidature) }}" method="POST" class="inline" onsubmit="return confirm('Accepter cette candidature ?')">
                        @csrf
                        <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-lg hover:from-green-700 hover:to-green-800 transition-all shadow-md hover:shadow-lg flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Accepter
                        </button>
                    </form>
                    <form action="{{ route('admin.candidatures.refuser', $candidature) }}" method="POST" class="inline" onsubmit="return confirm('Refuser cette candidature ?')">
                        @csrf
                        <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-lg hover:from-red-700 hover:to-red-800 transition-all shadow-md hover:shadow-lg flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Refuser
                        </button>
                    </form>
                @endif

                @if(!$candidature->entretien_planifie && $candidature->statut == 'acceptee')
                    <a href="{{ route('admin.entretiens.create', ['candidature_id' => $candidature->id]) }}" 
                       class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all shadow-md hover:shadow-lg flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Planifier un entretien
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection