<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Public\OffreController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UtilisateurController;
use App\Http\Controllers\Admin\DirectionController;
use App\Http\Controllers\Admin\OffreController as AdminOffreController;
use App\Http\Controllers\Admin\CandidatureController as AdminCandidatureController;
use App\Http\Controllers\Admin\EntretienController as AdminEntretienController;
use App\Http\Controllers\Admin\StatistiqueController as AdminStatistiqueController;
use App\Http\Controllers\Admin\ArchiveController;
use App\Http\Controllers\Admin\ParametreController;
use App\Http\Controllers\Admin\ProfilController as AdminProfilController;

// Import des contrôleurs responsable avec alias
use App\Http\Controllers\Responsable\DashboardController as ResponsableDashboardController;
use App\Http\Controllers\Responsable\OffreController as ResponsableOffreController;
use App\Http\Controllers\Responsable\CandidatureController as ResponsableCandidatureController;
use App\Http\Controllers\Responsable\EntretienController as ResponsableEntretienController;
use App\Http\Controllers\Responsable\CandidatController as ResponsableCandidatController;
use App\Http\Controllers\Responsable\StatistiqueController as ResponsableStatistiqueController;
use App\Http\Controllers\Responsable\ProfilController as ResponsableProfilController;

// Routes publiques
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/api/offres/direction/{id}', [HomeController::class, 'offresParDirection'])->name('api.offres.direction');
Route::get('offres/{slug}', [OffreController::class, 'show'])->name('public.offres.show');
Route::get('login-with-intended', function (Request $request) {
    if ($request->has('intended')) {
        session(['url.intended' => $request->query('intended')]);
    }
    return redirect()->route('login');
})->name('login.with.intended');

// Routes admin
Route::middleware(['auth', 'verified'])->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Utilisateurs
        Route::resource('utilisateurs', UtilisateurController::class);
        Route::post('/utilisateurs/{user}/valider', [UtilisateurController::class, 'valider'])->name('utilisateurs.valider');
        Route::post('/utilisateurs/{user}/rejeter', [UtilisateurController::class, 'rejeter'])->name('utilisateurs.rejeter');

        // Directions
        Route::resource('directions', DirectionController::class);

        // Offres (utilisation du slug pour la vue)
        Route::resource('offres', AdminOffreController::class)->except(['show']);
        Route::get('offres/{slug}', [AdminOffreController::class, 'show'])->name('offres.show');
        Route::post('/offres/{offre}/fermer', [AdminOffreController::class, 'fermer'])->name('offres.fermer');
        Route::get('/offres/direction/{direction}', [AdminOffreController::class, 'parDirection'])->name('offres.parDirection');
        Route::post('/offres/{offre}/valider', [AdminOffreController::class, 'valider'])->name('offres.valider');
        Route::post('offres/{offre}/ouvrir', [App\Http\Controllers\Admin\OffreController::class, 'ouvrir'])->name('offres.ouvrir');
        Route::get('admin/offres/{offre}', [OffreController::class, 'show'])->name('admin.offres.show');
        // Candidatures
        Route::resource('candidatures', AdminCandidatureController::class);
        Route::post('/candidatures/{candidature}/accepter', [AdminCandidatureController::class, 'accepter'])->name('candidatures.accepter');
        Route::post('/candidatures/{candidature}/refuser', [AdminCandidatureController::class, 'refuser'])->name('candidatures.refuser');
        Route::get('/candidatures/{candidature}/cv', [AdminCandidatureController::class, 'voirCv'])->name('candidatures.cv');
        Route::get('/candidatures/direction/{direction}', [AdminCandidatureController::class, 'parDirection'])->name('candidatures.parDirection');
        Route::post('candidatures/{candidature}/statut', [App\Http\Controllers\Admin\CandidatureController::class, 'updateStatut'])->name('candidatures.updateStatut');
        
        // Entretiens
        Route::resource('entretiens', AdminEntretienController::class);

        // Statistiques
        Route::get('/statistiques', [AdminStatistiqueController::class, 'index'])->name('statistiques.index');
        Route::post('/statistiques/export-pdf', [AdminStatistiqueController::class, 'exportPdf'])->name('statistiques.export.pdf');
        Route::post('/statistiques/export-excel', [AdminStatistiqueController::class, 'exportExcel'])->name('statistiques.export.excel');

        // Archives
        Route::get('/archives', [ArchiveController::class, 'index'])->name('archives.index');
        Route::post('/archives/restaurer/{type}/{id}', [ArchiveController::class, 'restaurer'])->name('archives.restaurer');
        Route::delete('/archives/supprimer-definitivement/{type}/{id}', [ArchiveController::class, 'supprimerDefinitivement'])->name('archives.supprimer');

        // Paramètres
        Route::get('/parametres', [ParametreController::class, 'index'])->name('parametres.index');
        Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class)->except(['show']);
        Route::resource('type-contrats', \App\Http\Controllers\Admin\TypeContratController::class)->except(['show']);
        Route::resource('niveau-experiences', \App\Http\Controllers\Admin\NiveauExperienceController::class)->except(['show']);

        // Profil
        Route::get('/profil', [AdminProfilController::class, 'edit'])->name('profil.edit');
        Route::patch('/profil', [AdminProfilController::class, 'update'])->name('profil.update');
        Route::patch('/profil/mot-de-passe', [AdminProfilController::class, 'updatePassword'])->name('profil.password');

        // Activités
        Route::get('activites', [App\Http\Controllers\Admin\ActiviteController::class, 'index'])->name('activites.index');
    });
});

// Routes candidat
Route::middleware(['auth', 'role:candidat'])->prefix('candidat')->name('candidat.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Candidat\DashboardController::class, 'index'])->name('dashboard');
    Route::get('offres', [App\Http\Controllers\Candidat\OffreController::class, 'index'])->name('offres.index');
    Route::get('offres/{slug}', [App\Http\Controllers\Candidat\OffreController::class, 'show'])->name('offres.show');
    Route::post('offres/{offre:slug}/postuler', [App\Http\Controllers\Candidat\OffreController::class, 'postuler'])->name('offres.postuler');
    Route::resource('candidatures', App\Http\Controllers\Candidat\CandidatureController::class)->only(['index', 'show']);
    Route::resource('entretiens', App\Http\Controllers\Candidat\EntretienController::class)->only(['index', 'show']);
    Route::get('cv', [App\Http\Controllers\Candidat\CVController::class, 'edit'])->name('cv.edit');
    Route::put('cv', [App\Http\Controllers\Candidat\CVController::class, 'update'])->name('cv.update');
    Route::get('profil', [App\Http\Controllers\Candidat\ProfilController::class, 'edit'])->name('profil.edit');
    Route::put('profil', [App\Http\Controllers\Candidat\ProfilController::class, 'update'])->name('profil.update');
    Route::put('profil/password', [App\Http\Controllers\Candidat\ProfilController::class, 'updatePassword'])->name('profil.password');
});

// Notifications (général)
Route::middleware('auth')->group(function () {
    Route::post('/notifications/{id}/mark-as-read', [App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::post('/notifications/mark-all-read', [App\Http\Controllers\NotificationController::class, 'markAllRead'])->name('notifications.markAllRead');
});

// Routes responsable
Route::middleware(['auth', 'role:responsable'])->prefix('responsable')->name('responsable.')->group(function () {
    Route::get('/dashboard', [ResponsableDashboardController::class, 'index'])->name('dashboard');

    // Offres (utilisation du slug pour la vue)
    Route::resource('offres', ResponsableOffreController::class)->except(['show']);
    Route::get('offres/{slug}', [ResponsableOffreController::class, 'show'])->name('offres.show');

    Route::resource('candidatures', ResponsableCandidatureController::class)->only(['index', 'show']);
    Route::post('candidatures/{candidature}/accepter', [ResponsableCandidatureController::class, 'accepter'])->name('candidatures.accepter');
    Route::post('candidatures/{candidature}/refuser', [ResponsableCandidatureController::class, 'refuser'])->name('candidatures.refuser');

    Route::resource('entretiens', ResponsableEntretienController::class);

    Route::get('candidats', [ResponsableCandidatController::class, 'index'])->name('candidats.index');
    Route::get('candidats/{candidat}', [ResponsableCandidatController::class, 'show'])->name('candidats.show');

    Route::get('statistiques', [ResponsableStatistiqueController::class, 'index'])->name('statistiques');

    Route::get('profil/edit', [ResponsableProfilController::class, 'edit'])->name('profil.edit');
    Route::put('profil', [ResponsableProfilController::class, 'update'])->name('profil.update');
    Route::put('profil/password', [ResponsableProfilController::class, 'updatePassword'])->name('profil.password');

    Route::post('candidatures/{candidature}/comment', [ResponsableCandidatureController::class, 'addComment'])->name('candidatures.comment');
    Route::post('candidatures/{candidature}/evaluate', [ResponsableCandidatureController::class, 'evaluate'])->name('candidatures.evaluate');
});

require __DIR__.'/auth.php';