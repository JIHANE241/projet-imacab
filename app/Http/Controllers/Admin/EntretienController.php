<?php

namespace App\Http\Controllers\Admin;
use App\Notifications\NouvelEntretien;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Entretien;
use App\Models\Candidature;
use Illuminate\Http\Request;

class EntretienController extends Controller
{
    

public function index(Request $request)
{
  
    $query = Entretien::with(['candidature.candidat', 'candidature.offre.direction']);
    $todayEntretiens = Entretien::whereDate('date', now())->where('statut', 'planifie')->get();

    
    if ($request->filled('search')) {
        $query->whereHas('candidature.offre', function ($q) use ($request) {
            $q->where('titre', 'like', '%' . $request->search . '%');
        });
    }

    
    if ($request->filled('statut')) {
        $query->where('statut', $request->statut);
    }

    
    if ($request->filled('date_debut')) {
        $query->whereDate('date', '>=', $request->date_debut);
    }

    if ($request->filled('date_fin')) {
        $query->whereDate('date', '<=', $request->date_fin);
    }

    
    $entretiens = $query->latest()->paginate(9)->withQueryString();

   
    $total = Entretien::count();
    $planifies = Entretien::where('statut', 'planifie')->count();
    $passes = Entretien::where('statut', 'passe')->count();
    $annules = Entretien::where('statut', 'annule')->count();

    return view('admin.entretiens.index', compact(
        'entretiens',
         'total',
         'planifies',
          'passes',
          'annules',
          'todayEntretiens'
    ));
}


    public function create()
    {
        // Seulement les candidatures acceptées sans entretien déjà planifié
        $candidatures = Candidature::with('candidat', 'offre')
            ->where('statut', 'acceptee')
            ->whereDoesntHave('entretien')
            ->get();

        return view('admin.entretiens.create', compact('candidatures'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'candidature_id' => 'required|exists:candidatures,id',
            'date' => 'required|date',
            'heure' => 'required|date_format:H:i',
            'lieu' => 'nullable|string',
            'statut' => 'required|in:planifie,passe,annule',
        ]);

        $entretien = Entretien::create($request->all());

        // Marquer la candidature comme ayant un entretien planifié
        Candidature::where('id', $request->candidature_id)->update(['entretien_planifie' => true]);
        $entretien->candidature->candidat->notify(new NouvelEntretien($entretien));
        return redirect()->route('admin.entretiens.index')
            ->with('success', 'Entretien planifié.');
    }

    public function show(Entretien $entretien)
    {
         $entretien->load(['candidature.offre.direction', 'candidature.candidat']);
    return view('admin.entretiens.show', compact('entretien'));
    }

    public function edit(Entretien $entretien)
    {
        $candidatures = Candidature::with('candidat', 'offre')->where('statut', 'acceptee')->get();
        return view('admin.entretiens.edit', compact('entretien', 'candidatures'));
    }

    public function update(Request $request, Entretien $entretien)
    {
        $request->validate([
            'date' => 'required|date',
            'heure' => 'required|date_format:H:i',
            'lieu' => 'nullable|string',
            'statut' => 'required|in:planifie,passe,annule',
        ]);

        $entretien->update($request->all());

        return redirect()->route('admin.entretiens.index')
            ->with('success', 'Entretien mis à jour.');
    }

    public function destroy(Entretien $entretien)
    {
        $candidature = $entretien->candidature;
        $entretien->delete();
        $candidature->update(['entretien_planifie' => false]);

        return redirect()->route('admin.entretiens.index')
            ->with('success', 'Entretien supprimé.');
    }
}