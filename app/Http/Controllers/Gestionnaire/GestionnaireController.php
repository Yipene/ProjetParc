<?php

namespace App\Http\Controllers\Gestionnaire;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class GestionnaireController extends Controller
{

    public function GestionnaireDashboard()
    {

        return view('gestionnaire.index');
    } //Fin method adminDashboard


    public function GestionnaireLogout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/Page/Login');
    }

    public function GestionnaireLogin()
    {
        return view('gestionnaire.gestionnaire_login');
    } //Fin method adminDashboard

    public function GestionnaireProfile()
    {

        $id = Auth::user()->id;
        $profileData = User::find($id);
        return view('gestionnaire.gestionnaire_profile_view', compact('profileData'));
    }

    public function GestionnaireProfileStore(Request $request)
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
            @unlink(public_path('upload/gestionnaire_images/' . $data->photo));
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('upload/gestionnaire_images'), $filename);
            $data['photo'] = $filename;
        }
        $data->save();

        $notification = array(
            'message' => 'Mis a jour Réussie',
            'alert-type' => 'success'

        );

        return redirect()->back()->with($notification);
    }

    public function GestionnaireChangePassword()
    {

        $id = Auth::user()->id;
        $profileData = User::find($id);

        return view('gestionnaire.gestionnaire_change_password', compact('profileData'));
    }

    public function GestionnaireUpdatePassword(Request $request)
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

}
