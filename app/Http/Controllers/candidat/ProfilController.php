<?php

namespace App\Http\Controllers\Candidat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProfilController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('candidat.profil.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name' => 'required|string|max:255',
            'prenom' => 'nullable|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'telephone' => 'nullable|string|max:20',
            'photo' => 'nullable|image|max:2048',
        ]);

        $data = $request->only('name', 'prenom', 'email', 'telephone');
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('photos', 'public');
            $data['photo'] = $path;
        }
        $user->update($data);
        return back()->with('success', 'Profil mis à jour.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'new_password' => 'required|string|min:8|confirmed',
        ]);
        Auth::user()->update(['password' => Hash::make($request->new_password)]);
        return back()->with('success', 'Mot de passe changé.');
    }
}