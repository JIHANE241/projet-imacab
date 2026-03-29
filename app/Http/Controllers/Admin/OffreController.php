<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Offre;
use App\Models\Direction;
use App\Models\Category;
use App\Models\TypeContrat;
use App\Models\NiveauExperience;
use App\Models\Ville;
use Illuminate\Http\Request;
use App\Models\NiveauEtude;
use Illuminate\Support\Facades\Auth;

class OffreController extends Controller
{
    public function index(Request $request)
    {
        $directions = Direction::withCount('offres')->get();

        $direction_id = $request->get('direction_id');
        $offres = collect();
        $selectedDirection = null;

        if ($direction_id) {
            $selectedDirection = Direction::find($direction_id);
            $query = Offre::with(['direction', 'category', 'typeContrat', 'niveauExperience', 'ville'])
                ->where('direction_id', $direction_id);

            if ($request->filled('search')) {
                $query->where('titre', 'like', '%' . $request->search . '%');
            }

            if ($request->filled('statut')) {
                $query->where('statut', $request->statut);
            }

            $offres = $query->latest()->paginate(15);
        }

        $stats = [
            'total' => Offre::count(),
            'ouvertes' => Offre::where('statut', 'ouverte')->count(),
            'fermees' => Offre::where('statut', 'fermée')->count(),
        ];

        return view('admin.offres.index', compact('directions', 'selectedDirection', 'offres', 'stats'));
    }

    public function create()
    {
        $directions = Direction::all();
        $categories = Category::all();
        $typeContrats = TypeContrat::all();
        $niveauExperiences = NiveauExperience::all();
        $villes = Ville::all();
        $niveauxEtudes = NiveauEtude::all();

        return view('admin.offres.create', compact('directions', 'categories', 'typeContrats', 'niveauExperiences', 'villes', 'niveauxEtudes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required',
            'direction_id' => 'required|exists:directions,id',
            'category_id' => 'required|exists:categories,id',
            'type_contrat_id' => 'required|exists:type_contrats,id',
            'niveau_experience_id' => 'required|exists:niveau_experiences,id',
            'ville_id' => 'nullable|exists:villes,id',
            'date_publication' => 'required|date',
            'date_limite' => 'nullable|date|after_or_equal:date_publication',
            'salaire_min' => 'nullable|integer|min:0',
            'salaire_max' => 'nullable|integer|gte:salaire_min',
            'statut' => 'required|in:brouillon,ouverte,fermée',
            'missions' => 'nullable|string',
            'profil' => 'nullable|string',
            'niveau_etude_id' => 'nullable|exists:niveau_etudes,id',
        ]);

        $offre = Offre::create($validated);

        return redirect()->route('admin.offres.index', ['direction_id' => $offre->direction_id])
            ->with('success', 'Offre créée.');
    }

    public function show($slug)
    {
        $offre = Offre::where('slug', $slug)->firstOrFail();
        $offre->load(['direction', 'category', 'typeContrat', 'niveauExperience', 'ville']);
        return view('admin.offres.show', compact('offre'));
    }

    public function edit(Offre $offre)
    {
        $directions = Direction::all();
        $categories = Category::all();
        $typeContrats = TypeContrat::all();
        $niveauExperiences = NiveauExperience::all();
        $niveauxEtudes = NiveauEtude::all();
        $villes = Ville::all();

        return view('admin.offres.edit', compact('offre', 'directions', 'categories', 'typeContrats', 'niveauExperiences', 'niveauxEtudes', 'villes'));
    }

    public function update(Request $request, Offre $offre)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required',
            'direction_id' => 'required|exists:directions,id',
            'category_id' => 'required|exists:categories,id',
            'type_contrat_id' => 'required|exists:type_contrats,id',
            'niveau_experience_id' => 'required|exists:niveau_experiences,id',
            'ville_id' => 'nullable|exists:villes,id',
            'date_publication' => 'required|date',
            'date_limite' => 'nullable|date|after_or_equal:date_publication',
            'salaire_min' => 'nullable|integer|min:0',
            'salaire_max' => 'nullable|integer|gte:salaire_min',
            'statut' => 'required|in:brouillon,ouverte,fermée',
            'missions' => 'nullable|string',
            'profil' => 'nullable|string',
            'niveau_etude_id' => 'nullable|exists:niveau_etudes,id',
        ]);

        $offre->update($validated);

        return redirect()->route('admin.offres.index', ['direction_id' => $offre->direction_id])
            ->with('success', 'Offre mise à jour.');
    }

    public function destroy(Offre $offre)
    {
        $direction_id = $offre->direction_id;
        $offre->delete();
        return redirect()->route('admin.offres.index', ['direction_id' => $direction_id])
            ->with('success', 'Offre supprimée.');
    }

    public function fermer(Offre $offre)
    {
        $offre->update(['statut' => 'fermée']);
        return back()->with('success', 'Offre fermée.');
    }

    public function valider(Offre $offre)
    {
        if ($offre->statut !== 'brouillon') {
            return back()->with('error', 'Seule une offre en brouillon peut être validée.');
        }

        $offre->update([
            'statut' => 'ouverte',
            'validated_at' => now(),
            'validated_by' => Auth::id(),
        ]);

        
        $responsable = $offre->direction->responsable;
        if ($responsable) {
            $responsable->notify(new \App\Notifications\OffreValidated($offre));
        }

        return redirect()->route('admin.offres.show', $offre->slug)
            ->with('success', 'Offre validée et publiée.');
    }

    public function ouvrir(Offre $offre)
    {
        $offre->update(['statut' => 'ouverte']);
        return back()->with('success', 'Offre réouverte.');
    }
}