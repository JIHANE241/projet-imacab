{{-- resources/views/public/offres/show.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $offre->titre }} - IMACAB</title>
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style> body { background: #f9fafb; } </style>
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="max-w-5xl mx-auto py-8 px-4">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 px-6 py-5">
                <h1 class="text-2xl font-bold text-white">{{ $offre->titre }}</h1>
                <p class="text-indigo-100 text-sm mt-1">{{ $offre->direction->nom }}</p>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p><strong>Type de contrat :</strong> {{ $offre->typeContrat->nom }}</p>
                        <p><strong>Niveau d'expérience :</strong> {{ $offre->niveauExperience->nom }}</p>
                        <p><strong>Niveau d'études :</strong> {{ optional($offre->niveauEtude)->nom ?? 'Non précisé' }}</p>
                        <p><strong>Ville :</strong> {{ optional($offre->ville)->nom ?? 'Non spécifiée' }}</p>
                        <p><strong>Salaire :</strong>
                            @if($offre->salaire_min && $offre->salaire_max)
                                {{ number_format($offre->salaire_min,0,',',' ') }} - {{ number_format($offre->salaire_max,0,',',' ') }} MAD
                            @elseif($offre->salaire_min)
                                À partir de {{ number_format($offre->salaire_min,0,',',' ') }} MAD
                            @elseif($offre->salaire_max)
                                Jusqu'à {{ number_format($offre->salaire_max,0,',',' ') }} MAD
                            @else
                                Non spécifié
                            @endif
                        </p>
                    </div>
                    <div>
                        <p><strong>Date de publication :</strong> {{ $offre->date_publication->format('d/m/Y') }}</p>
                        <p><strong>Date limite :</strong> {{ $offre->date_limite ? $offre->date_limite->format('d/m/Y') : 'Non définie' }}</p>
                    </div>
                </div>

                <div class="mt-8">
                    <h3 class="text-lg font-semibold">Description du poste</h3>
                    <div class="mt-2 text-gray-700">{{ $offre->description }}</div>
                </div>

                @if($offre->missions)
                <div class="mt-6">
                    <h3 class="text-lg font-semibold">Missions</h3>
                    <div class="mt-2 text-gray-700">{{ $offre->missions }}</div>
                </div>
                @endif

                @if($offre->profil)
                <div class="mt-6">
                    <h3 class="text-lg font-semibold">Profil recherché</h3>
                    <div class="mt-2 text-gray-700">{{ $offre->profil }}</div>
                </div>
                @endif

                <div class="mt-8">
                    @auth
                        @if(Auth::user()->role == 'candidat')
                            <a href="{{ route('candidat.offres.show', $offre->slug) }}" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700">Postuler</a>
                        @else
                            <p class="text-gray-500">Vous devez être candidat pour postuler. <a href="{{ route('login') }}" class="text-indigo-600">Se connecter</a></p>
                        @endif
                    @else
                        <a href="{{ route('login.with.intended', ['intended' => route('public.offres.show', $offre->slug)]) }}" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700">Se connecter pour postuler</a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</body>
</html>