<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>IMACAB – Carrières et recrutement</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .hero {
            background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('/images/1.jpg') center/cover;
            background-size: cover;
        }
        .btn-primary {
            background-color: #970d0d;
            transition: all 0.2s;
        }
        .btn-primary:hover {
            background-color: #7a0a0a;
            transform: translateY(-2px);
        }
        .direction-card {
             transition: transform 0.3s ease;
            cursor: pointer;
        }
        .direction-card:hover {
             transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1);
        }
        .direction-card .bg-black\/50 {
        transition: background-color 0.3s ease;
    }
        .offer-card {
            transition: all 0.2s;
        }
        .offer-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body class="bg-gray-50">

    <!-- Navbar -->
    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <img src="{{ asset('images/image1.png') }}" alt="IMACAB" class="h-12">
                <span class="text-xl font-bold text-gray-800">IMACAB</span>
            </div>
            <div class="hidden md:flex space-x-8">
                <a href="#accueil" class="text-gray-700 hover:text-[#970d0d]">Accueil</a>
                <a href="#a-propos" class="text-gray-700 hover:text-[#970d0d]">À propos</a>
                <a href="#directions" class="text-gray-700 hover:text-[#970d0d]">Nos métiers</a>
                <a href="#offres" class="text-gray-700 hover:text-[#970d0d]">Offres</a>
                <a href="#contact" class="text-gray-700 hover:text-[#970d0d]">Contact</a>
            </div>
            <div class="space-x-3">
                @guest
                    <a href="{{ route('login') }}" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-100 transition">Connexion</a>
                    <a href="{{ route('register') }}" class="px-4 py-2 bg-[#970d0d] text-white rounded-lg hover:bg-[#7a0a0a] transition">Inscription</a>
                @else
                    @if(Auth::user()->role == 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 bg-[#970d0d] text-white rounded-lg hover:bg-[#7a0a0a] transition">Dashboard Admin</a>
                    @elseif(Auth::user()->role == 'responsable')
                        <a href="{{ route('responsable.dashboard') }}" class="px-4 py-2 bg-[#970d0d] text-white rounded-lg hover:bg-[#7a0a0a] transition">Dashboard Responsable</a>
                    @else
                        <a href="{{ route('candidat.dashboard') }}" class="px-4 py-2 bg-[#970d0d] text-white rounded-lg hover:bg-[#7a0a0a] transition">Mon espace</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-100 transition">Déconnexion</button>
                    </form>
                @endguest
            </div>
        </div>
    </nav>

    <!-- Hero Section avec Carrousel -->
<section id="accueil" class="relative h-screen overflow-hidden">
    <!-- Conteneur des slides -->
    <div id="slider" class="relative h-full w-full">
        <div class="slide absolute inset-0 w-full h-full opacity-0 transition-opacity duration-1000 ease-in-out">
            <img src="{{ asset('images/1.jpg') }}" alt="IMACAB 1" class="w-full h-full object-cover">
        </div>
        <div class="slide absolute inset-0 w-full h-full opacity-0 transition-opacity duration-1000 ease-in-out">
            <img src="{{ asset('images/2.jpg') }}" alt="IMACAB 2" class="w-full h-full object-cover">
        </div>
        <div class="slide absolute inset-0 w-full h-full opacity-0 transition-opacity duration-1000 ease-in-out">
            <img src="{{ asset('images/3.jpg') }}" alt="IMACAB 3" class="w-full h-full object-cover">
        </div>
    </div>

    <!-- Overlay (assombrit les images pour le texte) -->
    <div class="absolute inset-0 bg-black/50 z-10"></div>

    <!-- Texte centré -->
    <div class="absolute inset-0 flex items-center justify-center text-center text-white z-20 px-4">
        <div>
            <h1 class="text-5xl md:text-6xl font-bold mb-4">Rejoignez l’excellence industrielle</h1>
            <p class="text-xl mb-8 max-w-2xl mx-auto">IMACAB, leader mondial du câblage automobile, recrute ses talents dans toutes ses directions.</p>
            <a href="#offres" class="bg-[#970d0d] text-white px-8 py-3 rounded-full text-lg font-semibold inline-block transition hover:bg-[#7a0a0a] hover:-translate-y-1">Découvrir nos offres</a>
        </div>
    </div>

    <!-- Flèches de navigation -->
    <button id="prevBtn" class="absolute left-4 top-1/2 -translate-y-1/2 z-30 bg-white/30 hover:bg-white/50 text-white p-3 rounded-full transition">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
        </svg>
    </button>
    <button id="nextBtn" class="absolute right-4 top-1/2 -translate-y-1/2 z-30 bg-white/30 hover:bg-white/50 text-white p-3 rounded-full transition">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
        </svg>
    </button>

    <!-- Points indicateurs -->
    <div class="absolute bottom-6 left-1/2 -translate-x-1/2 z-30 flex space-x-3">
        <div class="dot w-3 h-3 rounded-full bg-white/60 cursor-pointer transition"></div>
        <div class="dot w-3 h-3 rounded-full bg-white/60 cursor-pointer transition"></div>
        <div class="dot w-3 h-3 rounded-full bg-white/60 cursor-pointer transition"></div>
    </div>
</section>

    <!-- À propos d’IMACAB – Version texte + image -->
<section id="a-propos" class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">À propos d’IMACAB</h2>
        <div class="flex flex-col md:flex-row items-center gap-12">
            <!-- Texte à gauche -->
            <div class="md:w-1/2">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">IMACAB . SA</h2>
                <p class="text-gray-600 mb-4 text-lg font-semibold">Fabrication de câbles électriques</p>
                <p class="text-gray-600 mb-4">
                    Pari réussi pour <span class="font-semibold text-[#970d0d]">INGELEC</span> !<br>
                    Désormais leader du secteur des câbles électriques au Maroc, l’usine de câbles <span class="font-semibold">IMACAB</span> ambitionne de consolider sa position afin de confirmer son leadership.
                </p>
                <p class="text-gray-600 mb-4">
                    Les câbles pour énergies renouvelables, les câbles sans halogène, les câbles anti‑feu, les câbles spéciaux ainsi que les câbles à spécifications anglo‑saxonnes et internationales représentent de nouveaux challenges permettant à <span class="font-semibold">INGELEC</span> d’augmenter ses parts de marché locales et de pénétrer de nouveaux marchés à l’international.
                </p>
                <div class="bg-gray-50 p-4 rounded-lg border-l-4 border-[#970d0d] mt-4">
                    <p class="text-gray-700 italic">
                        « Grâce à sa flexibilité à toute épreuve, à la qualité reconnue de ses câbles et à des investissements ciblés et cohérents, INGELEC est devenu un acteur incontournable dans l’industrie de la téléphonie. »
                    </p>
                    <p class="text-right text-sm text-gray-500 mt-2">— Groupe INGELEC</p>
                </div>
            </div>

            <!-- Image à droite -->
            <div class="md:w-1/2">
                <img src="{{ asset('images/4.jpeg') }}" alt="Usine IMACAB"
                     class="w-full rounded-xl shadow-lg object-cover h-80 md:h-96 hover:scale-105 transition-transform duration-500">
            </div>
        </div>
    </div>
</section>

    <!-- Nos Directions (cartes avec images de fond) -->
<section id="directions" class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">Nos domaines d’expertise</h2>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($directions as $direction)
            <div class="direction-card rounded-xl shadow-lg overflow-hidden cursor-pointer relative group h-64"
                 data-direction-id="{{ $direction->id }}"
                 style="background-image: url('{{ $direction->image_url ?? asset('images/directions/default.jpg') }}'); background-size: cover; background-position: center;">
                <!-- Overlay sombre pour lisibilité -->
                <div class="absolute inset-0 bg-black/50 group-hover:bg-black/40 transition-all duration-300"></div>
                <!-- Contenu centré -->
                <div class="relative z-10 flex flex-col items-center justify-center h-full text-white text-center p-6">
                    <h3 class="text-2xl font-bold mb-2">{{ $direction->nom }}</h3>
                    <p class="text-sm font-medium bg-white/20 px-3 py-1 rounded-full inline-block">{{ $direction->offres_count }} offre(s)</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

    <!-- Offres d’emploi (dynamique + dernières offres) -->
    <section id="offres" class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-4">Dernières offres publiées</h2>
            <!-- Dernières offres (section séparée) -->
            <div class="mt-16 pt-8 border-t border-gray-200">
                
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($dernieresOffres as $offre)
                    <div class="offer-card bg-white rounded-xl shadow-md p-5 border border-gray-100">
                        <div class="flex items-start justify-between">
                            <div>
                                <h4 class="text-lg font-bold text-gray-800">{{ $offre->titre }}</h4>
                                <p class="text-sm text-gray-500 mt-1">{{ $offre->direction->nom }}</p>
                            </div>
                            <span class="badge bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full">Nouveau</span>
                        </div>
                        <div class="mt-3 text-sm text-gray-600">
                            <p><i class="fas fa-briefcase mr-1"></i> {{ $offre->typeContrat->nom ?? 'CDI' }}</p>
                            <p><i class="fas fa-map-marker-alt mr-1"></i> {{ $offre->ville->nom ?? 'Maroc' }}</p>
                            <p><i class="fas fa-calendar-alt mr-1"></i> Publiée le {{ $offre->date_publication->format('d/m/Y') }}</p>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('candidat.offres.show', $offre) }}" class="text-[#970d0d] hover:text-[#7a0a0a] font-medium text-sm flex items-center">
                                Voir le détail <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="text-center mt-8">
                    <a href="{{ route('candidat.offres.index') }}" class="inline-block px-6 py-3 bg-[#970d0d] text-white rounded-lg hover:bg-[#7a0a0a] transition">Voir toutes les offres</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer amélioré -->
<footer id="contact" class="bg-gray-900 text-gray-300 py-12 border-t border-gray-800">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Colonne 1 : Logo et adresse -->
            <div>
                <div class="flex items-center space-x-3 mb-4">
                    <img src="{{ asset('images/image.png') }}" alt="IMACAB" class="h-12 w-auto">
                    <span class="text-xl font-bold text-white">IMACAB</span>
                </div>
                <p class="text-sm leading-relaxed">
                    Bd Ahl Loghlam, Q.I. Sidi Moumen 20630<br>
                    Casablanca - Maroc
                </p>
                <div class="mt-4 space-y-2 text-sm">
                    <p><i class="fas fa-phone-alt w-5 text-[#970d0d]"></i> +212 (05) 22 76 40 00 / 20 / 40</p>
                    <p><i class="fas fa-fax w-5 text-[#970d0d]"></i> +212 (05) 22 76 40 10</p>
                    <p><i class="fas fa-envelope w-5 text-[#970d0d]"></i> imacab@imacab.ma</p>
                </div>
            </div>

            <!-- Colonne 2 : Liens utiles -->
            <div>
                <h4 class="text-lg font-semibold text-white mb-4">Liens utiles</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="#directions" class="hover:text-[#970d0d] transition">Nos métiers</a></li>
                    <li><a href="#a-propos" class="hover:text-[#970d0d] transition">À propos</a></li>
                    <li><a href="#offres" class="hover:text-[#970d0d] transition">Offres</a></li>
                    <li><a href="#contact" class="hover:text-[#970d0d] transition">Contactez‑nous</a></li>
                </ul>
            </div>

            <!-- Colonne 3 : Newsletter -->
            <div>
                <h4 class="text-lg font-semibold text-white mb-4">Newsletter</h4>
                <p class="text-sm mb-3">Recevez nos dernières offres d’emploi</p>
                <form action="#" method="POST" class="flex flex-col sm:flex-row gap-2">
                    <input type="email" placeholder="Votre email" class="flex-1 px-4 py-2 rounded-lg bg-gray-800 border border-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-[#970d0d]">
                    <button type="submit" class="bg-[#970d0d] hover:bg-[#7a0a0a] px-5 py-2 rounded-lg transition">S’abonner</button>
                </form>
            </div>

            <!-- Colonne 4 : Réseaux sociaux -->
            <div>
                <h4 class="text-lg font-semibold text-white mb-4">Suivez‑nous</h4>
                <div class="flex space-x-4">
                    <a href="#" class="text-2xl hover:text-[#970d0d] transition"><i class="fab fa-linkedin"></i></a>
                    <a href="#" class="text-2xl hover:text-[#970d0d] transition"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="text-2xl hover:text-[#970d0d] transition"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-2xl hover:text-[#970d0d] transition"><i class="fab fa-instagram"></i></a>
                </div>
                <div class="mt-6">
                    <p class="text-sm">Restez connecté pour ne rien manquer !</p>
                </div>
            </div>
        </div>

        <!-- Bas de page (copyright) -->
        <div class="text-center border-t border-gray-800 mt-10 pt-6 text-sm text-gray-500">
            &copy; {{ date('Y') }} IMACAB .
        </div>
    </div>
</footer>
<!-- Modal pour afficher les offres d'une direction -->
<div id="modal" class="fixed inset-0 z-50 hidden items-center justify-center" style="background-color: rgba(0,0,0,0.7); backdrop-filter: blur(8px);">
    <div class="bg-white rounded-2xl shadow-2xl w-11/12 md:w-3/4 lg:w-2/3 max-h-[80vh] overflow-auto transform transition-all duration-300 scale-95" id="modal-content">
        <div class="sticky top-0 bg-white border-b p-4 flex justify-between items-center">
            <h3 class="text-xl font-bold" id="modal-title"></h3>
            <button id="close-modal" class="text-gray-500 hover:text-gray-800 text-2xl">&times;</button>
        </div>
        <div id="modal-body" class="p-6">
            <!-- Les offres seront injectées ici -->
        </div>
    </div>
</div>

    <script>
    // --- Gestion de la modal pour les offres par direction ---
    const modal = document.getElementById('modal');
    const modalTitle = document.getElementById('modal-title');
    const modalBody = document.getElementById('modal-body');
    const closeModalBtn = document.getElementById('close-modal');

    // Fermer la modal
    function closeModal() {
        // Réinitialiser l'animation de zoom
        const modalContent = document.querySelector('#modal-content');
        modalContent.classList.remove('scale-100');
        modalContent.classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = 'auto';
        }, 200);
    }

    // Ouvrir la modal
    function openModal() {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
        // Animation de zoom
        const modalContent = document.querySelector('#modal-content');
        modalContent.classList.remove('scale-95');
        modalContent.classList.add('scale-100');
    }

    // Écouteur de fermeture
    closeModalBtn.addEventListener('click', closeModal);
    modal.addEventListener('click', (e) => {
        if (e.target === modal) closeModal();
    });

    // Clic sur une direction
    const directionCards = document.querySelectorAll('.direction-card');
    directionCards.forEach(card => {
        card.addEventListener('click', () => {
            const directionId = card.getAttribute('data-direction-id');
            const directionName = card.querySelector('h3')?.innerText || 'Direction';
            modalTitle.innerText = `Offres - ${directionName}`;
            modalBody.innerHTML = '<div class="text-center py-10"><i class="fas fa-spinner fa-spin text-2xl text-[#970d0d]"></i> Chargement...</div>';
            openModal();

            fetch(`/api/offres/direction/${directionId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.length === 0) {
                        modalBody.innerHTML = '<p class="text-gray-500 text-center">Aucune offre pour cette direction.</p>';
                        return;
                    }
                    let html = '<div class="grid grid-cols-1 md:grid-cols-2 gap-6">';
                    data.forEach(offre => {
                        html += `
                            <div class="offer-card bg-white rounded-xl shadow-md p-5 border border-gray-100">
                                <div class="flex items-start justify-between">
                                    <div>
                                        <h4 class="text-lg font-bold text-gray-800">${offre.titre}</h4>
                                        <p class="text-sm text-gray-500 mt-1">${offre.direction.nom}</p>
                                    </div>
                                    <span class="badge bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full">Nouveau</span>
                                </div>
                                <div class="mt-3 text-sm text-gray-600">
                                    <p><i class="fas fa-briefcase mr-1"></i> ${offre.type_contrat ? offre.type_contrat.nom : 'CDI'}</p>
                                    <p><i class="fas fa-map-marker-alt mr-1"></i> ${offre.ville ? offre.ville.nom : 'Maroc'}</p>
                                    <p><i class="fas fa-calendar-alt mr-1"></i> Publiée le ${new Date(offre.date_publication).toLocaleDateString('fr-FR')}</p>
                                </div>
                                <div class="mt-4">
                                    <a href="/candidat/offres/${offre.id}" class="text-[#970d0d] hover:text-[#7a0a0a] font-medium text-sm flex items-center">
                                        Voir le détail <i class="fas fa-arrow-right ml-1"></i>
                                    </a>
                                </div>
                            </div>
                        `;
                    });
                    html += '</div>';
                    modalBody.innerHTML = html;
                })
                .catch(error => {
                    console.error(error);
                    modalBody.innerHTML = '<p class="text-red-500 text-center">Erreur lors du chargement des offres.</p>';
                });
        });
    });
</script>

    <script>
    const slides = document.querySelectorAll('.slide');
    const dots = document.querySelectorAll('.dot');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    let currentIndex = 0;
    let interval;

    function showSlide(index) {
        slides.forEach((slide, i) => {
            slide.classList.toggle('opacity-0', i !== index);
            slide.classList.toggle('opacity-100', i === index);
        });
        dots.forEach((dot, i) => {
            dot.classList.toggle('bg-white', i === index);
            dot.classList.toggle('bg-white/60', i !== index);
        });
        currentIndex = index;
    }

    function nextSlide() {
        let newIndex = currentIndex + 1;
        if (newIndex >= slides.length) newIndex = 0;
        showSlide(newIndex);
    }

    function prevSlide() {
        let newIndex = currentIndex - 1;
        if (newIndex < 0) newIndex = slides.length - 1;
        showSlide(newIndex);
    }

    function startAutoSlide() {
        interval = setInterval(nextSlide, 4000);
    }

    function stopAutoSlide() {
        clearInterval(interval);
    }

    // Événements manuels
    nextBtn.addEventListener('click', () => {
        stopAutoSlide();
        nextSlide();
        startAutoSlide();
    });
    prevBtn.addEventListener('click', () => {
        stopAutoSlide();
        prevSlide();
        startAutoSlide();
    });

    dots.forEach((dot, i) => {
        dot.addEventListener('click', () => {
            stopAutoSlide();
            showSlide(i);
            startAutoSlide();
        });
    });

    // Démarrage
    showSlide(0);
    startAutoSlide();

   
    const sliderContainer = document.getElementById('slider');
    sliderContainer.addEventListener('mouseenter', stopAutoSlide);
    sliderContainer.addEventListener('mouseleave', startAutoSlide);
</script>
</body>
</html>