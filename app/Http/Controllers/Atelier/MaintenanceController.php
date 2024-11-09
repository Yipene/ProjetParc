<?php

namespace App\Http\Controllers\Atelier;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Technicien;
use App\Models\Equipement\TypeEquipement;
use App\Models\Atelier\Maintenance;
use App\Models\Equipement\Equipement;
use App\Models\Grade\Grade;
use App\Models\Service\Service;
use Dompdf\Dompdf;

class MaintenanceController extends Controller
{
    public function ListeMaintenance(Request $request)
    {
        $type_equipement_id = $request->input('type_equipement');
        $technicien_id = $request->input('technicien');
        $service_id = $request->input('service');

        // Récupération des types, techniciens, grades et services
        $types = TypeEquipement::latest()->get();
        $techniciens = Technicien::latest()->get();
        $grades = Grade::all();
        $services = Service::all();

        // Application des filtres sur les maintenances
        $maintenances = Maintenance::with(['client', 'equipement'])
            ->when($type_equipement_id, function ($query, $type_equipement_id) {
                $query->whereHas('equipement', function ($q) use ($type_equipement_id) {
                    $q->where('type_equipement_id', $type_equipement_id);
                });
            })
            ->latest() // Ordre par date décroissante
            ->get();

        return view('atelier.backend.maintenance', compact('maintenances', 'techniciens', 'types', 'grades', 'services'));
    }



    public function GenererPDFMaintenance(Request $request)
    {
        $maintenances = Maintenance::with(['equipement', 'service'])
            ->whereHas('equipement', function ($query) {
                $query->where('statut', 'maintenance');
            })
            ->get()
            ->unique(function ($maintenance) {
                return $maintenance->equipement->numero_serie;
            });

        $html = view('gestionnaire.backend.pdf_maintenances', compact('maintenances'))->render();

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        return $dompdf->stream('maintenances.pdf');
    }





    public function StoreMaintenance(Request $request)
    {
        try {
            // Valider les données entrantes
            $request->validate([
                'nom' => 'required|string|max:255',
                'prenom' => 'required|string|max:255',
                'telephone' => 'required|string|max:20',
                'grade_id' => 'required|exists:grades,id',
                'service_id' => 'required|exists:services,id',
                'type_equipement_id' => 'required|exists:type_equipements,id',
                'panne' => 'required|string',
                'technicien_id' => 'required|exists:techniciens,id',
                'date_reprise' => 'nullable|date',
                'equipements.*.marque' => 'required|string|max:255',
                'equipements.*.modele' => 'required|string|max:255',
                'equipements.*.numero_serie' => 'required|string|max:255|unique:equipements,numero_serie',
                'equipements.*.quantite' => 'required|integer|min:1',
            ]);

            // Créer ou récupérer le client
            $client = Client::firstOrCreate([
                'nom' => $request->nom,
                'prenom' => $request->prenom,
                'telephone' => $request->telephone,
            ], [
                'grade_id' => $request->grade_id,
                'service_id' => $request->service_id,
            ]);

            // Enregistrement des équipements et des maintenances
            foreach ($request->equipements as $equipementData) {
                $equipement = Equipement::create([
                    'client_id' => $client->id,
                    'type_equipement_id' => $request->type_equipement_id,
                    'marque' => $equipementData['marque'],
                    'modele' => $equipementData['modele'],
                    'numero_serie' => $equipementData['numero_serie'],
                    'quantite' => $equipementData['quantite'],
                    'statut' => 'maintenance',
                ]);

                // Enregistrer la maintenance pour chaque équipement
                Maintenance::create([
                    'user_id' => auth()->id(),
                    'equipement_id' => $equipement->id,
                    'technicien_id' => $request->technicien_id,
                    'date_reparation' => now(),
                    'panne' => $request->panne,
                    'action_reparation' => $request->action_reparation,
                    'date_fin_reparation' => $request->date_reprise,
                    'observations' => $request->observations,
                    'statut' => 'En cours',
                ]);
            }

            // Notification de succès
            $notification = [
                'message' => 'Maintenance enregistrée avec succès',
                'alert-type' => 'success'
            ];

            // Redirection après succès
            return redirect()->route('liste.maintenance')->with($notification);
        } catch (\Exception $e) {
            // En cas d'erreur, enregistrer le message d'erreur dans les logs
            Log::error('Erreur lors de l\'enregistrement de la maintenance : ' . $e->getMessage());

            // Rediriger avec un message d'erreur
            return redirect()->back()->withErrors(['message' => 'Erreur lors de l\'enregistrement de la maintenance : ' . $e->getMessage()]);
        }
    }

    public function UpdateMaintenance(Request $request, $id)
    {
        try {
            // Valider les données entrantes
            $request->validate([
                'client_nom' => 'required|string|max:255',
                'client_prenom' => 'required|string|max:255',
                'telephone' => 'required|string|max:20',
                'type_equipement_id' => 'required|exists:type_equipements,id',
                'marque' => 'required|string|max:255',
                'modele' => 'required|string|max:255',
                'numero_serie' => 'required|string|max:255',
                'date_reparation' => 'required|date',
                'panne' => 'required|string',
                'action_reparation' => 'required|string',
                'date_fin_reparation' => 'nullable|date',
                'observations' => 'nullable|string',
            ]);

            // Trouver la maintenance
            $maintenance = Maintenance::findOrFail($id);

            // Mettre à jour les informations du client
            $client = $maintenance->equipement->client;
            $client->update([
                'nom' => $request->client_nom,
                'prenom' => $request->client_prenom,
                'telephone' => $request->telephone,
            ]);

            // Mettre à jour l'équipement
            $equipement = $maintenance->equipement;
            $equipement->update([
                'type_equipement_id' => $request->type_equipement_id,
                'marque' => $request->marque,
                'modele' => $request->modele,
                'numero_serie' => $request->numero_serie,
            ]);

            // Mettre à jour la maintenance
            $maintenance->update([
                'date_reparation' => $request->date_reparation,
                'panne' => $request->panne,
                'action_reparation' => $request->action_reparation,
                'date_fin_reparation' => $request->date_fin_reparation,
                'observations' => $request->observations,
            ]);

            // Notification de succès
            $notification = [
                'message' => 'Maintenance mise à jour avec succès',
                'alert-type' => 'success'
            ];

            // Redirection après succès
            return redirect()->route('liste.maintenance')->with($notification);
        } catch (\Exception $e) {
            // En cas d'erreur, enregistrer le message d'erreur dans les logs
            Log::error('Erreur lors de la mise à jour de la maintenance : ' . $e->getMessage());

            // Rediriger avec un message d'erreur
            return redirect()->back()->withErrors(['message' => 'Erreur lors de la mise à jour de la maintenance : ' . $e->getMessage()]);
        }
    }







    public function StoreStatut(Request $request, $id)

    {
        // Trouver la maintenance par son identifiant
        $maintenance = Maintenance::findOrFail($id);

        // Mettre à jour le statut
        $maintenance->statut = $request->statut;

        // Si le statut est "Terminé" ou "Annulé", mettre à jour la date de fin
        if ($request->statut == 'Terminé' || $request->statut == 'Annulé') {
            $maintenance->date_fin_reparation = now(); // Date actuelle
        } else {
            $maintenance->date_fin_reparation = null; // Remettre la date de fin à null pour d'autres statuts
        }

        // Sauvegarder les modifications
        $maintenance->save();

        // Notification de succès
        $notification = [
            'message' => 'Statut mis à jour avec succès',
            'alert-type' => 'success'
        ];

        // Rediriger vers la liste des maintenances avec une notification
        return redirect()->route('liste.maintenance')->with($notification);
    }



    // Supprimer une maintenance
    public function DeleteMaintenance($id)
    {
        $maintenance = Maintenance::findOrFail($id);
        $maintenance->delete();

        return redirect()->route('liste.maintenance')->with('success', 'Maintenance supprimée avec succès.');
    }


    ////////////// STOCK EQUIPEMENT EN MAINTENANCE ///////////

    public function Stock()
    {
        // Récupérer les stocks groupés par type d'équipement et par statut avec la somme des quantités
        $stock = Maintenance::select('equipements.type_equipement_id', 'maintenances.statut')
            ->join('equipements', 'maintenances.equipement_id', '=', 'equipements.id')
            ->join('type_equipements', 'equipements.type_equipement_id', '=', 'type_equipements.id')
            ->selectRaw('type_equipements.nom_type, maintenances.statut, SUM(equipements.quantite) as quantite_totale')
            ->groupBy('equipements.type_equipement_id', 'maintenances.statut', 'type_equipements.nom_type')
            ->get();

        return view('Equipement.stock', compact('stock'));
    }


    // Dans ton contrôleur

    public function MaintenanceStockGraphique()
    {
        // Récupérer les données de stock groupées par type d'équipement pour les équipements en maintenance
        $stock = Maintenance::join('equipements', 'maintenances.equipement_id', '=', 'equipements.id')
            ->join('type_equipements', 'equipements.type_equipement_id', '=', 'type_equipements.id')
            ->selectRaw('type_equipements.nom_type as label, SUM(equipements.quantite) as data')
            ->groupBy('equipements.type_equipement_id', 'type_equipements.nom_type')
            ->get();

        // Retourner les données sous forme JSON pour être utilisées dans le graphique
        return response()->json($stock);
    }
}
