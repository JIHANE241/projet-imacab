@extends('layouts.admin')

@section('header', 'Toutes les activités')

@push('styles')
<style>
    .activity-item {
        transition: background-color 0.2s;
    }
    .activity-item:hover {
        background-color: #f9fafb;
    }
    .badge {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
    }
</style>
@endpush

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="bg-white rounded-xl shadow-lg p-6 animate-fade-in-up">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Toutes les activités</h1>
            <a href="{{ route('admin.dashboard') }}" class="text-indigo-600 hover:text-indigo-800 text-sm flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Retour au dashboard
            </a>
        </div>

        <div class="space-y-3">
            @forelse($activitesPaginated as $activite)
                <div class="activity-item flex items-center p-3 rounded-lg border border-gray-100">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center 
                        @if($activite->type == 'candidature') bg-green-100
                        @elseif($activite->type == 'offre') bg-blue-100
                        @elseif($activite->type == 'commentaire') bg-yellow-100
                        @else bg-purple-100 @endif mr-3">
                        <svg class="w-4 h-4 
                            @if($activite->type == 'candidature') text-green-600
                            @elseif($activite->type == 'offre') text-blue-600
                            @elseif($activite->type == 'commentaire') text-yellow-600
                            @else text-purple-600 @endif" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            @if($activite->type == 'candidature')
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            @elseif($activite->type == 'offre')
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            @elseif($activite->type == 'commentaire')
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                            @else
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            @endif
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm text-gray-700">{{ $activite->message }}</p>
                        <p class="text-xs text-gray-400 mt-1">{{ $activite->date->diffForHumans() }} · {{ $activite->date->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            @empty
                <div class="text-center py-8 text-gray-500 bg-gray-50 rounded-lg">
                    <svg class="w-12 h-12 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p>Aucune activité trouvée</p>
                </div>
            @endforelse
        </div>

        @if($activitesPaginated->hasPages())
            <div class="mt-6">
                {{ $activitesPaginated->links() }}
            </div>
        @endif
    </div>
</div>
@endsection