@extends('layouts.admin')

@section('header', 'Détails de l\'offre')

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
</style>
@endpush

@section('content')
<div class="max-w-4xl mx-auto animate-fade-in-up delay-1">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <!-- En-tête avec dégradé et statut -->
        <div class="bg-gradient-to-r from-[#970d0d] to-[#7a0a0a] px-6 py-5">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h2 class="text-xl font-bold text-white">{{ $offre->titre }}</h2>
                    <p class="text-red-100 text-sm mt-1">{{ $offre->direction->nom }}</p>
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

        <div class="p-6">
            <dl class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Direction -->
                <div class="info-item p-4 rounded-lg border border-gray-100">
                    <dt class="text-sm font-medium text-gray-500 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-[#970d0d]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        Direction
                    </dt>
                    <dd class="mt-1 text-base text-gray-900 font-medium">{{ $offre->direction->nom }}</dd>
                </div>

                <!-- Catégorie -->
                <div class="info-item p-4 rounded-lg border border-gray-100">
                    <dt class="text-sm font-medium text-gray-500 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-[#970d0d]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l5 5a2 2 0 01.586 1.414V19a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z" />
                        </svg>
                        Catégorie
                    </dt>
                    <dd class="mt-1 text-base text-gray-900">{{ $offre->category->nom }}</dd>
                </div>

                <!-- Type de contrat -->
                <div class="info-item p-4 rounded-lg border border-gray-100">
                    <dt class="text-sm font-medium text-gray-500 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-[#970d0d]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Type de contrat
                    </dt>
                    <dd class="mt-1 text-base text-gray-900">{{ $offre->typeContrat->nom }}</dd>
                </div>

                <!-- Niveau d'expérience -->
                <div class="info-item p-4 rounded-lg border border-gray-100">
                    <dt class="text-sm font-medium text-gray-500 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-[#970d0d]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        Niveau d'expérience
                    </dt>
                    <dd class="mt-1 text-base text-gray-900">{{ $offre->niveauExperience->nom }}</dd>
                </div>

                <!-- Niveau d'études -->
                <div class="info-item p-4 rounded-lg border border-gray-100">
                    <dt class="text-sm font-medium text-gray-500 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-[#970d0d]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                        </svg>
                        Niveau d'études
                    </dt>
                    <dd class="mt-1 text-base text-gray-900">{{ $offre->niveauEtude->nom ?? 'Non précisé' }}</dd>
                </div>
                <!-- Date de publication -->
                <div class="info-item p-4 rounded-lg border border-gray-100">
                    <dt class="text-sm font-medium text-gray-500 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-[#970d0d]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Date de publication
                    </dt>
                    <dd class="mt-1 text-base text-gray-900">{{ $offre->date_publication->format('d/m/Y') }}</dd>
                </div>

                <!-- Date limite -->
                <div class="info-item p-4 rounded-lg border border-gray-100">
                    <dt class="text-sm font-medium text-gray-500 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-[#970d0d]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Date limite
                    </dt>
                    <dd class="mt-1 text-base text-gray-900">{{ $offre->date_limite ? $offre->date_limite->format('d/m/Y') : 'Non définie' }}</dd>
                </div>

                <!-- Salaire -->
                <div class="info-item p-4 rounded-lg border border-gray-100">
                    <dt class="text-sm font-medium text-gray-500 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-[#970d0d]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
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

                <!-- Description (pleine largeur) -->
                <div class="md:col-span-2">
                    <div class="info-item p-4 rounded-lg border border-gray-100">
                        <dt class="text-sm font-medium text-gray-500 flex items-center mb-2">
                            <svg class="w-4 h-4 mr-2 text-[#970d0d]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                            </svg>
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
                            <svg class="w-4 h-4 mr-2 text-[#970d0d]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                            </svg>
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
                            <svg class="w-4 h-4 mr-2 text-[#970d0d]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                            </svg>
                            Profil recherché
                        </dt>
                        <dd class="text-base text-gray-900 whitespace-pre-line">{{ $offre->profil }}</dd>
                    </div>
                </div>
                @endif
            </dl>

            <!-- Boutons d'action -->
            <div class="mt-8 flex flex-wrap items-center justify-end gap-4">
                <a href="{{ route('admin.offres.index', ['direction_id' => $offre->direction_id]) }}" 
                   class="px-6 py-2.5 border border-gray-200 rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors shadow-sm flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Retour
                </a>
                <a href="{{ route('admin.offres.edit', $offre) }}" 
                   class="px-6 py-2.5 bg-gradient-to-r from-amber-500 to-amber-600 text-white rounded-lg hover:from-amber-600 hover:to-amber-700 transition-all shadow-md hover:shadow-lg flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Modifier
                </a>
                @if($offre->statut == 'ouverte')
                    <form action="{{ route('admin.offres.fermer', $offre) }}" method="POST" class="inline" onsubmit="return confirm('Fermer cette offre ?')">
                        @csrf
                        <button type="submit" class="px-6 py-2.5 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-all shadow-md hover:shadow-lg flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                            </svg>
                            Fermer
                        </button>
                    </form>
                @endif
                @if($offre->statut == 'brouillon')
                    <form action="{{ route('admin.offres.valider', $offre) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                            Valider l'offre
                        </button>
                    </form>
                @endif
            </div>
            <div class="mt-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
    <p class="text-sm font-medium text-gray-700 mb-2">Lien public de l’offre</p>
    <div class="flex items-center gap-2">
        <input type="text" id="publicLink" value="{{ route('public.offres.show', $offre->slug) }}" class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm bg-white" readonly>
        <button onclick="copyToClipboard()" class="bg-indigo-100 text-indigo-700 px-3 py-2 rounded-lg hover:bg-indigo-200 transition">
            <i class="fas fa-copy"></i> Copier
        </button>
        <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(route('public.offres.show', $offre->slug)) }}&title={{ urlencode($offre->titre) }}" target="_blank" class="bg-blue-100 text-blue-700 px-3 py-2 rounded-lg hover:bg-blue-200 transition">
            <i class="fab fa-linkedin"></i> Partager
        </a>
    </div>
</div>

<script>
    function copyToClipboard() {
        var copyText = document.getElementById("publicLink");
        copyText.select();
        copyText.setSelectionRange(0, 99999);
        document.execCommand("copy");
        alert("Lien copié !");
    }
</script>
        </div>
    </div>
</div>
@endsection