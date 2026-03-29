@extends('layouts.admin')

@section('header', 'Gestion des utilisateurs')

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
        background-color: #f9fafb;
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
    <!-- Cartes statistiques avec animations -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="stat-card bg-gradient-to-br from-indigo-600 to-indigo-700 text-white p-5 rounded-xl shadow-xl animate-fade-in-up delay-1">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium opacity-90">Administrateurs</p>
                    <p class="text-3xl font-bold">{{ $stats['admins'] }}</p>
                </div>
                <div class="bg-white/20 p-3 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-3 flex items-center text-xs">
                <span class="bg-white/30 px-2 py-1 rounded-full font-medium">Total</span>
            </div>
        </div>
        <div class="stat-card bg-gradient-to-br from-amber-600 to-amber-700 text-white p-5 rounded-xl shadow-xl animate-fade-in-up delay-2">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium opacity-90">Responsables</p>
                    <p class="text-3xl font-bold">{{ $stats['responsables'] }}</p>
                </div>
                <div class="bg-white/20 p-3 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
            </div>
            <div class="mt-3 flex items-center text-xs">
                <span class="bg-white/30 px-2 py-1 rounded-full font-medium">Actifs</span>
            </div>
        </div>
        <div class="stat-card bg-gradient-to-br from-emerald-600 to-emerald-700 text-white p-5 rounded-xl shadow-xl animate-fade-in-up delay-3">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium opacity-90">Candidats</p>
                    <p class="text-3xl font-bold">{{ $stats['candidats'] }}</p>
                </div>
                <div class="bg-white/20 p-3 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
            </div>
            <div class="mt-3 flex items-center text-xs">
                <span class="bg-white/30 px-2 py-1 rounded-full font-medium">Inscrits</span>
            </div>
        </div>
    </div>

    <!-- Barre d'outils moderne -->
    <div class="bg-white rounded-xl shadow-lg p-5 mb-8 flex flex-col md:flex-row gap-4 items-center justify-between animate-fade-in-up delay-4">
        <form method="GET" class="flex flex-wrap gap-3 w-full md:w-auto">
            <div class="relative flex-1 min-w-[200px]">
                <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input type="text" name="search" placeholder="Rechercher un utilisateur..." value="{{ request('search') }}"
                       class="pl-10 pr-4 py-2 border border-gray-200 rounded-lg w-full focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
            </div>
            <select name="role" class="border border-gray-200 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                <option value="">Tous les rôles</option>
                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="responsable" {{ request('role') == 'responsable' ? 'selected' : '' }}>Responsable</option>
                <option value="candidat" {{ request('role') == 'candidat' ? 'selected' : '' }}>Candidat</option>
            </select>
            <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition-colors shadow-md hover:shadow-lg flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                </svg>
                Filtrer
            </button>
        </form>
        <a href="{{ route('admin.utilisateurs.create') }}" class="bg-gradient-to-r from-green-500 to-green-600 text-white px-6 py-2 rounded-lg hover:from-green-600 hover:to-green-700 transition-all shadow-md hover:shadow-lg flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
            </svg>
            Nouvel utilisateur
        </a>
    </div>

    <!-- Tableau moderne -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden animate-fade-in-up delay-5">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nom</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Téléphone</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Rôle</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Inscription</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($utilisateurs as $user)
                    <tr class="table-row">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center text-white font-semibold text-sm">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}{{ strtoupper(substr($user->prenom, 0, 1)) ?? '' }}
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $user->name }} {{ $user->prenom }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $user->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $user->telephone ?? '—' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $roleClasses = [
                                    'admin' => 'bg-red-100 text-red-800 border-red-200',
                                    'responsable' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                    'candidat' => 'bg-green-100 text-green-800 border-green-200',
                                ][$user->role] ?? 'bg-gray-100 text-gray-800 border-gray-200';
                            @endphp
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full border {{ $roleClasses }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $user->created_at->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                
                                <a href="{{ route('admin.utilisateurs.edit', $user) }}" class="action-button text-amber-600 hover:text-amber-900 bg-amber-50 p-2 rounded-lg" title="Modifier">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                <form action="{{ route('admin.utilisateurs.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer cet utilisateur ?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="action-button text-red-600 hover:text-red-900 bg-red-50 p-2 rounded-lg" title="Supprimer">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                            </svg>
                            <p class="mt-2 text-sm">Aucun utilisateur trouvé.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($utilisateurs->hasPages())
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
            {{ $utilisateurs->links() }}
        </div>
        @endif
    </div>
@endsection