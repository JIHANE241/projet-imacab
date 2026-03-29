@extends('layouts.admin')

@section('header', 'Paramètres')

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

    .setting-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .setting-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
</style>
@endpush

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Catégories -->
    <div class="setting-card bg-white rounded-xl shadow-lg p-6 animate-fade-in-up delay-1">
        <div class="flex items-start space-x-4">
            <div class="flex-shrink-0">
                <div class="w-12 h-12 bg-gradient-to-br from-[#970d0d] to-[#7a0a0a] rounded-lg flex items-center justify-center text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l5 5a2 2 0 01.586 1.414V19a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z" />
                    </svg>
                </div>
            </div>
            <div class="flex-1">
                <h3 class="text-lg font-semibold text-gray-800">Catégories d'offres</h3>
                <p class="text-sm text-gray-500 mt-1">Gérez les catégories (informatique, RH, finance...)</p>
                <a href="{{ route('admin.categories.index') }}" class="mt-4 inline-flex items-center text-[#970d0d] hover:text-[#7a0a0a] font-medium">
                    Gérer les catégories
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Types de contrat -->
    <div class="setting-card bg-white rounded-xl shadow-lg p-6 animate-fade-in-up delay-2">
        <div class="flex items-start space-x-4">
            <div class="flex-shrink-0">
                <div class="w-12 h-12 bg-gradient-to-br from-[#970d0d] to-[#7a0a0a] rounded-lg flex items-center justify-center text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
            </div>
            <div class="flex-1">
                <h3 class="text-lg font-semibold text-gray-800">Types de contrat</h3>
                <p class="text-sm text-gray-500 mt-1">Gérez les types de contrat (CDI, CDD, stage...)</p>
                <a href="{{ route('admin.type-contrats.index') }}" class="mt-4 inline-flex items-center text-[#970d0d] hover:text-[#7a0a0a] font-medium">
                    Gérer les types de contrat
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Niveaux d'expérience -->
    <div class="setting-card bg-white rounded-xl shadow-lg p-6 animate-fade-in-up delay-3">
        <div class="flex items-start space-x-4">
            <div class="flex-shrink-0">
                <div class="w-12 h-12 bg-gradient-to-br from-[#970d0d] to-[#7a0a0a] rounded-lg flex items-center justify-center text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>
            <div class="flex-1">
                <h3 class="text-lg font-semibold text-gray-800">Niveaux d'expérience</h3>
                <p class="text-sm text-gray-500 mt-1">Gérez les niveaux (junior, confirmé, senior...)</p>
                <a href="{{ route('admin.niveau-experiences.index') }}" class="mt-4 inline-flex items-center text-[#970d0d] hover:text-[#7a0a0a] font-medium">
                    Gérer les niveaux d'expérience
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection