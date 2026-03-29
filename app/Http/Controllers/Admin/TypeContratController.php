<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TypeContrat;
use Illuminate\Http\Request;

class TypeContratController extends Controller
{
    public function index()
    {
        $typeContrats = TypeContrat::all();
        return view('admin.type-contrats.index', compact('typeContrats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255|unique:type_contrats',
        ]);

        TypeContrat::create($request->all());

        return redirect()->route('admin.type-contrats.index')
            ->with('success', 'Type de contrat créé avec succès.');
    }

    public function update(Request $request, TypeContrat $typeContrat)
    {
        $request->validate([
            'nom' => 'required|string|max:255|unique:type_contrats,nom,' . $typeContrat->id,
        ]);

        $typeContrat->update($request->all());

        return redirect()->route('admin.type-contrats.index')
            ->with('success', 'Type de contrat mis à jour.');
    }

    public function destroy(TypeContrat $typeContrat)
    {
        $typeContrat->delete();

        return redirect()->route('admin.type-contrats.index')
            ->with('success', 'Type de contrat supprimé.');
    }
}