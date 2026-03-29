<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Offre;
use App\Models\Candidature;
use App\Models\Direction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StatistiquesExport;

class StatistiqueController extends Controller
{
    public function index()
    {
        // Évolution des candidatures par mois
        $candidaturesParMois = Candidature::select(
            DB::raw('YEAR(created_at) as annee'),
            DB::raw('MONTH(created_at) as mois'),
            DB::raw('COUNT(*) as total')
        )
        ->groupBy('annee', 'mois')
        ->orderBy('annee', 'desc')
        ->orderBy('mois', 'desc')
        ->get();

        // Évolution des offres par mois
        $offresParMois = Offre::select(
            DB::raw('YEAR(created_at) as annee'),
            DB::raw('MONTH(created_at) as mois'),
            DB::raw('COUNT(*) as total')
        )
        ->groupBy('annee', 'mois')
        ->orderBy('annee', 'desc')
        ->orderBy('mois', 'desc')
        ->get();

        // Candidatures par direction
        $candidaturesParDirection = Direction::withCount('candidatures')->get();

        // Offres par direction
        $offresParDirection = Direction::withCount('offres')->get();

        // Statistiques mensuelles détaillées
        $statistiquesMensuelles = DB::table('candidatures')
            ->select(
                DB::raw('YEAR(candidatures.created_at) as annee'),
                DB::raw('MONTH(candidatures.created_at) as mois'),
                DB::raw('COUNT(candidatures.id) as total_candidatures'),
                DB::raw('SUM(CASE WHEN candidatures.statut = "acceptee" THEN 1 ELSE 0 END) as recrutements')
            )
            ->groupBy('annee', 'mois')
            ->orderBy('annee', 'desc')
            ->orderBy('mois', 'desc')
            ->get();

        // Statistiques par direction
         $statistiquesParDirection = Direction::withCount([
    'offres',
    'candidatures as candidatures_en_attente' => function ($q) {
        $q->where('candidatures.statut', 'en_attente');
    },
    'candidatures as candidatures_acceptees' => function ($q) {
        $q->where('candidatures.statut', 'acceptee');
    },
    'candidatures as candidatures_refusees' => function ($q) {
        $q->where('candidatures.statut', 'refusee');
    }
])->get();

        return view('admin.statistiques.index', compact(
            'candidaturesParMois',
            'offresParMois',
            'candidaturesParDirection',
            'offresParDirection',
            'statistiquesMensuelles',
            'statistiquesParDirection'
        ));
    }

    public function exportPdf()
{
    $directions = Direction::withCount('offres','candidatures')->get();

    $pdf = Pdf::loadView('admin.statistiques.pdf', compact('directions'));

    return $pdf->download('statistiques.pdf');
}

public function exportExcel()
{
    return Excel::download(new StatistiquesExport, 'statistiques.xlsx');
}
}