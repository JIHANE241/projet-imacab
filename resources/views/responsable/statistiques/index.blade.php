@extends('layouts.responsable')

@section('header', 'Statistiques')

@push('styles')
<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes slideInRight {
        from { opacity: 0; transform: translateX(-20px); }
        to { opacity: 1; transform: translateX(0); }
    }
    .animate-fade-in-up {
        animation: fadeInUp 0.5s ease-out forwards;
    }
    .animate-slide-in-right {
        animation: slideInRight 0.5s ease-out forwards;
    }
    .delay-1 { animation-delay: 0.1s; }
    .delay-2 { animation-delay: 0.2s; }
    .delay-3 { animation-delay: 0.3s; }

    .stat-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(151, 13, 13, 0.4);
    }
</style>
@endpush

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Cartes statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-8 animate-fade-in-up delay-1">
        <!-- Total offres -->
        <div class="stat-card bg-gradient-to-br from-[#970d0d] to-[#7a0a0a] text-white p-5 rounded-xl shadow-xl">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm opacity-90">Total offres</p>
                    <p class="text-3xl font-bold">{{ $totalOffres ?? 0 }}</p>
                </div>
                <i class="fas fa-briefcase text-3xl opacity-80"></i>
            </div>
        </div>

        <!-- Total candidatures -->
        <div class="stat-card bg-gradient-to-br from-[#970d0d] to-[#7a0a0a] text-white p-5 rounded-xl shadow-xl">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm opacity-90">Total candidatures</p>
                    <p class="text-3xl font-bold">{{ $totalCandidatures ?? 0 }}</p>
                </div>
                <i class="fas fa-file-alt text-3xl opacity-80"></i>
            </div>
        </div>

        <!-- En attente -->
        <div class="stat-card bg-gradient-to-br from-[#970d0d] to-[#7a0a0a] text-white p-5 rounded-xl shadow-xl">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm opacity-90">En attente</p>
                    <p class="text-3xl font-bold">{{ $enAttente ?? 0 }}</p>
                </div>
                <i class="fas fa-clock text-3xl opacity-80"></i>
            </div>
        </div>

        <!-- En révision -->
        <div class="stat-card bg-gradient-to-br from-[#970d0d] to-[#7a0a0a] text-white p-5 rounded-xl shadow-xl">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm opacity-90">En révision</p>
                    <p class="text-3xl font-bold">{{ $enRevision ?? 0 }}</p>
                </div>
                <i class="fas fa-edit text-3xl opacity-80"></i>
            </div>
        </div>

        <!-- Évaluées -->
        <div class="stat-card bg-gradient-to-br from-[#970d0d] to-[#7a0a0a] text-white p-5 rounded-xl shadow-xl">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm opacity-90">Évaluées</p>
                    <p class="text-3xl font-bold">{{ $evalue ?? 0 }}</p>
                </div>
                <i class="fas fa-check-double text-3xl opacity-80"></i>
            </div>
        </div>
    </div>

    <!-- Graphiques -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-lg p-6 animate-slide-in-right delay-2">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">📈 Évolution mensuelle des candidatures</h3>
            @if(isset($evolution) && count($evolution) > 0)
                <canvas id="evolutionChart" height="250"></canvas>
            @else
                <div class="text-center py-10 text-gray-500">
                    <i class="fas fa-chart-line text-4xl mb-2 text-gray-300"></i>
                    <p>Aucune donnée disponible</p>
                </div>
            @endif
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 animate-slide-in-right delay-3">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">🏆 Top offres les plus postulées</h3>
            @if(isset($offresStats) && $offresStats->count() > 0)
                <div class="space-y-3">
                    @foreach($offresStats as $offre)
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="font-medium truncate max-w-[70%]">{{ $offre->titre }}</span>
                            <span>{{ $offre->candidatures_count }} candidatures</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-[#970d0d] h-2 rounded-full" style="width: {{ $totalCandidatures ? ($offre->candidatures_count / $totalCandidatures * 100) : 0 }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-10 text-gray-500">
                    <i class="fas fa-chart-bar text-4xl mb-2 text-gray-300"></i>
                    <p>Aucune offre enregistrée</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Répartition par statut (camembert) -->
    <div class="bg-white rounded-xl shadow-lg p-6 animate-fade-in-up delay-4">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">🎯 Répartition des candidatures par statut</h3>
        @if(($enAttente ?? 0) + ($enRevision ?? 0) + ($evalue ?? 0) > 0)
            <canvas id="repartitionChart" height="200"></canvas>
        @else
            <div class="text-center py-10 text-gray-500">
                <i class="fas fa-chart-pie text-4xl mb-2 text-gray-300"></i>
                <p>Aucune candidature</p>
            </div>
        @endif
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    @if(isset($evolution) && count($evolution) > 0)
    const evolutionCtx = document.getElementById('evolutionChart')?.getContext('2d');
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
    @endif

    @if(($enAttente ?? 0) + ($enRevision ?? 0) + ($evalue ?? 0) > 0)
    const repartitionCtx = document.getElementById('repartitionChart')?.getContext('2d');
    if (repartitionCtx) {
        new Chart(repartitionCtx, {
            type: 'doughnut',
            data: {
                labels: ['En attente', 'En révision', 'Évaluées'],
                datasets: [{
                    data: [{{ $enAttente ?? 0 }}, {{ $enRevision ?? 0 }}, {{ $evalue ?? 0 }}],
                    backgroundColor: ['#f59e0b', '#3b82f6', '#14b8a6'],
                    borderWidth: 0
                }]
            },
            options: { responsive: true, maintainAspectRatio: true, cutout: '60%' }
        });
    }
    @endif
</script>
@endsection