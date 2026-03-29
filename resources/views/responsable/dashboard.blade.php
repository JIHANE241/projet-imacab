@extends('layouts.responsable')

@section('header', 'Tableau de bord')

@push('styles')
<style>
    /* Styles de base */
    .stat-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        border-radius: 1rem;
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
        box-shadow: 0 20px 30px -10px rgba(151, 13, 13, 0.4);
    }

    .list-item {
        transition: all 0.2s ease;
        border: 1px solid #e5e7eb;
    }
    .list-item:hover {
        background: #f8fafc;
        transform: translateX(5px);
        border-color: #970d0d;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }

    .badge {
        transition: all 0.2s ease;
        display: inline-block;
    }
    .badge:hover {
        transform: scale(1.05);
        filter: brightness(0.95);
    }

    /* Boutons d'action rapide (style candidat) */
.action-button {
    transition: all 0.3s ease;
    background: linear-gradient(135deg, #4f46e5, #6366f1);
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
    box-shadow: 0 15px 25px -8px rgba(79, 70, 229, 0.5);
}

    .section-title {
        position: relative;
        display: inline-block;
        font-weight: 600;
        color: #1f2937;
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
        background: #970d0d;
        border-radius: 2px;
    }

    .performance-card {
        background: linear-gradient(135deg, #fef2f2, #ffffff);
        border-left: 4px solid #970d0d;
    }

    .candidate-rank {
        transition: all 0.2s;
    }
    .candidate-rank:hover {
        background: #fef2f2;
        transform: translateX(5px);
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
    .delay-7 { animation-delay: 0.7s; }
    .delay-8 { animation-delay: 0.8s; }
    .delay-9 { animation-delay: 0.9s; }
</style>
@endpush

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- En-tête de bienvenue -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-8 animate-fade-in-up delay-1">
        <div class="flex items-center">
            <div class="w-16 h-16 rounded-full bg-gradient-to-br from-[#970d0d] to-[#7a0a0a] flex items-center justify-center text-white text-2xl font-bold shadow-lg">
                {{ substr(Auth::user()->name, 0, 1) }}
            </div>
            <div class="ml-4">
                <h2 class="text-2xl font-bold text-gray-800">Bonjour {{ Auth::user()->name }}</h2>
                <p class="text-gray-500">{{ now()->locale('fr')->isoFormat('dddd D MMMM YYYY') }}</p>
                <p class="text-sm text-[#970d0d] mt-1">Département : {{ Auth::user()->direction->nom ?? 'Non affecté' }}</p>
            </div>
        </div>
    </div>

    <!-- Cartes statistiques principales (unifiées avec dégradé bordeaux) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-6 mb-8">
        <!-- Offres -->
        <div class="stat-card bg-gradient-to-br from-[#970d0d] to-[#7a0a0a] text-white p-5 shadow-xl animate-fade-in-up delay-2">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium opacity-90">Offres</p>
                    <p class="text-3xl font-bold">{{ $totalOffres }}</p>
                </div>
                <i class="fas fa-briefcase text-2xl opacity-80"></i>
            </div>
        </div>
        <!-- Candidatures total -->
        <div class="stat-card bg-gradient-to-br from-[#970d0d] to-[#7a0a0a] text-white p-5 shadow-xl animate-fade-in-up delay-3">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium opacity-90">Candidatures</p>
                    <p class="text-3xl font-bold">{{ $totalCandidatures }}</p>
                </div>
                <i class="fas fa-file-alt text-2xl opacity-80"></i>
            </div>
        </div>
        <!-- En attente -->
        <div class="stat-card bg-gradient-to-br from-[#970d0d] to-[#7a0a0a] text-white p-5 shadow-xl animate-fade-in-up delay-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium opacity-90">En attente</p>
                    <p class="text-3xl font-bold">{{ $enAttente }}</p>
                </div>
                <i class="fas fa-clock text-2xl opacity-80"></i>
            </div>
        </div>
        <!-- En révision -->
        <div class="stat-card bg-gradient-to-br from-[#970d0d] to-[#7a0a0a] text-white p-5 shadow-xl animate-fade-in-up delay-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium opacity-90">En révision</p>
                    <p class="text-3xl font-bold">{{ $enRevision }}</p>
                </div>
                <i class="fas fa-edit text-2xl opacity-80"></i>
            </div>
        </div>
        <!-- Évaluées -->
        <div class="stat-card bg-gradient-to-br from-[#970d0d] to-[#7a0a0a] text-white p-5 shadow-xl animate-fade-in-up delay-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium opacity-90">Évaluées</p>
                    <p class="text-3xl font-bold">{{ $evalue }}</p>
                </div>
                <i class="fas fa-check-double text-2xl opacity-80"></i>
            </div>
        </div>
    </div>

    

   <!-- ================================================== -->
<!-- CHARTE D'ÉVALUATION PROFESSIONNELLE               -->
<!-- ================================================== -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <!-- Graphique de répartition des évaluations -->
    <div class="bg-white rounded-xl shadow-lg p-6 animate-slide-in-right delay-2">
        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
            <i class="fas fa-chart-pie text-[#970d0d] mr-2"></i>
            Répartition des évaluations
        </h3>
        <canvas id="evaluationDistributionChart" height="200"></canvas>
        <div class="mt-4 grid grid-cols-3 gap-2 text-center text-sm">
            <div>
                <span class="inline-block w-3 h-3 rounded-full bg-yellow-500 mr-1"></span>
                <span>En attente</span>
                <p class="font-bold">{{ $enAttente }}</p>
            </div>
            <div>
                <span class="inline-block w-3 h-3 rounded-full bg-blue-500 mr-1"></span>
                <span>En révision</span>
                <p class="font-bold">{{ $enRevision }}</p>
            </div>
            <div>
                <span class="inline-block w-3 h-3 rounded-full bg-green-500 mr-1"></span>
                <span>Évaluées</span>
                <p class="font-bold">{{ $evalue }}</p>
            </div>
        </div>
    </div>

    <!-- Indicateurs de performance d'évaluation -->
    <div class="bg-white rounded-xl shadow-lg p-6 animate-slide-in-right delay-3">
        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
            <i class="fas fa-chart-line text-[#970d0d] mr-2"></i>
            Performance d’évaluation
        </h3>
        <div class="space-y-6">
            <div>
                <div class="flex justify-between text-sm mb-1">
                    <span>Taux d’évaluation</span>
                    <span class="font-medium">{{ $evalue > 0 ? round(($evalue / max(1, $totalCandidatures)) * 100) : 0 }}%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-[#970d0d] h-2 rounded-full" style="width: {{ $evalue > 0 ? ($evalue / max(1, $totalCandidatures)) * 100 : 0 }}%"></div>
                </div>
            </div>
            <div>
                <div class="flex justify-between text-sm mb-1">
                    <span>Délai moyen de traitement</span>
                    <span class="font-medium">{{ $delaiMoyen ?? 'N/A' }}</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-[#970d0d] h-2 rounded-full" style="width: 65%"></div>
                </div>
                <p class="text-xs text-gray-400 mt-1">Objectif : < 5 jours</p>
            </div>
            <div class="grid grid-cols-2 gap-4 pt-2">
                <div class="text-center p-3 bg-green-50 rounded-lg">
                    <p class="text-2xl font-bold text-green-700">{{ $favorables }}</p>
                    <p class="text-xs text-gray-600">Avis favorables</p>
                </div>
                <div class="text-center p-3 bg-red-50 rounded-lg">
                    <p class="text-2xl font-bold text-red-700">{{ $defavorables }}</p>
                    <p class="text-xs text-gray-600">Avis défavorables</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Classement des candidats (Top 5) -->
    <div class="bg-white rounded-xl shadow-lg p-6 animate-slide-in-right delay-4">
        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
            <i class="fas fa-trophy text-[#970d0d] mr-2"></i>
            Classement des candidats
        </h3>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="border-b border-gray-200">
                    <tr class="text-left text-gray-500">
                        <th class="pb-2 font-medium">#</th>
                        <th class="pb-2 font-medium">Candidat</th>
                        <th class="pb-2 font-medium text-right">Évaluation</th>
                        <th class="pb-2 font-medium text-right">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($topCandidats as $index => $c)
                    <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                        <td class="py-2 font-medium">{{ $index + 1 }}</td>
                        <td class="py-2">
                            <div class="flex items-center space-x-2">
                                <div class="w-6 h-6 rounded-full bg-gray-200 flex items-center justify-center text-xs font-bold text-gray-600">
                                    {{ substr($c->candidat->name, 0, 1) }}
                                </div>
                                <span>{{ $c->candidat->name }} {{ $c->candidat->prenom }}</span>
                            </div>
                        </td>
                        <td class="py-2 text-right">
                            <span class="badge px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">
                                <i class="fas fa-check-circle mr-1"></i> Favorable
                            </span>
                        </td>
                        <td class="py-2 text-right text-gray-500">
                            {{ $c->evaluated_at ? $c->evaluated_at->format('d/m/Y') : '—' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-4 text-center text-gray-500">Aucun candidat évalué favorablement.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4 text-right">
            <a href="{{ route('responsable.candidatures.index', ['statut' => 'evalue']) }}" class="text-[#970d0d] hover:text-[#7a0a0a] text-sm inline-flex items-center">
                Voir toutes les évaluations
                <i class="fas fa-arrow-right ml-1 text-xs"></i>
            </a>
        </div>
    </div>
</div>

        <!-- Top candidats (basés sur les avis favorables) -->
        <div class="bg-white rounded-xl shadow-lg p-6 animate-fade-in-up delay-5">
            <h3 class="section-title">Top candidats</h3>
            <div class="space-y-3">
                @forelse($topCandidats as $c)
                <div class="candidate-rank rounded-lg p-3 border border-gray-100">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center text-green-700 font-bold">
                                {{ substr($c->candidat->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="font-medium">{{ $c->candidat->name }} {{ $c->candidat->prenom }}</p>
                                <p class="text-xs text-gray-500">{{ $c->offre->titre }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="badge bg-green-100 text-green-700">Favorable</span>
                            <p class="text-xs text-gray-400">Évalué le {{ $c->evaluated_at->format('d/m/Y') }}</p>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-6 text-gray-500">Aucun candidat évalué favorablement.</div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Prochains entretiens (mini‑calendrier simplifié) -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-8 animate-fade-in-up delay-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="section-title">Prochains entretiens</h3>
            <a href="{{ route('responsable.entretiens.index') }}" class="text-[#970d0d] hover:text-[#7a0a0a] text-sm">Voir tous →</a>
        </div>
        <div class="space-y-3">
            @forelse($prochainsEntretiens as $e)
            <div class="border border-gray-100 rounded-lg p-4 bg-white hover:bg-gray-50 transition-colors">
                <div class="flex flex-wrap justify-between items-center">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-700 font-bold">
                            {{ substr($e->candidature->candidat->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="font-medium">{{ $e->candidature->candidat->name }} {{ $e->candidature->candidat->prenom }}</p>
                            <p class="text-xs text-gray-500">{{ $e->candidature->offre->titre }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="text-right">
                            <p class="text-sm font-medium">{{ $e->date->format('d/m/Y') }}</p>
                            <p class="text-xs text-gray-500">{{ $e->heure ? $e->heure->format('H:i') : 'Horaire non défini' }}</p>
                        </div>
                        <a href="{{ route('responsable.entretiens.edit', $e) }}" class="bg-gray-100 p-2 rounded-lg hover:bg-gray-200">
                            <i class="fas fa-edit text-gray-600"></i>
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-4 text-gray-500">Aucun entretien planifié.</div>
            @endforelse
        </div>
    </div>

    <!-- Actions rapides -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-5 mt-8 animate-fade-in-up delay-7">
    <a href="{{ route('responsable.offres.create') }}" class="group relative bg-gradient-to-r from-indigo-600 to-indigo-700 text-white rounded-xl p-5 text-center flex flex-col items-center justify-center overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
        <span class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity duration-300"></span>
        <i class="fas fa-plus-circle text-2xl mb-2 group-hover:scale-110 transition-transform"></i>
        <span class="font-medium">Nouvelle offre</span>
        <span class="text-xs opacity-80 mt-1">Publier une annonce</span>
    </a>

    <a href="{{ route('responsable.candidatures.index', ['statut' => 'en_attente']) }}" class="group relative bg-gradient-to-r from-indigo-600 to-indigo-700 text-white rounded-xl p-5 text-center flex flex-col items-center justify-center overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
        <span class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity duration-300"></span>
        <i class="fas fa-clipboard-list text-2xl mb-2 group-hover:scale-110 transition-transform"></i>
        <span class="font-medium">Candidatures à évaluer</span>
        <span class="text-xs opacity-80 mt-1">Traiter les avis</span>
    </a>

    <a href="{{ route('responsable.entretiens.create') }}" class="group relative bg-gradient-to-r from-indigo-600 to-indigo-700 text-white rounded-xl p-5 text-center flex flex-col items-center justify-center overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
        <span class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity duration-300"></span>
        <i class="fas fa-calendar-plus text-2xl mb-2 group-hover:scale-110 transition-transform"></i>
        <span class="font-medium">Planifier entretien</span>
        <span class="text-xs opacity-80 mt-1">Programmer un rendez-vous</span>
    </a>

    <a href="{{ route('responsable.statistiques') }}" class="group relative bg-gradient-to-r from-indigo-600 to-indigo-700 text-white rounded-xl p-5 text-center flex flex-col items-center justify-center overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
        <span class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity duration-300"></span>
        <i class="fas fa-chart-line text-2xl mb-2 group-hover:scale-110 transition-transform"></i>
        <span class="font-medium">Voir statistiques</span>
        <span class="text-xs opacity-80 mt-1">Analyser les données</span>
    </a>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Graphique d'évolution des candidatures (line)
        const evolutionCtx = document.getElementById('evolutionChart');
        if (evolutionCtx) {
            new Chart(evolutionCtx, {
                type: 'line',
                data: {
                    labels: {!! json_encode(array_column($evolution, 'mois')) !!},
                    datasets: [{
                        label: 'Candidatures',
                        data: {!! json_encode(array_column($evolution, 'total')) !!},
                        borderColor: '#970d0d',
                        backgroundColor: 'rgba(151, 13, 13, 0.1)',
                        tension: 0.3,
                        fill: true
                    }]
                },
                options: { responsive: true, maintainAspectRatio: true }
            });
        }

        // 2. Graphique de répartition des candidatures par statut (doughnut)
        const repartitionCtx = document.getElementById('repartitionChart');
        if (repartitionCtx) {
            new Chart(repartitionCtx, {
                type: 'doughnut',
                data: {
                    labels: ['En attente', 'En révision', 'Évaluées'],
                    datasets: [{
                        data: [
                            {{ $repartition['en_attente'] ?? 0 }},
                            {{ $repartition['en_revision'] ?? 0 }},
                            {{ $repartition['evalue'] ?? 0 }}
                        ],
                        backgroundColor: ['#eab308', '#3b82f6', '#14b8a6'],
                        borderWidth: 0
                    }]
                },
                options: { responsive: true, maintainAspectRatio: true }
            });
        }

       
        const evalDistCtx = document.getElementById('evaluationDistributionChart');
        if (evalDistCtx) {
            new Chart(evalDistCtx, {
                type: 'doughnut',
                data: {
                    labels: ['En attente', 'En révision', 'Évaluées'],
                    datasets: [{
                        data: [
                            {{ $enAttente ?? 0 }},
                            {{ $enRevision ?? 0 }},
                            {{ $evalue ?? 0 }}
                        ],
                        backgroundColor: ['#eab308', '#3b82f6', '#10b981'],
                        borderWidth: 0,
                        hoverOffset: 5
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: { position: 'bottom' }
                    }
                }
            });
        }
    });
</script>
@endsection