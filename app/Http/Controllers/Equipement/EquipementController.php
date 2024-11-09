<?php

namespace App\Http\Controllers\Equipement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Equipement\Equipement;
use App\Models\Equipement\TypeEquipement;

class EquipementController extends Controller

{
    public function EquipementListe()
    {

        $equipements = Equipement::with('TypeEquipement')->latest()->get();// ici type c'est la function du modele Equipement
        return view("Equipement.Liste_Equipement", compact("equipements"));
    }

    public function EquipementAjout()
    {
        $typeEquipements = TypeEquipement::all();
        return view("Equipement.Ajout_Equipement" , compact("typeEquipements"));
    }

    public function StoreEquipement(Request $request)
    {
        // Validation
        $request->validate([
            'marque'=>'required',
            'modele'=>'required',
            'numero_serie'=>'required|unique:equipements|max:30',
            'type_id'=>'required',


        ]);

        Equipement::insert([
            'marque'=>$request->marque,
            'modele'=>$request->modele,
            'numero_serie'=>$request->numero_serie,
            'type_id'=>$request->type_id,
        ]);

        $notification = array(
            'message' => 'Ajout Réussi',
            'alert-type' => 'success'
        );

        return redirect()->route('liste.equipement')->with($notification);
    }

    public function ModifierEquipement($id)
    {
        $types = Equipement::findorFail($id);

        return view('Equipement.modifier_Equipement', compact("types"));
    }

    public function UpdateEquipement(Request $request)
    {
        $pid = $request->id;

        Equipement::findorFail($pid)->update([

            'marque'=>$request->marque,
            'modele'=>$request->modele,
            'numero_serie'=>$request->numero_serie,
            'type_id'=>$request->type_id,
            ]);

        $notification = array(
            'message' => 'Mis A Jour Réussie',
            'alert-type' => 'success'
        );

        return redirect()->route('liste.equipement')->with($notification);
    }

    public function DeleteEquipement($id)
    {
        Equipement::findorFail($id)->delete();

        $notification = array(
            'message' => 'Suppression Réussie',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }
}
