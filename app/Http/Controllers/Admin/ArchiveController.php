<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Candidature;
use App\Models\Offre;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArchiveController extends Controller
{
    public function index()
    {
        // CV refusés : candidatures refusées avec CV
        $cvRefuses = Candidature::withTrashed()
         ->where('statut', 'refusee')
         ->whereNotNull('cv_path')
         ->with('candidat')
         ->get();

        // Offres fermées (soft delete ou statut fermée)
        $offresFermees = Offre::where('statut', 'fermée')->withTrashed()->get();

        // Offres supprimées (soft delete)
        $offresSupprimees = Offre::onlyTrashed()->get();

        /// Candidatures refusées (toutes, qu'elles soient supprimées ou non)
    $candidaturesRefusees = Candidature::withTrashed()
        ->where('statut', 'refusee')
        ->with('candidat', 'offre')
        ->get();

    return view('admin.archives.index', compact(
        'cvRefuses',
        'offresFermees',
        'offresSupprimees',
        'candidaturesRefusees'
    ));
    }

    public function restaurer($type, $id)
{
    switch ($type) {
        case 'offre':
            $offre = Offre::onlyTrashed()->findOrFail($id);
            $offre->restore();
            $offre->update(['statut' => 'brouillon']);
            break;
        case 'candidature':
            // 1. Chercher une candidature soft‑deleted
            $candidature = Candidature::onlyTrashed()->find($id);
            if ($candidature) {
                // Si elle est supprimée, on la restaure
                $candidature->restore();
            } else {
                // Sinon, on la cherche normalement et on change son statut
                $candidature = Candidature::findOrFail($id);
                $candidature->update(['statut' => 'en_attente']);
            }
            break;
        default:
            return back()->with('error', 'Type non pris en charge.');
    }

    return back()->with('success', 'Élément restauré.');
}

    public function supprimerDefinitivement($type, $id)
    {
        switch ($type) {
            case 'offre':
                $offre = Offre::onlyTrashed()->findOrFail($id);
                // Supprimer le CV des candidatures liées ? À gérer
                $offre->forceDelete();
                break;
            case 'candidature':
                $candidature = Candidature::onlyTrashed()->findOrFail($id);
                if ($candidature->cv_path) {
                    Storage::disk('public')->delete($candidature->cv_path);
                }
                $candidature->forceDelete();
                break;
            default:
                return back()->with('error', 'Type non pris en charge.');
        }

        return back()->with('success', 'Élément supprimé définitivement.');
    }
}