<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Candidature;
use App\Models\Direction;
use App\Models\Offre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
 use App\Notifications\CandidatureStatutChange;

class CandidatureController extends Controller
{
    public function index(Request $request)
    {
        $directions = Direction::withCount('candidatures')->get();

        $direction_id = $request->get('direction_id');
        $candidatures = collect();
        $selectedDirection = null;

        if ($direction_id) {
            $selectedDirection = Direction::find($direction_id);
            $query = Candidature::with(['candidat', 'offre', 'entretien'])
                ->whereHas('offre', function ($q) use ($direction_id) {
                    $q->where('direction_id', $direction_id);
                });

            if ($request->filled('search')) {
                $query->whereHas('candidat', function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%');
                })->orWhereHas('offre', function ($q) use ($request) {
                    $q->where('titre', 'like', '%' . $request->search . '%');
                });
            }

            if ($request->filled('statut')) {
                $query->where('statut', $request->statut);
            }

            $candidatures = $query->latest()->paginate(15);
        }

        $stats = [
            'total' => Candidature::count(),
            'acceptees' => Candidature::where('statut', 'acceptee')->count(),
            'refusees' => Candidature::where('statut', 'refusee')->count(),
            'en_attente' => Candidature::where('statut', 'en_attente')->count(),
        ];

        return view('admin.candidatures.index', compact('directions', 'selectedDirection', 'candidatures', 'stats'));
    }

    public function show($id)
{
    $candidature = Candidature::withTrashed()
        ->with(['candidat', 'offre.direction', 'entretien'])
        ->findOrFail($id);

    return view('admin.candidatures.show', compact('candidature'));
}

    public function destroy(Candidature $candidature)
    {
        $direction_id = $candidature->offre->direction_id;
        $candidature->delete();
        return redirect()->route('admin.candidatures.index', ['direction_id' => $direction_id])
            ->with('success', 'Candidature supprimée.');
    }

    public function accepter(Candidature $candidature)
    {
        $candidature->update(['statut' => 'acceptee']);
        // Envoyer notification au candidat
        $user = $candidature->candidat;

      $user->notify(new \App\Notifications\CandidatureStatutChange($candidature));


        return back()->with('success', 'Candidature acceptée.');
    }

    public function refuser(Candidature $candidature)  
{  
    $candidature->update(['statut' => 'refusee']);  

    $user = $candidature->candidat;  
    $user->notify(new \App\Notifications\CandidatureStatutChange($candidature));  

    return back()->with('success', 'Candidature refusée.');  
}

    public function voirCv($id)
{
    $candidature = Candidature::withTrashed()->findOrFail($id);

    $path = storage_path('app/public/' . $candidature->cv_path);

    if (!file_exists($path)) {
        return back()->with('error', 'CV introuvable.');
    }

    return response()->file($path);
}
public function updateStatut(Request $request, Candidature $candidature)
{
    $request->validate([
        'statut' => 'required|in:en_attente,acceptee,refusee'
    ]);

    $candidature->update(['statut' => $request->statut]);

    // Optionnel : notifier le candidat
    $candidature->candidat->notify(new \App\Notifications\CandidatureStatutChange($candidature));

    return back()->with('success', 'Statut mis à jour.');
}
   
}