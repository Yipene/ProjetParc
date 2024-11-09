<?php

namespace App\Http\Controllers\Equipement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Equipement\TypeEquipement;

class TypeEquipementController extends Controller
{
    public function EquipementType()
    {

        $types = TypeEquipement::latest()->get();
        return view("Equipement.Type.all_type", compact("types"));
    }

    public function StoreType(Request $request)
    {
        // Validation
        $request->validate([
            'nom_type' => 'required|unique:type_equipements|max:30',
        ]);

        TypeEquipement::insert([
            'nom_type' => $request->nom_type,  // Correction du champ
        ]);

        $notification = array(
            'message' => 'Ajout Réussi',
            'alert-type' => 'success'
        );

        return redirect()->route('liste.type')->with($notification);
    }

    public function ModifierType($id)
    {
        $types = TypeEquipement::findorFail($id);

        return view('Equipement.Type.modifier_type', compact("types"));
    }


    public function UpdateType(Request $request)
    {
        $pid = $request->id;

        TypeEquipement::findorFail($pid)->update([

            "nom_type" => $request->nom_type,
        ]);

        $notification = array(
            'message' => 'Modification Réussie',
            'alert-type' => 'success'
        );

        return redirect()->route('equipement.type')->with($notification);
    }

    public function DeleteType($id)
    {
        TypeEquipement::findorFail($id)->delete();

        $notification = array(
            'message' => 'Suppression Réussie',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }
}
