<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Direction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UtilisateurController extends Controller
{
   public function index(Request $request)
{
    // Exclure les responsables en attente (role responsable et email_verified_at null)
    $query = User::where(function ($q) {
        $q->where('role', '!=', 'responsable')
          ->orWhereNotNull('email_verified_at');
    })->with('direction');

    // Recherche
    if ($request->filled('search')) {
        $query->where(function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->search . '%')
              ->orWhere('email', 'like', '%' . $request->search . '%');
        });
    }

    // Filtre par rôle
    if ($request->filled('role')) {
        // Si on filtre par rôle 'responsable', on ne doit inclure que ceux qui sont validés
        // Mais comme la requête de base exclut déjà les non validés, on peut simplement appliquer le filtre
        $query->where('role', $request->role);
    }

    $utilisateurs = $query->latest()->paginate(15);

    // Statistiques : compter uniquement les utilisateurs actifs
    $stats = [
        'admins' => User::where('role', 'admin')->count(),
        'responsables' => User::where('role', 'responsable')->whereNotNull('email_verified_at')->count(),
        'candidats' => User::where('role', 'candidat')->count(),
    ];

    return view('admin.utilisateurs.index', compact('utilisateurs', 'stats'));
}

    public function create()
{
    // Directions sans aucun responsable validé
    $directions = Direction::whereDoesntHave('responsable')->get();

    return view('admin.utilisateurs.create', compact('directions'));
}

public function edit(User $utilisateur)
{
    // Directions libres + la direction de l'utilisateur (si elle existe et qu'elle a un responsable)
    $directions = Direction::whereDoesntHave('responsable', function ($query) use ($utilisateur) {
        $query->where('id', '!=', $utilisateur->id);
    })->get();

    return view('admin.utilisateurs.edit', compact('utilisateur', 'directions'));
}

public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'prenom' => 'nullable|string|max:255',
        'email' => 'required|email|unique:users',
        'password' => 'required|string|min:8|confirmed',
        'telephone' => 'nullable|string|max:20',
        'role' => 'required|in:admin,responsable,candidat',
        'direction_id' => [
            'nullable',
            'exists:directions,id',
            function ($attribute, $value, $fail) {
                if ($value) {
                    $exists = User::where('role', 'responsable')
                        ->where('direction_id', $value)
                        ->exists();
                    if ($exists) {
                        $fail('Cette direction a déjà un responsable.');
                    }
                }
            },
        ],
    ]);

    User::create([
        'name' => $request->name,
        'prenom' => $request->prenom,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'telephone' => $request->telephone,
        'role' => $request->role,
        'direction_id' => $request->direction_id,
    ]);

    return redirect()->route('admin.utilisateurs.index')
        ->with('success', 'Utilisateur créé avec succès.');
}

public function update(Request $request, User $utilisateur)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'prenom' => 'nullable|string|max:255',
        'email' => 'required|email|unique:users,email,' . $utilisateur->id,
        'telephone' => 'nullable|string|max:20',
        'role' => 'required|in:admin,responsable,candidat',
        'direction_id' => [
            'nullable',
            'exists:directions,id',
            function ($attribute, $value, $fail) use ($utilisateur) {
                if ($value) {
                    $exists = User::where('role', 'responsable')
                        ->where('direction_id', $value)
                        ->where('id', '!=', $utilisateur->id)
                        ->exists();
                    if ($exists) {
                        $fail('Cette direction a déjà un responsable.');
                    }
                }
            },
        ],
    ]);

    $utilisateur->update($request->only('name', 'prenom', 'email', 'telephone', 'role', 'direction_id'));

    if ($request->filled('password')) {
        $request->validate(['password' => 'string|min:8|confirmed']);
        $utilisateur->update(['password' => Hash::make($request->password)]);
    }

    return redirect()->route('admin.utilisateurs.index')
        ->with('success', 'Utilisateur mis à jour.');
}

    public function destroy(User $utilisateur)
    {
        $utilisateur->delete(); 
        return redirect()->route('admin.utilisateurs.index')
            ->with('success', 'Utilisateur supprimé.');
    }

   
    public function valider(User $user)
{
    $user->update([
        'email_verified_at' => now()
    ]);

    return back()->with('success', 'Responsable validé');
}


    public function rejeter(User $user)
    {
        // Supprimer ou désactiver
        $user->delete();
        return back()->with('success', 'Responsable rejeté.');
    }
}