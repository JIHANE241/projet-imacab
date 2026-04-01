@extends('layouts.admin')

@section('header', 'Archives')

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

    .tab-button {
        transition: all 0.2s ease;
    }
    .tab-button.active {
        color: #970d0d;
        border-bottom-color: #970d0d;
    }

    .table-row {
        transition: background-color 0.2s ease;
    }
    .table-row:hover {
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
<div class="bg-white rounded-xl shadow-lg p-6 animate-fade-in-up delay-1">
    <!-- Onglets -->
    <div class="border-b border-gray-200">
        <nav class="flex flex-wrap -mb-px space-x-6">
            <button class="tab-button active py-2 px-1 text-sm font-medium border-b-2 border-[#970d0d] text-[#970d0d] focus:outline-none" id="tab-cv">
                CV refusés
            </button>
            <button class="tab-button py-2 px-1 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700 focus:outline-none" id="tab-offres-fermees">
                Offres fermées
            </button>
            <button class="tab-button py-2 px-1 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700 focus:outline-none" id="tab-offres-supprimees">
                Offres supprimées
            </button>
            <button class="tab-button py-2 px-1 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700 focus:outline-none" id="tab-candidatures-refusees">
                Candidatures refusées
            </button>
        </nav>
    </div>

    <!-- Contenu des onglets -->
    <div class="mt-6">
        <!-- CV refusés -->
        <div id="content-cv">
            <h3 class="text-lg font-semibold mb-4 flex items-center">
                <span class="w-2 h-2 bg-[#970d0d] rounded-full mr-2"></span>
                CV refusés
            </h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Candidat</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Offre</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">CV</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($cvRefuses as $c)
                        <tr class="table-row">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $c->candidat->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $c->offre->titre }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                <a href="{{ route('admin.candidatures.cv', $c->id) }}" target="_blank" class="text-indigo-600 hover:text-indigo-900 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                    Télécharger
                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <form action="{{ route('admin.archives.supprimer', ['type' => 'candidature', 'id' => $c->id]) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer définitivement ?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="action-button text-red-600 hover:text-red-900 bg-red-50 p-2 rounded-lg" title="Supprimer définitivement">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-gray-500">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <p class="mt-2 text-sm">Aucun CV refusé.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Offres fermées -->
        <div id="content-offres-fermees" class="hidden">
            <h3 class="text-lg font-semibold mb-4 flex items-center">
                <span class="w-2 h-2 bg-[#970d0d] rounded-full mr-2"></span>
                Offres fermées
            </h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Titre</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Direction</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date fermeture</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($offresFermees as $o)
                        <tr class="table-row">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $o->titre }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $o->direction->nom }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $o->updated_at->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <form action="{{ route('admin.offres.ouvrir', $o->id) }}" method="POST" class="inline" onsubmit="return confirm('Ouvrir cette offre ?')">
                                    @csrf
                                    <button type="submit" class="action-button text-green-600 hover:text-green-900 bg-green-50 p-2 rounded-lg" title="Ouvrir">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-gray-500">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                </svg>
                                <p class="mt-2 text-sm">Aucune offre fermée.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Offres supprimées -->
        <div id="content-offres-supprimees" class="hidden">
            <h3 class="text-lg font-semibold mb-4 flex items-center">
                <span class="w-2 h-2 bg-[#970d0d] rounded-full mr-2"></span>
                Offres supprimées
            </h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Titre</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Direction</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date suppression</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($offresSupprimees as $o)
                        <tr class="table-row">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $o->titre }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $o->direction->nom }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $o->deleted_at->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <form action="{{ route('admin.archives.restaurer', ['type' => 'offre', 'id' => $o->id]) }}" method="POST" class="inline" onsubmit="return confirm('Restaurer cette offre ?')">
                                    @csrf
                                    <button type="submit" class="action-button text-green-600 hover:text-green-900 bg-green-50 p-2 rounded-lg" title="Restaurer">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                        </svg>
                                    </button>
                                </form>
                                <form action="{{ route('admin.archives.supprimer', ['type' => 'offre', 'id' => $o->id]) }}" method="POST" class="inline ml-2" onsubmit="return confirm('Supprimer définitivement cette offre ?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="action-button text-red-600 hover:text-red-900 bg-red-50 p-2 rounded-lg" title="Supprimer définitivement">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-gray-500">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                <p class="mt-2 text-sm">Aucune offre supprimée.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Candidatures refusées -->
        <div id="content-candidatures-refusees" class="hidden">
            <h3 class="text-lg font-semibold mb-4 flex items-center">
                <span class="w-2 h-2 bg-[#970d0d] rounded-full mr-2"></span>
                Candidatures refusées
            </h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Candidat</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Offre</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date refus</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($candidaturesRefusees as $c)
                        <tr class="table-row">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $c->candidat->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $c->offre->titre }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $c->updated_at->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <form action="{{ route('admin.archives.restaurer', ['type' => 'candidature', 'id' => $c->id]) }}" method="POST" class="inline" onsubmit="return confirm('Restaurer cette candidature ?')">
                                    @csrf
                                    <button type="submit" class="action-button text-green-600 hover:text-green-900 bg-green-50 p-2 rounded-lg" title="Restaurer">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                        </svg>
                                    </button>
                                </form>
                                <form action="{{ route('admin.archives.supprimer', ['type' => 'candidature', 'id' => $c->id]) }}" method="POST" class="inline ml-2" onsubmit="return confirm('Supprimer définitivement cette candidature ?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="action-button text-red-600 hover:text-red-900 bg-red-50 p-2 rounded-lg" title="Supprimer définitivement">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-gray-500">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <p class="mt-2 text-sm">Aucune candidature refusée.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    function switchTab(tabId) {
        
        document.querySelectorAll('[id^="content-"]').forEach(el => el.classList.add('hidden'));
        
        document.querySelectorAll('.tab-button').forEach(btn => {
            btn.classList.remove('active', 'border-[#970d0d]', 'text-[#970d0d]');
            btn.classList.add('border-transparent', 'text-gray-500');
        });

        
        document.getElementById('content-' + tabId).classList.remove('hidden');
        
        const activeBtn = document.getElementById('tab-' + tabId);
        activeBtn.classList.add('active', 'border-[#970d0d]', 'text-[#970d0d]');
        activeBtn.classList.remove('border-transparent', 'text-gray-500');
    }

    document.getElementById('tab-cv').addEventListener('click', () => switchTab('cv'));
    document.getElementById('tab-offres-fermees').addEventListener('click', () => switchTab('offres-fermees'));
    document.getElementById('tab-offres-supprimees').addEventListener('click', () => switchTab('offres-supprimees'));
    document.getElementById('tab-candidatures-refusees').addEventListener('click', () => switchTab('candidatures-refusees'));
    switchTab('cv');
</script>
@endsection