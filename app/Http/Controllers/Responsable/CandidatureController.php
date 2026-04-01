<?php

namespace App\Http\Controllers\Responsable;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Candidature;
use App\Notifications\CandidatureCommented;
use App\Notifications\CandidatureEvaluated; 
use App\Models\User;
 use Illuminate\Support\Facades\Storage;

class CandidatureController extends Controller
{
    protected $directionId;

    public function __construct()
    {
        $this->directionId = Auth::user()->direction_id;
    }

    public function index(Request $request)
    {
        $query = Candidature::with(['candidat', 'offre'])
            ->whereHas('offre', fn($q) => $q->where('direction_id', $this->directionId));

        if ($request->filled('search')) {
            $query->whereHas('candidat', fn($q) => $q->where('name', 'like', "%{$request->search}%")
                ->orWhere('prenom', 'like', "%{$request->search}%"));
        }
        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        $candidatures = $query->latest()->paginate(10);
        return view('responsable.candidatures.index', compact('candidatures'));
    }

    public function show(Candidature $candidature)
    {
        if ($candidature->offre->direction_id != $this->directionId) {
            abort(403);
        }
        return view('responsable.candidatures.show', compact('candidature'));
    }

    public function addComment(Request $request, Candidature $candidature)
    {
        if ($candidature->offre->direction_id != $this->directionId) {
            abort(403);
        }

        $request->validate([
            'commentaire_rd' => 'required|string|min:3',
        ]);

        $candidature->update([
            'commentaire_rd' => $request->commentaire_rd,
            'comment_updated_at' => now(),
            'statut' => 'en_revision', // passage automatique
        ]);

       
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new CandidatureCommented($candidature, Auth::user()));
        }

        return back()->with('success', 'Commentaire ajouté. Statut passé à "En révision".');
    }

    public function evaluate(Request $request, Candidature $candidature)
    {
       
        if ($candidature->offre->direction_id != Auth::user()->direction_id) {
            abort(403);
        }

        $request->validate([
            'evaluation' => 'required|in:favorable,defavorable',
            'evaluation_comment' => 'nullable|string|max:1000',
        ]);

        $candidature->update([
            'evaluation' => $request->evaluation,
            'evaluation_comment' => $request->evaluation_comment,
            'evaluated_at' => now(),
            'statut' => 'evalue',
        ]);

    
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new CandidatureEvaluated($candidature, Auth::user()));
        }

        return back()->with('success', 'Votre évaluation a été enregistrée.');
    }
   

public function voirCv($id)
{
    $candidature = Candidature::withTrashed()->findOrFail($id);

    if ($candidature->offre->direction_id != Auth::user()->direction_id) {
        abort(403);
    }

    $path = storage_path('app/public/' . $candidature->cv_path);

    if (!file_exists($path)) {
        return back()->with('error', 'CV introuvable.');
    }

    return response()->file($path);
}
}