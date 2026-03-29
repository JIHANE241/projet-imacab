<?php

namespace App\Http\Controllers\Responsable;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Entretien;
use App\Models\Candidature;
use Carbon\Carbon;

class EntretienController extends Controller
{
    protected $directionId;

    public function __construct()
    {
        $this->directionId = Auth::user()->direction_id;
    }

    public function index(Request $request)
    {
        $query = Entretien::with(['candidature.offre', 'candidature.candidat'])
            ->whereHas('candidature.offre', fn($q) => $q->where('direction_id', $this->directionId));

        if ($request->filled('search')) {
            $query->whereHas('candidature.offre', fn($q) => $q->where('titre', 'like', '%' . $request->search . '%'));
        }
        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        $entretiens = $query->orderBy('date')->orderBy('heure')->paginate(10);

        return view('responsable.entretiens.index', compact('entretiens'));
    }

    
public function create(Request $request)
{
   
    $candidatureId = $request->candidature_id;
    $candidature = null;

    if ($candidatureId) {
        $candidature = Candidature::with('offre', 'candidat')
            ->whereHas('offre', fn($q) => $q->where('direction_id', $this->directionId))
            ->findOrFail($candidatureId);
    }

   
    $candidatures = Candidature::with(['offre', 'candidat'])
        ->whereHas('offre', fn($q) => $q->where('direction_id', $this->directionId))
        ->where('statut', 'acceptee')
        ->whereDoesntHave('entretien')
        ->get();

    return view('responsable.entretiens.create', compact('candidature', 'candidatures'));
}

    public function store(Request $request)
    {
        $validated = $request->validate([
            'candidature_id' => 'required|exists:candidatures,id',
            'date' => 'required|date',
            'heure' => 'required|date_format:H:i',
            'lieu' => 'nullable|string|max:255',
            'statut' => 'required|in:planifie,passe,annule',
        ]);

        $candidature = Candidature::with('offre')->findOrFail($validated['candidature_id']);
        if ($candidature->offre->direction_id != $this->directionId) {
            abort(403);
        }

        Entretien::create($validated);
        return redirect()->route('responsable.entretiens.index')->with('success', 'Entretien planifié.');
    }

    public function show(Entretien $entretien)
    {
        $this->authorizeEntretien($entretien);
        return view('responsable.entretiens.show', compact('entretien'));
    }

    public function edit(Entretien $entretien)
    {
        $this->authorizeEntretien($entretien);
        return view('responsable.entretiens.edit', compact('entretien'));
    }

    public function update(Request $request, Entretien $entretien)
    {
        $this->authorizeEntretien($entretien);
        $validated = $request->validate([
            'date' => 'required|date',
            'heure' => 'required|date_format:H:i',
            'lieu' => 'nullable|string|max:255',
            'statut' => 'required|in:planifie,passe,annule',
        ]);

        $entretien->update($validated);
        return redirect()->route('responsable.entretiens.index')->with('success', 'Entretien mis à jour.');
    }

    public function destroy(Entretien $entretien)
    {
        $this->authorizeEntretien($entretien);
        $entretien->delete();
        return redirect()->route('responsable.entretiens.index')->with('success', 'Entretien supprimé.');
    }

    protected function authorizeEntretien(Entretien $entretien)
    {
        if ($entretien->candidature->offre->direction_id != $this->directionId) {
            abort(403);
        }
    }
}