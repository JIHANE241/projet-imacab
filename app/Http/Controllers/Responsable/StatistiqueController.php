<?php

namespace App\Http\Controllers\Responsable;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Candidature;
use App\Models\Offre;
use Carbon\Carbon;

class StatistiqueController extends Controller
{
    public function index()
    {
        $directionId = Auth::user()->direction_id;

        $totalOffres = Offre::where('direction_id', $directionId)->count();
        $totalCandidatures = Candidature::forDepartment($directionId)->count();

        $enAttente = Candidature::forDepartment($directionId)
            ->where('statut', 'en_attente')
            ->count();

        $enRevision = Candidature::forDepartment($directionId)
            ->where('statut', 'en_revision')
            ->count();

        $evalue = Candidature::forDepartment($directionId)
            ->whereNotNull('evaluation')  
            ->count();

      
        $evolution = [];
        for ($i = 11; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $count = Candidature::forDepartment($directionId)
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
            $evolution[] = ['mois' => $month->format('M Y'), 'total' => $count];
        }

       
        $offresStats = Offre::where('direction_id', $directionId)
            ->withCount('candidatures')
            ->orderBy('candidatures_count', 'desc')
            ->limit(10)
            ->get();

        return view('responsable.statistiques.index', compact(
            'totalOffres', 'totalCandidatures', 'enAttente', 'enRevision', 'evalue',
            'evolution', 'offresStats'
        ));
    }
}