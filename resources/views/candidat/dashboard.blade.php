@extends('layouts.candidat')

@section('header', 'Tableau de bord')

@push('styles')
<style>
    /* Variables de couleurs */
    :root {
        --primary: #3b82f6;
        --primary-dark: #2563eb;
        --success: #10b981;
        --warning: #f59e0b;
        --danger: #ef4444;
        --dark: #1f2937;
        --light: #f9fafb;
    }

    /* Animations */
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
    .delay-6 { animation-delay: 0.6s; }

    /* Cartes statistiques */
    .stat-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid rgba(255,255,255,0.1);
        position: relative;
        overflow: hidden;
    }

    .stat-card::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(255,255,255,0.2) 0%, transparent 50%);
        opacity: 0;
        transition: opacity 0.3s;
    }

    .stat-card:hover::after {
        opacity: 1;
    }

    .stat-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 30px -10px rgba(59, 130, 246, 0.4);
    }

    /* Éléments de liste */
    .list-item {
        transition: all 0.2s ease;
        border: 1px solid #e5e7eb;
        background: white;
    }

    .list-item:hover {
        background: #f8fafc;
        transform: translateX(5px);
        border-color: var(--primary);
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }

    /* Badges */
    .badge {
        transition: all 0.2s ease;
        display: inline-block;
    }

    .badge:hover {
        transform: scale(1.05);
        filter: brightness(0.95);
    }

    /* Boutons d'action rapide */
    .action-button {
        transition: all 0.3s ease;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        border: none;
        position: relative;
        overflow: hidden;
    }

    .action-button::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255,255,255,0.2);
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
    }

    .action-button:hover::before {
        width: 300px;
        height: 300px;
    }

    .action-button:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 25px -8px rgba(59, 130, 246, 0.5);
    }

    /* Titres de section */
    .section-title {
        position: relative;
        display: inline-block;
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 40px;
        height: 3px;
        background: var(--primary);
        border-radius: 2px;
    }

    /* Conteneur du graphique */
    .chart-container {
        position: relative;
        height: 300px;
        width: 100%;
    }
</style>
@endpush

@section('content')
    <!-- En-tête avec photo, bonjour, date -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-8 animate-fade-in-up delay-1">
        <div class="flex items-center">
            <div class="w-16 h-16 rounded-full bg-gradient-to-br from-indigo-500 to-blue-600 flex items-center justify-center text-white text-2xl font-bold shadow-lg">
                @if(Auth::user()->photo)
                    <img src="{{ asset('storage/'.Auth::user()->photo) }}" alt="Photo" class="w-16 h-16 rounded-full object-cover">
                @else
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                @endif
            </div>
            <div class="ml-4">
                <h2 class="text-2xl font-bold text-gray-800">Bonjour {{ Auth::user()->prenom ?? Auth::user()->name }}</h2>
                <p class="text-gray-500">{{ now()->locale('fr')->isoFormat('dddd D MMMM YYYY') }}</p>
            </div>
        </div>
    </div>

    <!-- Cartes statistiques avec dégradés -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <!-- Total candidatures -->
        <div class="stat-card bg-gradient-to-br from-blue-600 to-blue-700 text-white p-5 rounded-xl shadow-xl animate-fade-in-up delay-2">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium opacity-90">Total candidatures</p>
                    <p class="text-3xl font-bold">{{ $totalCandidatures }}</p>
                </div>
                <div class="bg-white/20 p-3 rounded-xl backdrop-blur-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Acceptées -->
        <div class="stat-card bg-gradient-to-br from-green-600 to-green-700 text-white p-5 rounded-xl shadow-xl animate-fade-in-up delay-3">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium opacity-90">Acceptées</p>
                    <p class="text-3xl font-bold">{{ $acceptees }}</p>
                </div>
                <div class="bg-white/20 p-3 rounded-xl backdrop-blur-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Refusées -->
        <div class="stat-card bg-gradient-to-br from-red-600 to-red-700 text-white p-5 rounded-xl shadow-xl animate-fade-in-up delay-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium opacity-90">Refusées</p>
                    <p class="text-3xl font-bold">{{ $refusees }}</p>
                </div>
                <div class="bg-white/20 p-3 rounded-xl backdrop-blur-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- En attente -->
        <div class="stat-card bg-gradient-to-br from-yellow-600 to-yellow-700 text-white p-5 rounded-xl shadow-xl animate-fade-in-up delay-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium opacity-90">En attente</p>
                    <p class="text-3xl font-bold">{{ $enAttente }}</p>
                </div>
                <div class="bg-white/20 p-3 rounded-xl backdrop-blur-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Dernières candidatures et dernières offres -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Dernières candidatures -->
<div class="bg-white rounded-xl shadow-lg p-6 animate-slide-in-right delay-2">
    <div class="flex justify-between items-center mb-4">
        <h3 class="section-title flex items-center">
            <span class="w-2 h-2 bg-blue-400 rounded-full mr-2"></span>
            Dernières candidatures
        </h3>
        <a href="{{ route('candidat.candidatures.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium flex items-center gap-1">
            Voir tout
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </a>
    </div>
    <div class="space-y-3">
        @forelse($dernieresCandidatures as $c)
            <div class="border border-gray-100 rounded-lg p-3 bg-white hover:bg-gray-50 transition-colors">
                <div class="flex items-center justify-between">
                    <p class="font-medium text-gray-800">
                        {{ optional($c->offre)->titre ?? 'Offre indisponible' }}
                    </p>
                    <span class="badge px-2 py-1 text-xs rounded-full 
                        @if($c->statut == 'acceptee') bg-green-100 text-green-700
                        @elseif($c->statut == 'refusee') bg-red-100 text-red-700
                        @else bg-yellow-100 text-yellow-700 @endif">
                        {{ ucfirst($c->statut) }}
                    </span>
                </div>
                <p class="text-xs text-gray-500 mt-1">{{ $c->created_at->format('d/m/Y') }}</p>
            </div>
        @empty
            <div class="text-center py-8 text-gray-500 bg-gray-50 rounded-lg">
                <svg class="w-12 h-12 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p>Aucune candidature récente.</p>
            </div>
        @endforelse
    </div>
</div>

        <!-- Dernières offres -->
        <div class="bg-white rounded-xl shadow-lg p-6 animate-slide-in-right delay-3">
            <div class="flex justify-between items-center mb-4">
                <h3 class="section-title flex items-center">
                    <span class="w-2 h-2 bg-green-400 rounded-full mr-2"></span>
                    Dernières offres
                </h3>
                <a href="{{ route('candidat.offres.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium flex items-center gap-1">
                    Voir tout
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
            <div class="space-y-3">
                @forelse($dernieresOffres as $offre)
                    <div class="border border-gray-100 rounded-lg p-3 bg-white hover:bg-gray-50 transition-colors">
                        <div class="flex items-center justify-between">
                            <p class="font-medium text-gray-800">{{ $offre->titre }}</p>
                            <a href="{{ route('candidat.offres.show', $offre->slug) }}" class="badge bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full text-sm hover:bg-indigo-200">
                                Postuler
                            </a>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">{{ $offre->direction->nom }}</p>
                    </div>
                @empty
                    <div class="text-center py-8 text-gray-500 bg-gray-50 rounded-lg">
                        <svg class="w-12 h-12 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                        <p>Aucune offre récente.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Graphique circulaire des statuts -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-8 animate-fade-in-up delay-4">
        <h3 class="section-title flex items-center mb-4">
            <span class="w-2 h-2 bg-purple-400 rounded-full mr-2"></span>
            Répartition des candidatures
        </h3>
        <div class="chart-container">
            <canvas id="candidaturesPieChart"></canvas>
        </div>
    </div>

    <!-- Actions rapides -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mt-8 animate-fade-in-up delay-6">
        <a href="{{ route('candidat.offres.index') }}" class="group relative bg-gradient-to-r from-indigo-600 to-indigo-700 text-white rounded-xl p-6 text-center flex flex-col items-center justify-center overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
            <span class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity duration-300"></span>
            <svg class="w-8 h-8 mb-2 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <span class="font-medium">Rechercher une offre</span>
            <span class="text-xs opacity-80 mt-1">Parcourir les annonces</span>
        </a>
        <a href="{{ route('candidat.candidatures.index') }}" class="group relative bg-gradient-to-r from-indigo-600 to-indigo-700 text-white rounded-xl p-6 text-center flex flex-col items-center justify-center overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
            <span class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity duration-300"></span>
            <svg class="w-8 h-8 mb-2 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <span class="font-medium">Voir mes candidatures</span>
            <span class="text-xs opacity-80 mt-1">Suivre mes postulations</span>
        </a>
        <a href="{{ route('candidat.cv.edit') }}" class="group relative bg-gradient-to-r from-indigo-600 to-indigo-700 text-white rounded-xl p-6 text-center flex flex-col items-center justify-center overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
            <span class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity duration-300"></span>
            <svg class="w-8 h-8 mb-2 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
            </svg>
            <span class="font-medium">Voir mon CV</span>
            <span class="text-xs opacity-80 mt-1">Mettre à jour</span>
        </a>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('candidaturesPieChart').getContext('2d');
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Acceptées', 'Refusées', 'En attente'],
                datasets: [{
                    data: [{{ $acceptees }}, {{ $refusees }}, {{ $enAttente }}],
                    backgroundColor: ['#10b981', '#ef4444', '#f59e0b'],
                    borderColor: '#ffffff',
                    borderWidth: 2,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { usePointStyle: true, boxWidth: 8, font: { size: 12 } }
                    },
                    tooltip: { backgroundColor: '#1e293b', titleColor: '#f8fafc', bodyColor: '#cbd5e1' }
                }
            }
        });
    });
</script>
@endpush