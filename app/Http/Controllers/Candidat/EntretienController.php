<?php

namespace App\Http\Controllers\Candidat;

use App\Http\Controllers\Controller;
use App\Models\Entretien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EntretienController extends Controller
{
    public function index(Request $request)
{
    $query = Entretien::whereHas('candidature', function ($q) {
        $q->where('candidat_id', Auth::id());
    })->with('candidature.offre.direction');

   
    if ($request->filled('search')) {
        $query->whereHas('candidature.offre', function ($q) use ($request) {
            $q->where('titre', 'like', '%' . $request->search . '%');
        });
    }

  
    if ($request->filled('statut')) {
        $query->where('statut', $request->statut);
    }

   
    $entretiens = $query->latest()->paginate(10)->withQueryString();

    $total = $query->count();

    $planifies = Entretien::whereHas('candidature', fn($q) => 
        $q->where('candidat_id', Auth::id()))
        ->where('statut', 'planifie')->count();

    $passes = Entretien::whereHas('candidature', fn($q) => 
        $q->where('candidat_id', Auth::id()))
        ->where('statut', 'passe')->count();

    $annules = Entretien::whereHas('candidature', fn($q) => 
        $q->where('candidat_id', Auth::id()))
        ->where('statut', 'annule')->count();

    return view('candidat.entretiens.index', compact(
        'entretiens', 'total', 'planifies', 'passes', 'annules'
    ));
}

    public function show(Entretien $entretien)
    {
        if ($entretien->candidature->candidat_id != Auth::id()) {
            abort(403);
        }
        return view('candidat.entretiens.show', compact('entretien'));
    }
}