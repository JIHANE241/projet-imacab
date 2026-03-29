<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Direction;
use App\Models\User;
use Illuminate\Http\Request;

class DirectionController extends Controller
{
    public function index()
    {
        $directions = Direction::with('responsable')->withCount('offres', 'candidatures')->get();
        return view('admin.directions.index', compact('directions'));
    }

    public function create()
    {
        // Uniquement les responsables validés (email_verified_at non null) et sans direction
        $responsables = User::where('role', 'responsable')
            ->whereNotNull('email_verified_at')
            ->whereNull('direction_id')
            ->get();

        return view('admin.directions.create', compact('responsables'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|unique:directions',
            'responsable_id' => 'nullable|exists:users,id|unique:directions,responsable_id',
        ]);

        $direction = Direction::create(['nom' => $request->nom]);

        if ($request->responsable_id) {
            // Vérification supplémentaire que le responsable est bien validé
            $responsable = User::where('id', $request->responsable_id)
                ->whereNotNull('email_verified_at')
                ->first();

            if ($responsable) {
                $responsable->update(['direction_id' => $direction->id]);
            } else {
                // Si le responsable n'est pas validé, on ignore ou on renvoie une erreur
                return back()->with('error', 'Le responsable sélectionné n\'est pas encore validé.');
            }
        }

        return redirect()->route('admin.directions.index')->with('success', 'Direction créée.');
    }

    public function show(Direction $direction)
    {
        $direction->load('responsable');
        return view('admin.directions.show', compact('direction'));
    }

    public function edit(Direction $direction)
    {
        // Responsables validés : soit sans direction, soit déjà affectés à cette direction
        $responsables = User::where('role', 'responsable')
            ->whereNotNull('email_verified_at')
            ->where(function ($q) use ($direction) {
                $q->whereNull('direction_id')
                  ->orWhere('direction_id', $direction->id);
            })->get();

        return view('admin.directions.edit', compact('direction', 'responsables'));
    }

    public function update(Request $request, Direction $direction)
    {
        $request->validate([
            'nom' => 'required|string|unique:directions,nom,' . $direction->id,
            'responsable_id' => 'nullable|exists:users,id|unique:directions,responsable_id,' . $direction->id,
        ]);

        // Retirer l'ancien responsable
        if ($direction->responsable) {
            $direction->responsable->update(['direction_id' => null]);
        }

        $direction->update(['nom' => $request->nom]);

        if ($request->responsable_id) {
            // Vérifier que le nouveau responsable est validé
            $responsable = User::where('id', $request->responsable_id)
                ->whereNotNull('email_verified_at')
                ->first();

            if ($responsable) {
                $responsable->update(['direction_id' => $direction->id]);
            } else {
                return back()->with('error', 'Le responsable sélectionné n\'est pas encore validé.');
            }
        }

        return redirect()->route('admin.directions.index')->with('success', 'Direction mise à jour.');
    }

    public function destroy(Direction $direction)
    {
        // Vérifier qu'aucune offre n'est associée
        if ($direction->offres()->count() > 0) {
            return back()->with('error', 'Impossible de supprimer une direction avec des offres.');
        }
        $direction->delete();
        return redirect()->route('admin.directions.index')->with('success', 'Direction supprimée.');
    }
}