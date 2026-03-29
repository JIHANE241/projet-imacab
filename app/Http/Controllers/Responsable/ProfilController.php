<?php

namespace App\Http\Controllers\Responsable;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfilController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('responsable.profil.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'prenom' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'telephone' => 'nullable|string|max:20',
            'photo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('photos', 'public');
            $validated['photo'] = $path;
        }

        $user->update($validated);

        return back()->with('success', 'Profil mis à jour.');
    }

    public function updatePassword(Request $request)
{
    $request->validate([
        'current_password' => 'required|current_password',
        'new_password' => 'required|min:8|confirmed',
    ]);

    Auth::user()->update([
        'password' => Hash::make($request->new_password),
    ]);

    return back()->with('success', 'Mot de passe modifié avec succès.');
}
}