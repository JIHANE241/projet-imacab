@extends('layouts.candidat')

@section('header', 'Détail de l\'entretien')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-xl shadow-lg p-8 animate-fade-in-up delay-1">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">{{ $entretien->candidature->offre->titre }}</h1>
            <span class="badge px-4 py-2 text-sm rounded-full 
                @if($entretien->statut == 'planifie') bg-blue-100 text-blue-700
                @elseif($entretien->statut == 'passe') bg-green-100 text-green-700
                @else bg-red-100 text-red-700 @endif">
                {{ ucfirst($entretien->statut) }}
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="font-semibold text-lg mb-3">Informations générales</h3>
                <dl class="space-y-2">
                    <div>
                        <dt class="text-sm text-gray-500">Date</dt>
                        <dd class="text-base font-medium">{{ $entretien->date->format('d/m/Y') }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500">Heure</dt>
                        <dd class="text-base font-medium">{{ $entretien->heure ? $entretien->heure->format('H:i') : 'Non précisée' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500">Lieu</dt>
                        <dd class="text-base font-medium">{{ $entretien->lieu ?? 'Non spécifié' }}</dd>
                    </div>
                </dl>
            </div>
            <div>
                <h3 class="font-semibold text-lg mb-3">Offre associée</h3>
                <dl class="space-y-2">
                    <div>
                        <dt class="text-sm text-gray-500">Titre</dt>
                        <dd class="text-base font-medium">{{ $entretien->candidature->offre->titre }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500">Direction</dt>
                        <dd class="text-base font-medium">{{ $entretien->candidature->offre->direction->nom }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500">Entreprise</dt>
                        <dd class="text-base font-medium">imacab</dd>
                    </div>
                </dl>
            </div>
        </div>

        <div class="mt-8 flex gap-4">
            <a href="{{ route('candidat.entretiens.index') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 transition">
                Retour à la liste
            </a>
            @if($entretien->statut == 'planifie')
                <a href="#" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition">
                    <i class="fas fa-video mr-2"></i> Rejoindre
                </a>
            @endif
        </div>
    </div>
</div>
@endsection