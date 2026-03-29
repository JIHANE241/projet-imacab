@extends('layouts.admin')

@section('header', 'Statistiques')

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
    .delay-3 { animation-delay: 0.3s; }
    .delay-4 { animation-delay: 0.4s; }

    .stat-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    .table-row {
        transition: background-color 0.2s ease;
    }
    .table-row:hover {
        background-color: #fef2f2; /* rouge très clair */
    }

    .chart-container {
        position: relative;
        height: 280px;
        margin: 1rem 0;
    }
</style>
@endpush

@section('content')
    <!-- Graphiques -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-lg p-5 animate-fade-in-up delay-1">
            <h3 class="font-semibold text-lg mb-4 flex items-center">
                <span class="w-2 h-2 bg-[#970d0d] rounded-full mr-2"></span>
                Évolution des candidatures
            </h3>
            <div class="chart-container">
                <canvas id="candidaturesChart"></canvas>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-lg p-5 animate-fade-in-up delay-1">
            <h3 class="font-semibold text-lg mb-4 flex items-center">
                <span class="w-2 h-2 bg-[#970d0d] rounded-full mr-2"></span>
                Évolution des offres
            </h3>
            <div class="chart-container">
                <canvas id="offresChart"></canvas>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-lg p-5 animate-fade-in-up delay-2">
            <h3 class="font-semibold text-lg mb-4 flex items-center">
                <span class="w-2 h-2 bg-[#970d0d] rounded-full mr-2"></span>
                Candidatures par direction
            </h3>
            <div class="chart-container">
                <canvas id="candidaturesDirectionChart"></canvas>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-lg p-5 animate-fade-in-up delay-2">
            <h3 class="font-semibold text-lg mb-4 flex items-center">
                <span class="w-2 h-2 bg-[#970d0d] rounded-full mr-2"></span>
                Offres par direction
            </h3>
            <div class="chart-container">
                <canvas id="offresDirectionChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Tableau des statistiques par direction -->
    <div class="bg-white rounded-xl shadow-lg p-5 mb-8 animate-fade-in-up delay-4">
        <h3 class="font-semibold text-lg mb-4 flex items-center">
            <span class="w-2 h-2 bg-[#970d0d] rounded-full mr-2"></span>
            Statistiques par direction
        </h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Direction</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Offres</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Candidatures en attente</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Candidatures acceptées</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Candidatures refusées</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @foreach($statistiquesParDirection as $dir)
                    <tr class="table-row">
                        <td class="px-6 py-3 whitespace-nowrap text-sm font-medium text-gray-900">{{ $dir->nom }}</td>
                        <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-700">{{ $dir->offres_count }}</td>
                        <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-700">{{ $dir->candidatures_en_attente }}</td>
                        <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-700">{{ $dir->candidatures_acceptees }}</td>
                        <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-700">{{ $dir->candidatures_refusees }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Boutons d'export -->
    <div class="flex gap-4 animate-fade-in-up delay-4">
        <form action="{{ route('admin.statistiques.export.pdf') }}" method="POST">
            @csrf
            <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-lg hover:from-red-700 hover:to-red-800 transition-all shadow-md hover:shadow-lg flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Exporter PDF
            </button>
        </form>
        <form action="{{ route('admin.statistiques.export.excel') }}" method="POST">
            @csrf
            <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-lg hover:from-green-700 hover:to-green-800 transition-all shadow-md hover:shadow-lg flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Exporter Excel
            </button>
        </form>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Données envoyées par le contrôleur
        const candidaturesMois = @json($candidaturesParMois) || [];
        const offresMois = @json($offresParMois) || [];
        const candidaturesDirection = @json($candidaturesParDirection) || [];
        const offresDirection = @json($offresParDirection) || [];

        // Fonction pour générer une palette de couleurs distinctes
        function generateColorPalette(count, baseHue = 0, saturation = 70, lightness = 55) {
            const colors = [];
            const step = 360 / count;
            for (let i = 0; i < count; i++) {
                const hue = (baseHue + i * step) % 360;
                colors.push(`hsl(${hue}, ${saturation}%, ${lightness}%)`);
            }
            return colors;
        }

        // Configuration commune
        Chart.defaults.font.family = "'Inter', sans-serif";
        Chart.defaults.font.size = 12;

        // 1. Évolution des candidatures (ligne)
        const candCtx = document.getElementById('candidaturesChart')?.getContext('2d');
        if (candCtx) {
            new Chart(candCtx, {
                type: 'line',
                data: {
                    labels: candidaturesMois.map(item => `${item.annee}-${item.mois}`),
                    datasets: [{
                        label: 'Candidatures',
                        data: candidaturesMois.map(item => item.total),
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        borderWidth: 2,
                        pointBackgroundColor: '#3b82f6',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        tension: 0.2,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: { y: { beginAtZero: true, grid: { color: '#e2e8f0' } } }
                }
            });
        }

        // 2. Évolution des offres (ligne)
        const offCtx = document.getElementById('offresChart')?.getContext('2d');
        if (offCtx) {
            new Chart(offCtx, {
                type: 'line',
                data: {
                    labels: offresMois.map(item => `${item.annee}-${item.mois}`),
                    datasets: [{
                        label: 'Offres',
                        data: offresMois.map(item => item.total),
                        borderColor: '#10b981',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        borderWidth: 2,
                        pointBackgroundColor: '#10b981',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        tension: 0.2,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: { y: { beginAtZero: true, grid: { color: '#e2e8f0' } } }
                }
            });
        }

        // 3. Candidatures par direction (doughnut) – palette dynamique
        const candDirCtx = document.getElementById('candidaturesDirectionChart')?.getContext('2d');
        if (candDirCtx && candidaturesDirection.length > 0) {
            const palette = generateColorPalette(candidaturesDirection.length);
            new Chart(candDirCtx, {
                type: 'doughnut',
                data: {
                    labels: candidaturesDirection.map(item => item.nom),
                    datasets: [{
                        data: candidaturesDirection.map(item => item.candidatures_count),
                        backgroundColor: palette,
                        borderWidth: 0,
                        hoverOffset: 10
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '60%',
                    plugins: {
                        legend: { position: 'bottom', labels: { usePointStyle: true, font: { size: 11 } } },
                        tooltip: { callbacks: { label: (ctx) => `${ctx.label}: ${ctx.raw} candidatures` } }
                    }
                }
            });
        }

        // 4. Offres par direction (barres) – palette dynamique avec opacité
        const offDirCtx = document.getElementById('offresDirectionChart')?.getContext('2d');
        if (offDirCtx && offresDirection.length > 0) {
            const palette = generateColorPalette(offresDirection.length);
            // Ajouter de l'opacité pour les barres
            const barColors = palette.map(c => {
                if (c.startsWith('hsl')) return c.replace('hsl', 'hsla').replace(')', ', 0.7)');
                return c;
            });
            new Chart(offDirCtx, {
                type: 'bar',
                data: {
                    labels: offresDirection.map(item => item.nom),
                    datasets: [{
                        label: 'Nombre d\'offres',
                        data: offresDirection.map(item => item.offres_count),
                        backgroundColor: barColors,
                        borderColor: '#ffffff',
                        borderWidth: 1,
                        borderRadius: 6,
                        barPercentage: 0.7,
                        categoryPercentage: 0.8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, grid: { color: '#e2e8f0' }, title: { display: true, text: 'Nombre d\'offres' } },
                        x: { ticks: { autoSkip: true, maxRotation: 45, minRotation: 45 } }
                    }
                }
            });
        }
    });
</script>
@endpush