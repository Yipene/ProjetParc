<?php

namespace App\Http\Controllers\Atelier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Technicien;
use App\Models\Grade\Grade;
use Illuminate\Support\Facades\Hash;

class AtelierController extends Controller
{
    public function AtelierDashboard()
    {

        return view('atelier.index');
    } //Fin method adminDashboard


    public function AtelierLogout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/Page/Login');
    }

    public function AtelierLogin()
    {
        return view('atelier.atelier_login');
    } //Fin method adminDashboard

    public function AtelierProfile()
    {

        $id = Auth::user()->id;
        $profileData = User::find($id);
        return view('atelier.atelier_profile_view', compact('profileData'));
    }

    public function AtelierProfileStore(Request $request)
    {
        $id = Auth::user()->id;
        $data = User::find($id);
        $data->name = $request->name;
        $data->prenom = $request->prenom;
        $data->email = $request->email;
        $data->telephone = $request->telephone;
        $data->adresse = $request->adresse;
        if ($request->file('photo')) {
            $file = $request->file('photo');
            @unlink(public_path('upload/atelier_images/' . $data->photo));
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('upload/atelier_images'), $filename);
            $data['photo'] = $filename;
        }
        $data->save();

        $notification = array(
            'message' => 'Mis a jour Réussie',
            'alert-type' => 'success'

        );

        return redirect()->back()->with($notification);
    }

    public function AtelierChangePassword()
    {

        $id = Auth::user()->id;
        $profileData = User::find($id);

        return view('atelier.atelier_change_password', compact('profileData'));
    }

    public function AtelierUpdatePassword(Request $request)
    {
        // Validation
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',

        ]);
        // Match old password
        if (!Hash::check($request->old_password, auth::user()->password)) {
            $notification = array(
                'message' => 'Erreur',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }

        // Match old password
        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);
        $notification = array(
            'message' => ' Mot de Passe Changer',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    ///////////////////////// TECHNICIEN DE L'ATELIER ////////////////////////////////

    // Liste des techniciens
    public function ListeTechnicien()
    {
        // Récupère tous les grades
        $grades = Grade::all();

        // Récupère tous les techniciens avec leur grade
        $techniciens = Technicien::with('grade')->latest()->get();

        // Passe les données à la vue
        return view("atelier.backend.technicien", compact("techniciens", 'grades'));
    }


    // Enregistrer un nouveau technicien
    public function StoreTechnicien(Request $request)
    {
        // Validation
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'grade_id' => 'required|exists:grades,id'
        ]);

        Technicien::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'grade_id' => $request->grade_id
        ]);

        $notification = array(
            'message' => 'Ajout Réussi',
            'alert-type' => 'success'
        );

        return redirect()->route('liste.technicien')->with($notification);
    }

    // Mettre à jour un technicien existant
    public function updateTechnicien(Request $request, $id)
    {
        // Validation
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'grade_id' => 'required|exists:grades,id'
        ]);

        // Trouver le technicien par son ID
        $technicien = Technicien::findOrFail($id);

        // Mise à jour des informations du technicien
        $technicien->update([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'grade_id' => $request->grade_id
        ]);

        // Notification de succès
        $notification = array(
            'message' => 'Mise à jour réussie',
            'alert-type' => 'success'
        );

        // Rediriger vers la liste des techniciens avec la notification
        return redirect()->route('liste.technicien')->with($notification);
    }


    // Supprimer un technicien
    public function DeleteTechnicien($id)
    {
        Technicien::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Suppression Réussie',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }
}
