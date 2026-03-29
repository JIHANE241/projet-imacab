<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\TypeContrat;
use App\Models\NiveauExperience;
use App\Models\Ville;

class ParametreController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $typeContrats = TypeContrat::all();
        $niveauExperiences = NiveauExperience::all();
        $villes = Ville::all();

        return view('admin.parametres.index', compact('categories', 'typeContrats', 'niveauExperiences', 'villes'));
    }
}