<?php

namespace App\Http\Controllers\Candidat;

use App\Http\Controllers\Controller;
use App\Models\Offre;
use App\Models\User;
use App\Models\Direction;
use App\Models\TypeContrat;
use App\Models\Candidature;
use App\Models\NiveauEtude;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NouvelleCandidature;
use Illuminate\Support\Facades\Storage;

class OffreController extends Controller
{
    public function index(Request $request)
    {
        
        $search = $request->input('search');
        $typeContratId = $request->input('type_contrat');
        $directionId = $request->input('direction');

        $baseQuery = Offre::where('statut', 'ouverte')
                          ->with(['direction', 'typeContrat', 'ville']);

        $filteredQuery = clone $baseQuery;
        if ($search) {
            $filteredQuery->where('titre', 'like', "%{$search}%");
        }
        if ($typeContratId) {
            $filteredQuery->where('type_contrat_id', $typeContratId);
        }

       
        $totalToutesDirections = $filteredQuery->count();

        
        $directions = Direction::withCount(['offres' => function ($query) use ($search, $typeContratId) {
            $query->where('statut', 'ouverte');
            if ($search) {
                $query->where('titre', 'like', "%{$search}%");
            }
            if ($typeContratId) {
                $query->where('type_contrat_id', $typeContratId);
            }
        }])->get();

       
        $query = Offre::where('statut', 'ouverte')
                      ->with(['direction', 'typeContrat', 'ville']);
        if ($search) {
            $query->where('titre', 'like', "%{$search}%");
        }
        if ($typeContratId) {
            $query->where('type_contrat_id', $typeContratId);
        }
        if ($directionId) {
            $query->where('direction_id', $directionId);
        }
        $offres = $query->latest()->paginate(12);

        
        $typeContrats = TypeContrat::all();

        return view('candidat.offres.index', compact(
            'offres',
            'directions',
            'typeContrats',
            'totalToutesDirections'
        ));
    }

    public function show($slug)
    {
       
        $offre = Offre::where('slug', $slug)
                    ->where('statut', 'ouverte')
                    ->firstOrFail();

        $offre->load(['direction', 'typeContrat', 'ville', 'category']);
        $niveauxEtudes = NiveauEtude::all();

      
        $dejaPostule = Candidature::where('candidat_id', Auth::id())
                        ->where('offre_id', $offre->id)
                        ->exists();

        
        $candidature = null;
        if ($dejaPostule) {
            $candidature = Candidature::where('candidat_id', Auth::id())
                                ->where('offre_id', $offre->id)
                                ->first();
        }

        return view('candidat.offres.show', compact('offre', 'niveauxEtudes', 'dejaPostule', 'candidature'));
    }

    public function postuler(Request $request, Offre $offre)
    {
        
        $request->validate([
            'niveau_etude' => 'required|exists:niveau_etudes,id',
            'niveau_experience' => 'required|string',
            'adresse' => 'required|string|max:255',
            'formation' => 'required|string|max:255',

            'cv' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);

      
        $existing = Candidature::where('candidat_id', Auth::id())
                    ->where('offre_id', $offre->id)
                    ->exists();
        if ($existing) {
            return back()->with('error', 'Vous avez déjà postulé à cette offre.');
        }

        try {
    $cvPath = $request->file('cv')->store('cvs', 'public');
} catch (\Exception $e) {
    dd($e->getMessage());
}

        Candidature::create([
            'candidat_id' => Auth::id(),
            'offre_id' => $offre->id,
            'niveau_experience' => $request->niveau_experience,
            'adresse' => $request->adresse,
           'formation' => $request->formation,
            'niveau_etude_id' => $request->niveau_etude,
            'statut' => 'en_attente',
            'date_candidature' => now(),
            'cv_path' => $cvPath,
        ]);

        

        return redirect()->route('candidat.candidatures.index')
            ->with('success', 'Candidature envoyée !');
    }
}