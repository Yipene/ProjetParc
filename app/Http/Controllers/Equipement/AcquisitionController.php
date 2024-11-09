<?php

namespace App\Http\Controllers\Equipement;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Equipement\TypeEquipement;
use App\Models\Equipement\Equipement;
use App\Models\Equipement\Acquisition;
use Spatie\LaravelPdf\Pdf;
use Dompdf\Dompdf;
use App\Models\Service\Service;
use Illuminate\Support\Facades\Auth;

class AcquisitionController extends Controller
{
    public function listeAcquisition(Request $request)
    {
        // Récupération des types d'équipements pour le formulaire de filtre
        $types = TypeEquipement::latest()->get();

        // Récupération du type d'équipement sélectionné depuis le formulaire
        $type_equipement_id = $request->input('type_equipement');

        // Si un type d'équipement est sélectionné, filtrer les acquisitions par type
        if ($type_equipement_id) {
            $acquisitions = Acquisition::with('equipement')
                ->whereHas('equipement', function ($query) use ($type_equipement_id) {
                    $query->where('type_equipement_id', $type_equipement_id)
                        ->whereIn('statut', ['acquisition', 'restitution']); // Filtrer par statut
                })
                ->latest()
                ->get();
        } else {
            // Sinon, récupérer toutes les acquisitions avec les statuts "acquisition" et "restitution"
            $acquisitions = Acquisition::with('equipement')
                ->whereHas('equipement', function ($query) {
                    $query->whereIn('statut', ['acquisition', 'restitution']); // Filtrer par statut
                })
                ->latest()
                ->get();
        }

        // Si c'est une requête AJAX, on renvoie directement les données JSON
        if ($request->ajax()) {
            return response()->json([
                'acquisitions' => $acquisitions
            ]);
        }

        // Sinon, on renvoie la vue complète
        return view('gestionnaire.backend.acquisitions', compact('types', 'acquisitions'));
    }



    public function GenererPDF()
    {
        // Récupérer le filtre depuis la requête
        $type_equipement_id = request('type_equipement');

        // Récupérer les acquisitions en fonction du filtre et du statut "acquisition"
        $query = Acquisition::with('equipement') // Charger la relation avec les équipements
            ->whereHas('equipement', function ($q) use ($type_equipement_id) {
                $q->where('statut', ['acquisition', 'restitution']); // Filtrer uniquement les équipements avec le statut "acquisition"

                // Appliquer le filtre par type d'équipement si un type est sélectionné
                if ($type_equipement_id) {
                    $q->where('type_equipement_id', $type_equipement_id);
                }
            });

        // Récupérer les acquisitions filtrées
        $acquisitions = $query->get();

        // Générer le contenu du PDF
        $html = view('gestionnaire.backend.pdf', compact('acquisitions'))->render();

        // Instancier Dompdf
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);

        // (Optionnel) Définir la taille du papier et l'orientation
        $dompdf->setPaper('A4', 'landscape');

        // Rendre le PDF
        $dompdf->render();

        // Télécharger le PDF
        return $dompdf->stream('acquisitions.pdf');
    }



    public function StoreAcquisition(Request $request)
    {
        try {
            // Valider les données entrantes
            $request->validate([
                'type_equipement_id' => 'required|exists:type_equipements,id',
                'provenance' => 'nullable|string|max:255',
                'observations' => 'nullable|string|max:255',
                // Validation pour les équipements dynamiques
                'equipements.*.marque' => 'required|string|max:255',
                'equipements.*.modele' => 'required|string|max:255',
                'equipements.*.numero_serie' => 'required|string|max:255|unique:equipements,numero_serie',
                'equipements.*.quantite' => 'required|integer|min:1',
            ]);


            // Enregistrement des équipements et des acquisitions
            foreach ($request->equipements as $equipementData) {
                // Création de l'équipement
                $equipement = Equipement::create([
                    'type_equipement_id' => $request->type_equipement_id,
                    'marque' => $equipementData['marque'],
                    'modele' => $equipementData['modele'],
                    'numero_serie' => $equipementData['numero_serie'],
                    'quantite' => $equipementData['quantite'],
                    'statut' => 'acquisition', // Statut par défaut pour un équipement acquis
                ]);

                // Création de l'acquisition pour chaque équipement
                Acquisition::create([
                    'user_id' => auth()->id(), // ID de l'utilisateur authentifié
                    'equipement_id' => $equipement->id,
                    'date_acquisition' => now(),
                    'provenance' => $request->provenance,
                    'observations' => $request->observations,
                ]);
            }

            // Notification de succès
            $notification = [
                'message' => 'Acquisition enregistrée avec succès',
                'alert-type' => 'success'
            ];

            return redirect()->route('liste.acquisition')->with($notification);
        } catch (\Exception $e) {
            // En cas d'erreur, enregistrer le message d'erreur dans les logs
            Log::error('Erreur lors de l\'enregistrement de l\'acquisition : ' . $e->getMessage());

            // Rediriger avec un message d'erreur
            return redirect()->back()->withErrors(['message' => 'Erreur lors de l\'enregistrement de l\'acquisition : ' . $e->getMessage()]);
        }
    }

    public function UpdateAcquisition(Request $request, $id)
    {
        $request->validate([
            'type_equipement_id' => 'required|exists:type_equipements,id',
            'provenance' => 'nullable|string|max:255',
            'observations' => 'nullable|string|max:255',
            'marque' => 'required|string|max:255',
            'modele' => 'required|string|max:255',
            'numero_serie' => 'required|string|max:255'
        ]);

        $acquisition = Acquisition::findOrFail($id);
        $equipement = $acquisition->equipement;

        // Mise à jour de l'équipement
        $equipement->update([
            'type_equipement_id' => $request->type_equipement_id,
            'marque' => $request->marque,
            'modele' => $request->modele,
            'numero_serie' => $request->numero_serie,
        ]);

        // Mise à jour de l'acquisition
        $acquisition->update([
            'provenance' => $request->provenance,
            'observations' => $request->observations,
        ]);

        $notification = [
            'message' => 'Acquisition mise à jour avec succès',
            'alert-type' => 'success'
        ];

        return redirect()->route('liste.acquisition')->with($notification);
    }


    public function StockAcquisition()
    {
        // Récupérer les stocks groupés par type d'équipement avec la somme des quantités
        $stock = Equipement::join('type_equipements', 'equipements.type_equipement_id', '=', 'type_equipements.id')
            ->whereIn('statut', ['acquisition', 'restitution']) // Inclure aussi les équipements restitués
            ->selectRaw('type_equipements.nom_type, SUM(equipements.quantite) as quantite_totale')
            ->groupBy('equipements.type_equipement_id', 'type_equipements.nom_type')
            ->get();

        return view('gestionnaire.backend.acquisition_stock', compact('stock'));
    }

    public function StockGraphique()
    {
        // Récupérer les données de stock groupées par type d'équipement
        $stock = Equipement::join('type_equipements', 'equipements.type_equipement_id', '=', 'type_equipements.id')
            ->whereIn('statut', ['acquisition', 'restitution']) // Utiliser whereIn pour plusieurs statuts
            ->selectRaw('type_equipements.nom_type as label, SUM(equipements.quantite) as data')
            ->groupBy('equipements.type_equipement_id', 'type_equipements.nom_type')
            ->get();

        // Retourner les données sous forme JSON pour être utilisées dans le graphique
        return response()->json($stock);
    }

}
