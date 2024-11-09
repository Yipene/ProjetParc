<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Equipement\Equipement;
use App\Models\Equipement\Acquisition;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{

    // Afficher tous les utilisateurs
    public function index()
    {
        $users = User::all(); // Récupérer tous les utilisateurs
        return view('admin.users.index', compact('users')); // Retourner la vue avec les utilisateurs
    }

    // Afficher le formulaire de création d'un utilisateur
    public function create()
    {
        return view('admin.users.create'); // Retourner la vue du formulaire de création
    }

    // Stocker un nouvel utilisateur
    public function store(Request $request)
    {
        // Validation des données
        $request->validate([
            'name' => 'required',
            'prenom' => 'nullable',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'role' => 'required|in:admin,gestionnaire,technicien',
            'statut' => 'required|in:actif,inactif',
        ]);

        // Création de l'utilisateur
        User::create([
            'name' => $request->name,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Hachage du mot de passe
            'role' => $request->role,
            'statut' => $request->statut,
        ]);

        return redirect()->route('admin.users.liste')->with('success', 'Utilisateur créé avec succès.');
    }

    // Afficher le formulaire d'édition d'un utilisateur
    public function edit($id)
    {
        $user = User::findOrFail($id); // Récupérer l'utilisateur
        return view('admin.users.edit', compact('user')); // Retourner la vue avec l'utilisateur
    }

    // Mettre à jour un utilisateur
    public function update(Request $request, $id)
    {
        // Validation des données
        $request->validate([
            'name' => 'required',
            'prenom' => 'nullable',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:admin,gestionnaire,technicien',
            'statut' => 'required|in:actif,inactif',
        ]);

        $user = User::findOrFail($id); // Récupérer l'utilisateur
        $user->update($request->all()); // Mettre à jour l'utilisateur

        return redirect()->route('admin.users.liste')->with('success', 'Utilisateur mis à jour avec succès.');
    }

    // Supprimer un utilisateur
    public function destroy($id)
    {
        $user = User::findOrFail($id); // Récupérer l'utilisateur
        $user->delete(); // Supprimer l'utilisateur

        return redirect()->route('admin.users.liste')->with('success', 'Utilisateur supprimé avec succès.');
    }

    public function AdminStockAcquisition()
    {
        // Récupérer les stocks groupés par type d'équipement avec la somme des quantités
        $stock = Equipement::join('type_equipements', 'equipements.type_equipement_id', '=', 'type_equipements.id')
            ->whereIn('statut', ['acquisition', 'restitution']) // Inclure aussi les équipements restitués
            ->selectRaw('type_equipements.nom_type, SUM(equipements.quantite) as quantite_totale')
            ->groupBy('equipements.type_equipement_id', 'type_equipements.nom_type')
            ->get();
        // Vue spécifique pour l'administrateur
        return view('admin.backend.acquisition_stock', compact('stock'));
    }

    public function AdminStockGraphique()
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










    public function assignRole(Request $request, User $user)
    {
        // Valide le rôle reçu
        $validator = Validator::make($request->all(), [
            'role' => 'required|in:admin,gestionnaire,technicien',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Invalid role'], 422);
        }

        // Assigne le rôle à l'utilisateur
        $user->role = $request->role;
        $user->save();

        return response()->json(['message' => 'Role assigned successfully'], 200);
    }
}
