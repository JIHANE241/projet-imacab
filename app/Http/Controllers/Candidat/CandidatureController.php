<?php

namespace App\Http\Controllers\Candidat;

use App\Http\Controllers\Controller;
use App\Models\Candidature;
use App\Models\Direction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CandidatureController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // Récupération des filtres
        $search = $request->input('search');
        $statut = $request->input('statut');
        $directionId = $request->input('direction');

        // Requête de base (candidatures de l'utilisateur)
        $baseQuery = Candidature::where('candidat_id', $user->id)
            ->with(['offre.direction', 'offre.typeContrat', 'offre.ville']);

        // Appliquer les filtres (sauf direction) pour les compteurs de la colonne de gauche
        $filteredQuery = clone $baseQuery;
        if ($search) {
            $filteredQuery->whereHas('offre', function ($q) use ($search) {
                $q->where('titre', 'like', "%{$search}%");
            });
        }
        if ($statut) {
            $filteredQuery->where('statut', $statut);
        }

        // Total toutes directions (après filtres search + statut)
        $totalToutesDirections = $filteredQuery->count();

        // Directions avec le nombre de candidatures de l'utilisateur correspondant aux filtres (search + statut)
        $directions = Direction::withCount(['offres as candidatures_count' => function ($query) use ($user, $search, $statut) {
            $query->whereHas('candidatures', function ($q) use ($user, $search, $statut) {
                $q->where('candidat_id', $user->id);
                if ($search) {
                    $q->whereHas('offre', function ($sq) use ($search) {
                        $sq->where('titre', 'like', "%{$search}%");
                    });
                }
                if ($statut) {
                    $q->where('statut', $statut);
                }
            });
        }])->get();

        // Pour la liste paginée, on applique tous les filtres (y compris direction)
        $query = Candidature::where('candidat_id', $user->id)
            ->with(['offre.direction', 'offre.typeContrat', 'offre.ville']);

        if ($search) {
            $query->whereHas('offre', function ($q) use ($search) {
                $q->where('titre', 'like', "%{$search}%");
            });
        }
        if ($statut) {
            $query->where('statut', $statut);
        }
        if ($directionId) {
            $query->whereHas('offre', function ($q) use ($directionId) {
                $q->where('direction_id', $directionId);
            });
        }

        $candidatures = $query->latest()->paginate(12);

        // Statistiques globales (après filtres search + statut)
        $total = $filteredQuery->count();
        $acceptees = (clone $filteredQuery)->where('statut', 'acceptee')->count();
        $refusees = (clone $filteredQuery)->where('statut', 'refusee')->count();
        $enAttente = (clone $filteredQuery)->where('statut', 'en_attente')->count();

        return view('candidat.candidatures.index', compact(
            'candidatures',
            'total',
            'acceptees',
            'refusees',
            'enAttente',
            'directions',
            'totalToutesDirections'
        ));
    }

    public function show(Candidature $candidature)
    {
        if ($candidature->candidat_id != Auth::id()) {
            abort(403);
        }
        return view('candidat.candidatures.show', compact('candidature'));
    }
}