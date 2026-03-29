<?php

namespace App\Http\Controllers\Responsable;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Candidature;
use App\Models\Offre;
use App\Models\Entretien;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $directionId = Auth::user()->direction_id;

        // Statistiques de base
        $totalOffres = Offre::where('direction_id', $directionId)->count();
        $totalCandidatures = Candidature::whereHas('offre', fn($q) => $q->where('direction_id', $directionId))->count();

        $enAttente = Candidature::whereHas('offre', fn($q) => $q->where('direction_id', $directionId))
            ->where('statut', 'en_attente')->count();

        $enRevision = Candidature::whereHas('offre', fn($q) => $q->where('direction_id', $directionId))
            ->where('statut', 'en_revision')->count();

        $evalue = Candidature::whereHas('offre', fn($q) => $q->where('direction_id', $directionId))
            ->whereNotNull('evaluation')->count();

        $acceptees = Candidature::whereHas('offre', fn($q) => $q->where('direction_id', $directionId))
            ->where('statut', 'acceptee')->count();

        $refusees = Candidature::whereHas('offre', fn($q) => $q->where('direction_id', $directionId))
            ->where('statut', 'refusee')->count();

        $favorables = Candidature::whereHas('offre', fn($q) => $q->where('direction_id', $directionId))
            ->where('evaluation', 'favorable')->count();

        $defavorables = Candidature::whereHas('offre', fn($q) => $q->where('direction_id', $directionId))
            ->where('evaluation', 'defavorable')->count();

        // Nombre total d'entretiens pour le département
        $entretiensCount = Entretien::whereHas('candidature.offre', fn($q) => $q->where('direction_id', $directionId))->count();

        // Évolution mensuelle (12 derniers mois)
        $evolution = [];
        for ($i = 11; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $count = Candidature::whereHas('offre', fn($q) => $q->where('direction_id', $directionId))
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
            $evolution[] = [
                'mois' => $month->format('M Y'),
                'total' => $count,
            ];
        }

        // Répartition par statut
        $repartition = [
            'en_attente' => $enAttente,
            'en_revision' => $enRevision,
            'evalue' => $evalue,
           
        ];

        // Dernières candidatures (5)
        $dernieresCandidatures = Candidature::whereHas('offre', fn($q) => $q->where('direction_id', $directionId))
            ->with(['candidat', 'offre'])
            ->latest()
            ->limit(5)
            ->get();

        // Prochains entretiens (5)
        $prochainsEntretiens = Entretien::whereHas('candidature.offre', fn($q) => $q->where('direction_id', $directionId))
            ->where('date', '>=', Carbon::today())
            ->with(['candidature.candidat', 'candidature.offre'])
            ->orderBy('date')
            ->orderBy('heure')
            ->limit(5)
            ->get();

        // Candidatures à évaluer (en attente ou en révision, limité à 5)
        $candidaturesAEvaluer = Candidature::whereHas('offre', fn($q) => $q->where('direction_id', $directionId))
    ->whereNull('evaluation')                      // ← uniquement celles sans évaluation
    ->with(['candidat', 'offre'])
    ->latest()
    ->limit(5)
    ->get();

        // Top candidats (évaluations favorables, avec date d'évaluation)
        $topCandidats = Candidature::whereHas('offre', fn($q) => $q->where('direction_id', $directionId))
            ->where('evaluation', 'favorable')
            ->with(['candidat', 'offre'])
            ->orderBy('evaluated_at', 'desc')
            ->limit(5)
            ->get();

        // Notifications non lues (pour le badge)
        $notificationsCount = Auth::user()->unreadNotifications->count();

        return view('responsable.dashboard', compact(
            'totalOffres', 'totalCandidatures', 'enAttente', 'enRevision', 'evalue',
            'acceptees', 'refusees', 'favorables', 'defavorables', 'entretiensCount',
            'evolution', 'repartition', 'dernieresCandidatures', 'prochainsEntretiens',
            'candidaturesAEvaluer', 'topCandidats', 'notificationsCount'
        ));
    }
}