<?php

namespace App\Http\Controllers\Equipement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Equipement\TypeEquipement;
use App\Models\Equipement\Equipement;
use App\Models\Equipement\Restitution;
use App\Models\Equipement\Dotation;
use App\Models\Service\Service;
use Dompdf\Dompdf;

class DotationController extends Controller
{
    public function listeDotation(Request $request)
    {
        $type_equipement_id = $request->input('type_equipement');
        $service_id = $request->input('service');

        // Récupérer les dotations avec les conditions de filtrage
        $dotations = Dotation::with(['equipement', 'service'])
            ->whereHas('equipement', function ($query) use ($type_equipement_id) {
                if ($type_equipement_id) {
                    // Appliquer le filtre par type d'équipement seulement si présent
                    $query->where('type_equipement_id', $type_equipement_id);
                }
                // Vérifier que le statut est "dotation"
                $query->where('statut', 'dotation');
            })->get()
            ->unique(function ($dotation) {
                // Éviter la duplication des équipements par numéro de série
                return $dotation->equipement->numero_serie;
            });

        // Si c'est une requête AJAX, retourner uniquement la partie filtrée
        if ($request->ajax()) {
            return view('gestionnaire.backend.dotations_list', compact('dotations'))->render();
        }

        // Récupérer les données pour les filtres
        $types = TypeEquipement::all();
        $services = Service::all();
        $equipements = Equipement::whereIn('statut', ['acquisition', 'restitution'])->get();
        $totalDotedQuantity = Equipement::where('statut', 'dotation')->sum('quantite');

        // Afficher la vue avec les dotations filtrées
        return view('gestionnaire.backend.dotations', compact('dotations', 'types', 'services', 'equipements', 'totalDotedQuantity'));
    }



    public function GenererPDFDotations(Request $request)
    {
        // Récupérer toutes les dotations sans filtrage
        $dotations = Dotation::with(['equipement', 'service'])
            ->whereHas('equipement', function ($query) {
                $query->where('statut', 'dotation'); // Assurez-vous que le statut est 'dotation'
            })
            ->get()
            ->unique(function ($dotation) {
                return $dotation->equipement->numero_serie; // Assurez-vous que chaque équipement a un numéro de série unique
            });

        // Générer le contenu du PDF
        $html = view('gestionnaire.backend.pdf_dotations', compact('dotations'))->render();

        // Instancier Dompdf
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);

        // (Optionnel) Définir la taille du papier et l'orientation
        $dompdf->setPaper('A4', 'landscape');

        // Rendre le PDF
        $dompdf->render();

        // Télécharger le PDF
        return $dompdf->stream('dotations.pdf');

        // Si vous souhaitez déboguer, décommentez cette ligne
        // dd($dotations);
    }







    public function StoreDotation(Request $request)
    {
        // Valider les données
        $validated = $request->validate([
            'beneficiare' => 'required|string|max:255',
            'date_dotation' => 'required|date',
            'equipements.*.equipement_id' => 'required|exists:equipements,id',
            'equipements.*.marque' => 'required|string|max:255',
            'equipements.*.modele' => 'required|string|max:255',
            'equipements.*.numero_serie' => 'required|string|max:255',
            'equipements.*.quantite_dotee' => 'required|integer|min:1',
        ]);

        // Enregistrer les dotations
        foreach ($request->equipements as $equipementData) {
            $equipement = Equipement::findOrFail($equipementData['equipement_id']);

            // Mettre à jour la quantité disponible de l'équipement
            $equipement->quantite = $equipementData['quantite_dotee'];



            $equipement->statut = 'dotation'; // Changer le statut en "dotation"


            $equipement->save();

            // Créer la dotation
            Dotation::create([
                'user_id' => auth()->id(),
                'equipement_id' => $equipementData['equipement_id'],
                'service_id' => $request->service_id,
                'date_dotation' => $request->date_dotation,
                'beneficiare' => $request->beneficiare,
                'observations' => $request->observations,
                'quantite' => $equipementData['quantite_dotee'],
            ]);
        }

        return redirect()->route('liste.dotation')->with('success', 'Dotation enregistrée avec succès.');
    }


    public function StockDotation()
    {
        // Récupérer les stocks groupés par type d'équipement avec la somme des quantités
        $stock = Equipement::join('type_equipements', 'equipements.type_equipement_id', '=', 'type_equipements.id')
            ->where('statut', 'dotation')
            ->selectRaw('type_equipements.nom_type, SUM(equipements.quantite) as quantite_totale')
            ->groupBy('equipements.type_equipement_id', 'type_equipements.nom_type')
            ->get();

        return view('gestionnaire.backend.dotation_stock', compact('stock'));
    }

    public function StockDotagraph()
    {
        // Récupérer les données de stock groupées par type d'équipement uniquement pour les dotations
        $stock = Equipement::join('type_equipements', 'equipements.type_equipement_id', '=', 'type_equipements.id')
            ->where('equipements.statut', 'dotation')  // On filtre seulement les équipements en dotation
            ->selectRaw('type_equipements.nom_type as label, SUM(equipements.quantite) as data')
            ->groupBy('equipements.type_equipement_id', 'type_equipements.nom_type')
            ->get();

        // Vérification des données si nécessaire
        if ($stock->isEmpty()) {
            return response()->json(['error' => 'Aucune donnée disponible'], 404);
        }

        // Retourner les données sous forme JSON pour le graphique
        return response()->json($stock);
    }


    public function restituerDotation(Request $request, $id)
    {
        // Validation des données
        $request->validate([
            'date_restitution' => 'required|date',
            'motif' => 'required|string',
            'condition_equipement' => 'required|string',
            'commentaires' => 'nullable|string',
        ]);

        // Récupérer la dotation
        $dotation = Dotation::findOrFail($id);

        // Récupérer l'équipement lié à la dotation
        $equipement = $dotation->equipement;

        // Changer le statut de l'équipement en "Acquisition"
        $equipement->statut = 'Acquisition';
        $equipement->save(); // Sauvegarder la modification du statut

        // Créer une nouvelle entrée pour la restitution
        $restitution = new Restitution();
        $restitution->dotation_id = $dotation->id;
        $restitution->date_restitution = $request->date_restitution;
        $restitution->motif = $request->motif;
        $restitution->condition_equipement = $request->condition_equipement;
        $restitution->commentaires = $request->commentaires;
        $restitution->save();

        // Rediriger avec un message de succès
        return redirect()->route('liste.dotation')->with('success', 'Dotation restituée et équipement retourné en stock.');
    }
}
