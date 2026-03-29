<?php

namespace App\Http\Controllers\Candidat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Candidature;
use App\Models\Offre;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        // Statistiques des candidatures
        $totalCandidatures = Candidature::where('candidat_id', $user->id)->count();
        $acceptees = Candidature::where('candidat_id', $user->id)->where('statut', 'acceptee')->count();
        $refusees = Candidature::where('candidat_id', $user->id)->where('statut', 'refusee')->count();
        $enAttente = Candidature::where('candidat_id', $user->id)->where('statut', 'en_attente')->count();

        // Dernières candidatures (5)
        $dernieresCandidatures = Candidature::where('candidat_id', $user->id)
            ->with('offre')
            ->latest()
            ->take(5)
            ->get();

        // Dernières offres publiées (5)
        $dernieresOffres = Offre::where('statut', 'ouverte')
            ->with('direction')
            ->latest()
            ->take(5)
            ->get();

        return view('candidat.dashboard', compact(
            'user',
            'totalCandidatures',
            'acceptees',
            'refusees',
            'enAttente',
            'dernieresCandidatures',
            'dernieresOffres'
        ));
    }
}