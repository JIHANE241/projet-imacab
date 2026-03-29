<?php

namespace App\Http\Controllers\Responsable;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Offre;
use App\Models\Direction;
use App\Models\TypeContrat;
use App\Models\NiveauExperience;
use App\Models\NiveauEtude;
use App\Models\Ville;
use App\Models\Category;
use App\Models\User;
use App\Notifications\NewOfferNotification;

class OffreController extends Controller
{
    protected $directionId;

    public function __construct()
    {
        $this->directionId = Auth::user()->direction_id;
    }

    public function index(Request $request)
    {
        $query = Offre::where('direction_id', $this->directionId)
            ->with(['direction', 'typeContrat', 'ville']);

        if ($request->filled('search')) {
            $query->where('titre', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }
        if ($request->filled('type_contrat')) {
            $query->where('type_contrat_id', $request->type_contrat);
        }

        $offres = $query->latest()->paginate(10);
        $typeContrats = TypeContrat::all();

        return view('responsable.offres.index', compact('offres', 'typeContrats'));
    }

    public function create()
    {
        $typesContrat = TypeContrat::all();
        $niveauxExperience = NiveauExperience::all();
        $niveauxEtude = NiveauEtude::all();
        $villes = Ville::all();
        $categories = Category::all();

        return view('responsable.offres.create', compact('typesContrat', 'niveauxExperience', 'niveauxEtude', 'villes', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'missions' => 'nullable|string',
            'profil' => 'nullable|string',
            'type_contrat_id' => 'required|exists:type_contrats,id',
            'niveau_experience_id' => 'required|exists:niveau_experiences,id',
            'niveau_etude_id' => 'required|exists:niveau_etudes,id',
            'ville_id' => 'required|exists:villes,id',
            'category_id' => 'required|exists:categories,id',
            'salaire_min' => 'nullable|numeric',
            'salaire_max' => 'nullable|numeric',
            'date_publication' => 'required|date',
            'date_limite' => 'nullable|date',
        ]);

        $validated['direction_id'] = $this->directionId;
        $validated['statut'] = 'brouillon';

        $offre = Offre::create($validated);

        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new NewOfferNotification($offre));
        }

        return redirect()->route('responsable.offres.index')->with('success', 'Offre créée avec succès (brouillon).');
    }

    public function show($slug)
    {
        $offre = Offre::where('slug', $slug)
            ->where('direction_id', $this->directionId)
            ->firstOrFail();
        return view('responsable.offres.show', compact('offre'));
    }

    public function edit(Offre $offre)
    {
        $this->authorizeDirection($offre);
        $typesContrat = TypeContrat::all();
        $niveauxExperience = NiveauExperience::all();
        $niveauxEtude = NiveauEtude::all();
        $villes = Ville::all();
        $categories = Category::all();

        return view('responsable.offres.edit', compact('offre', 'typesContrat', 'niveauxExperience', 'niveauxEtude', 'villes', 'categories'));
    }

    public function update(Request $request, Offre $offre)
    {
        $this->authorizeDirection($offre);

        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'missions' => 'nullable|string',
            'profil' => 'nullable|string',
            'type_contrat_id' => 'required|exists:type_contrats,id',
            'niveau_experience_id' => 'required|exists:niveau_experiences,id',
            'niveau_etude_id' => 'required|exists:niveau_etudes,id',
            'ville_id' => 'required|exists:villes,id',
            'category_id' => 'required|exists:categories,id',
            'salaire_min' => 'nullable|numeric',
            'salaire_max' => 'nullable|numeric',
            'date_publication' => 'required|date',
            'date_limite' => 'nullable|date',
        ]);

        $offre->update($validated);
        return redirect()->route('responsable.offres.index')->with('success', 'Offre mise à jour.');
    }

    public function destroy(Offre $offre)
    {
        $this->authorizeDirection($offre);
        $offre->delete();
        return redirect()->route('responsable.offres.index')->with('success', 'Offre supprimée.');
    }

    protected function authorizeDirection(Offre $offre)
    {
        if ($offre->direction_id != $this->directionId) {
            abort(403, 'Vous n\'avez pas accès à cette offre.');
        }
    }
}