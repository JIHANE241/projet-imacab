<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    public function edit()
    {
        $user = auth()->user();
        return view('admin.profil.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'prenom' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'telephone' => 'nullable|string|max:20',
            'photo' => 'nullable|image|max:2048',
        ]);

        $data = $request->only('name', 'prenom', 'email', 'telephone');

        if ($request->hasFile('photo')) {
          
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            $path = $request->file('photo')->store('profils', 'public');
            $data['photo'] = $path;
        }

        $user->update($data);

        return back()->with('success', 'Profil mis à jour.');
    }

    public function updatePassword(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'current_password' => 'required|current_password',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user->update(['password' => Hash::make($request->new_password)]);

        return back()->with('success', 'Mot de passe changé.');
    }
}