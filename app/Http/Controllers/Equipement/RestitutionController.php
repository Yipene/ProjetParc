<?php

namespace App\Http\Controllers\Equipement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Equipement\Restitution;
use App\Models\Equipement\TypeEquipement;
use App\Models\Equipement\Equipement;
use App\Models\Equipement\Dotation;

class RestitutionController extends Controller
{

    public function listeDotation()
    {
        // Récupérer toutes les dotations avec les détails des équipements et services associés
        $dotations = Dotation::with(['equipement', 'service'])->get();

        // Récupérer la liste des équipements qui ont un statut acquisition pour le formulaire
        $equipements = Equipement::where('statut', 'acquisition')->get();

        // Calculer le total des équipements dotés
        $totalDotedQuantity = Equipement::where('statut', 'dotation')->sum('quantite');

        return view('gestionnaire.backend.dotations', compact('dotations', 'equipements', 'totalDotedQuantity'));
    }
    //
    public function createRestitution(Request $request, $dotationId)
    {
        $validatedData = $request->validate([
            'date_restitution' => 'required|date',
            'condition_equipement' => 'required|string',
            'commentaires' => 'nullable|string',
        ]);

        Restitution::create([
            'dotation_id' => $dotationId,
            'date_restitution' => $validatedData['date_restitution'],
            'condition_equipement' => $validatedData['condition_equipement'],
            'commentaires' => $validatedData['commentaires'],
        ]);

        return redirect()->back()->with('success', 'Restitution enregistrée avec succès.');
    }
}
