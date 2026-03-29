<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Candidature;
use App\Models\Offre;

class ActiviteController extends Controller
{
    public function index(Request $request)
    {
       
        $activites = collect();

       
        $nouvellesCandidatures = Candidature::with(['candidat', 'offre'])
            ->latest()
            ->get()
            ->filter(function ($c) {
                return $c->offre && $c->candidat;
            })
            ->map(function ($c) {
                return (object) [
                    'type' => 'candidature',
                    'message' => "Nouvelle candidature de {$c->candidat->name} pour " .
                                 ($c->offre->titre ?? 'une offre indisponible'),
                    'date' => $c->created_at,
                ];
            });

        // 2. Nouvelles offres
        $nouvellesOffres = Offre::latest()
            ->get()
            ->filter(function ($o) {
                return $o->titre;
            })
            ->map(fn($o) => (object) [
                'type' => 'offre',
                'message' => "Nouvelle offre : {$o->titre}",
                'date' => $o->created_at,
            ]);

       
        $commentaires = Candidature::whereNotNull('commentaire_rd')
            ->with(['candidat', 'offre'])
            ->latest('comment_updated_at')
            ->get()
            ->map(function ($c) {
                return (object) [
                    'type' => 'commentaire',
                    'message' => "Commentaire de {$c->candidat->name} sur l'offre {$c->offre->titre} : " . substr($c->commentaire_rd, 0, 80),
                    'date' => $c->comment_updated_at,
                ];
            });

        // 4. Évaluations des responsables
        $evaluations = Candidature::whereNotNull('evaluation')
            ->with(['candidat', 'offre'])
            ->latest('evaluated_at')
            ->get()
            ->map(function ($c) {
                $avis = $c->evaluation == 'favorable' ? 'favorable' : 'défavorable';
                return (object) [
                    'type' => 'evaluation',
                    'message' => "Évaluation {$avis} pour {$c->candidat->name} sur l'offre {$c->offre->titre}",
                    'date' => $c->evaluated_at,
                ];
            });

        // Concaténer toutes les activités
        $activites = $activites->concat($nouvellesCandidatures)
            ->concat($nouvellesOffres)
            ->concat($commentaires)
            ->concat($evaluations);

        // Trier par date décroissante
        $activites = $activites->sortByDesc('date')->values();

        // Pagination manuelle (car c'est une collection)
        $perPage = 20;
        $currentPage = $request->get('page', 1);
        $activitesPaginated = new \Illuminate\Pagination\LengthAwarePaginator(
            $activites->forPage($currentPage, $perPage),
            $activites->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('admin.activites.index', compact('activitesPaginated'));
    }
}