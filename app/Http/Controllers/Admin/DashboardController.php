<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Offre;
use App\Models\Candidature;
use App\Models\Direction;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
{
    // Total des utilisateurs actifs (exclut les responsables en attente)
    $totalUtilisateurs = User::where(function ($q) {
        $q->where('role', '!=', 'responsable')
          ->orWhereNotNull('email_verified_at');
    })->count();

    $totalOffres = Offre::count();
    $totalCandidatures = Candidature::count();
    $totalDirections = Direction::count();
    $offresOuvertes = Offre::where('statut', 'ouverte')->count();
    $offresFermees = Offre::where('statut', 'fermée')->count();

    // Responsables en attente (inchangé)
    $responsablesEnAttente = User::where('role', 'responsable')
        ->whereNull('email_verified_at')
        ->with('direction')
        ->get();

    // Dernières offres – exclure celles dont la direction est supprimée
$dernieresOffres = Offre::with('direction')
    ->whereHas('direction')  
    ->latest()
    ->take(5)
    ->get();

// Candidatures en attente – exclure celles dont l'offre est supprimée
$candidaturesEnAttente = Candidature::with(['candidat', 'offre'])
    ->whereHas('offre')      
    ->where('statut', 'en_attente')
    ->latest()
    ->take(5)
    ->get();

    // Activités récentes
    $activites = collect();

    $nouvellesCandidatures = Candidature::with(['candidat', 'offre'])
    ->latest()
    ->take(3)
    ->get()
    ->filter(function ($c) {
      
        return $c->offre && $c->candidat;
    })
    ->map(function ($c) {
        return (object) [
            'type' => 'candidature',
            'message' => "Nouvelle candidature de {$c->candidat->name} pour " .
                         ($c->offre->titre ?? 'une offre indisponible'),
            'date' => $c->created_at->diffForHumans(),
        ];
    });

    $nouvellesOffres = Offre::latest()
    ->take(3)
    ->get()
    ->filter(function ($o) {
        return $o->titre;  
    })
    ->map(fn($o) => (object) [
        'type' => 'offre',
        'message' => "Nouvelle offre : {$o->titre}",
        'date' => $o->created_at->diffForHumans(),
    ]);

    $activites = $activites->concat($nouvellesCandidatures)
        ->concat($nouvellesOffres)
        ->sortByDesc('date')
        ->take(5);

    return view('admin.dashboard', compact(
        'totalUtilisateurs', 'totalOffres', 'totalCandidatures', 'totalDirections',
        'offresOuvertes', 'offresFermees', 'responsablesEnAttente', 'candidaturesEnAttente',
        'dernieresOffres', 'activites'
    ));
}

}