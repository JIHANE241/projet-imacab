@extends('layouts.admin')

@section('header', 'Mon profil')

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

    .input-icon {
        transition: all 0.2s ease;
    }
    .input-icon:focus-within {
        border-color: #970d0d;
        box-shadow: 0 0 0 3px rgba(151, 13, 13, 0.2);
    }

    .profile-photo {
        transition: all 0.3s ease;
    }
    .profile-photo:hover {
        transform: scale(1.05);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
</style>
@endpush

@section('content')
<div class="max-w-3xl mx-auto space-y-8">
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded-lg shadow-md animate-fade-in-up delay-1">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    <!-- Carte Informations personnelles -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden animate-fade-in-up delay-1">
        <div class="bg-gradient-to-r from-[#970d0d] to-[#7a0a0a] px-6 py-5">
            <h2 class="text-xl font-bold text-white flex items-center">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                Informations personnelles
            </h2>
            <p class="text-red-100 text-sm mt-1">Mettez à jour vos coordonnées</p>
        </div>
        <div class="p-6">
            <form method="POST" action="{{ route('admin.profil.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nom -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nom <span class="text-red-500">*</span></label>
                        <div class="relative input-icon border border-gray-200 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                                   class="pl-10 pr-4 py-2 w-full border-0 focus:ring-0 focus:outline-none">
                        </div>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Prénom -->
                    <div>
                        <label for="prenom" class="block text-sm font-medium text-gray-700 mb-1">Prénom</label>
                        <div class="relative input-icon border border-gray-200 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <input type="text" name="prenom" id="prenom" value="{{ old('prenom', $user->prenom) }}"
                                   class="pl-10 pr-4 py-2 w-full border-0 focus:ring-0 focus:outline-none">
                        </div>
                    </div>
                </div>

                <!-- Email -->
                <div class="mt-6">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
                    <div class="relative input-icon border border-gray-200 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                               class="pl-10 pr-4 py-2 w-full border-0 focus:ring-0 focus:outline-none">
                    </div>
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Téléphone -->
                <div class="mt-6">
                    <label for="telephone" class="block text-sm font-medium text-gray-700 mb-1">Téléphone</label>
                    <div class="relative input-icon border border-gray-200 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </div>
                        <input type="text" name="telephone" id="telephone" value="{{ old('telephone', $user->telephone) }}"
                               class="pl-10 pr-4 py-2 w-full border-0 focus:ring-0 focus:outline-none"
                               placeholder="+212 6 12 34 56 78">
                    </div>
                </div>

                <!-- Photo -->
                <div class="mt-6">
                    <label for="photo" class="block text-sm font-medium text-gray-700 mb-1">Photo de profil</label>
                    <div class="flex items-center space-x-6">
                        <div class="relative">
                            @if($user->photo)
                                <img src="{{ Storage::url($user->photo) }}" alt="Photo" class="profile-photo h-20 w-20 rounded-full object-cover border-2 border-gray-200 shadow-md">
                            @else
                                <div class="profile-photo h-20 w-20 rounded-full bg-gradient-to-br from-[#970d0d] to-[#7a0a0a] flex items-center justify-center text-white text-2xl font-bold shadow-md">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}{{ strtoupper(substr($user->prenom ?? '', 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        <div class="flex-1">
                            <input type="file" id="photo" name="photo" accept="image/*"
                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-[#970d0d]/10 file:text-[#970d0d] hover:file:bg-[#970d0d]/20 transition">
                        </div>
                    </div>
                    @error('photo')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-8 flex justify-end">
                    <button type="submit"
                            class="px-6 py-2.5 bg-gradient-to-r from-[#970d0d] to-[#7a0a0a] text-white rounded-lg hover:from-[#7a0a0a] hover:to-[#5f0808] transition-all shadow-md hover:shadow-lg flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Carte Changer le mot de passe -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden animate-fade-in-up delay-2">
        <div class="bg-gradient-to-r from-gray-700 to-gray-800 px-6 py-5">
            <h2 class="text-xl font-bold text-white flex items-center">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
                Changer le mot de passe
            </h2>
        </div>
        <div class="p-6">
            <form method="POST" action="{{ route('admin.profil.password') }}">
                @csrf
                @method('PATCH')

                <!-- Mot de passe actuel -->
                <div>
                    <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Mot de passe actuel <span class="text-red-500">*</span></label>
                    <div class="relative input-icon border border-gray-200 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <input type="password" name="current_password" id="current_password" required
                               class="pl-10 pr-4 py-2 w-full border-0 focus:ring-0 focus:outline-none">
                    </div>
                    @error('current_password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nouveau mot de passe -->
                <div class="mt-6">
                    <label for="new_password" class="block text-sm font-medium text-gray-700 mb-1">Nouveau mot de passe <span class="text-red-500">*</span></label>
                    <div class="relative input-icon border border-gray-200 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <input type="password" name="new_password" id="new_password" required
                               class="pl-10 pr-4 py-2 w-full border-0 focus:ring-0 focus:outline-none">
                    </div>
                </div>

                <!-- Confirmation -->
                <div class="mt-6">
                    <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirmation <span class="text-red-500">*</span></label>
                    <div class="relative input-icon border border-gray-200 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <input type="password" name="new_password_confirmation" id="new_password_confirmation" required
                               class="pl-10 pr-4 py-2 w-full border-0 focus:ring-0 focus:outline-none">
                    </div>
                </div>

                <!-- Conseil de sécurité -->
                <div class="mt-4 p-4 bg-blue-50 rounded-lg border border-blue-100 flex items-start">
                    <svg class="w-5 h-5 text-blue-500 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-sm text-blue-800">
                        <span class="font-medium">Conseil :</span> Utilisez au moins 8 caractères avec des lettres majuscules, minuscules, chiffres et symboles.
                    </p>
                </div>

                <div class="mt-8 flex justify-end">
                    <button type="submit"
                            class="px-6 py-2.5 bg-gradient-to-r from-gray-600 to-gray-700 text-white rounded-lg hover:from-gray-700 hover:to-gray-800 transition-all shadow-md hover:shadow-lg flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        Changer le mot de passe
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection