<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NiveauExperience;
use Illuminate\Http\Request;

class NiveauExperienceController extends Controller
{
    public function index()
    {
        $niveauExperiences = NiveauExperience::all();
        return view('admin.niveau-experiences.index', compact('niveauExperiences'));
    }

    public function store(Request $request)
    {
        $request->validate(['nom' => 'required|string|unique:niveau_experiences']);
        NiveauExperience::create($request->all());
        return redirect()->route('admin.niveau-experiences.index')->with('success', 'Niveau créé.');
    }

    public function update(Request $request, NiveauExperience $niveauExperience)
    {
        $request->validate(['nom' => 'required|string|unique:niveau_experiences,nom,' . $niveauExperience->id]);
        $niveauExperience->update($request->all());
        return redirect()->route('admin.niveau-experiences.index')->with('success', 'Niveau mis à jour.');
    }

    public function destroy(NiveauExperience $niveauExperience)
    {
        $niveauExperience->delete();
        return redirect()->route('admin.niveau-experiences.index')->with('success', 'Niveau supprimé.');
    }
}