<?php

namespace App\Http\Controllers\Candidat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Formation;
use App\Models\Experience;
use App\Models\Competence;
use App\Models\Langue;
use App\Models\NiveauEtude;

class CVController extends Controller
{
    public function edit()
    {
        $user = Auth::user(); 
        $formations = $user->formations()->orderBy('debut_annee', 'desc')->get();
        $experiences = $user->experiences()->orderBy('debut_annee', 'desc')->get();
        $competences = $user->competences;
        $languesUser = $user->langues()->withPivot('niveau')->get();
        $niveauxEtudes = NiveauEtude::all();
        $langues = Langue::all();
      
        $offresSuggestions = collect();

        return view('candidat.cv.edit', compact(
            'user', 'formations', 'experiences', 'competences', 'languesUser',
            'niveauxEtudes', 'langues', 'offresSuggestions'
        ));
    }

    public function update(Request $request)
    {
        $user = Auth::user(); 

        // Mise à jour des champs simples de l'utilisateur
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('photos', 'public');
            $user->photo = $path;
        }
        $user->niveau_etude_id = $request->niveau_etude_id;
        $user->niveau_experience_global = $request->niveau_experience_global;
        $user->save();

        // Traitement des formations
        $user->formations()->delete();
        if ($request->has('formations')) {
            foreach ($request->formations as $data) {
                if (!empty($data['titre'])) {
                    $formation = new Formation($data);
                    $formation->user_id = $user->id;
                    $formation->save();
                }
            }
        }

        // Traitement des expériences
        $user->experiences()->delete();
        if ($request->has('experiences')) {
            foreach ($request->experiences as $data) {
                if (!empty($data['poste'])) {
                    $experience = new Experience($data);
                    $experience->user_id = $user->id;
                    $experience->save();
                }
            }
        }

        // Traitement des compétences
        if ($request->filled('competences')) {
            $competencesNoms = array_map('trim', explode(',', $request->competences));
            $competenceIds = [];
            foreach ($competencesNoms as $nom) {
                if (!empty($nom)) {
                    $competence = Competence::firstOrCreate(['nom' => $nom]);
                    $competenceIds[] = $competence->id;
                }
            }
            $user->competences()->sync($competenceIds);
        }

        // Traitement des langues
        if ($request->has('langues')) {
            $languesData = [];
            foreach ($request->langues as $langue) {
                if (!empty($langue['langue_id'])) {
                    $languesData[$langue['langue_id']] = ['niveau' => $langue['niveau']];
                }
            }
            $user->langues()->sync($languesData);
        }

        return redirect()->route('candidat.cv.edit')->with('success', 'CV mis à jour avec succès.');
    }
}