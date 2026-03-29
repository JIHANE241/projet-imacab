<?php

namespace App\Http\Controllers\Responsable;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Candidature;

class CandidatController extends Controller
{
    protected $directionId;

    public function __construct()
    {
        $this->directionId = Auth::user()->direction_id;
    }

    public function index(Request $request)
    {
        
        $query = User::where('role', 'candidat')
            ->whereHas('candidatures.offre', fn($q) => $q->where('direction_id', $this->directionId))
            ->with(['candidatures' => function($q) {
                $q->whereHas('offre', fn($sq) => $sq->where('direction_id', $this->directionId));
            }]);

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('prenom', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $candidats = $query->paginate(10);

        return view('responsable.candidats.index', compact('candidats'));
    }

    public function show(User $candidat)
    {
        
        $hasApplication = $candidat->candidatures()
            ->whereHas('offre', fn($q) => $q->where('direction_id', $this->directionId))
            ->exists();

        if (!$hasApplication) {
            abort(403, 'Ce candidat n\'a pas postulé à votre département.');
        }

       
        $candidatures = $candidat->candidatures()
            ->whereHas('offre', fn($q) => $q->where('direction_id', $this->directionId))
            ->with('offre')
            ->get();

        return view('responsable.candidats.show', compact('candidat', 'candidatures'));
    }
}