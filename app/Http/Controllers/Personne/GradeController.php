<?php

namespace App\Http\Controllers\Personne;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Grade\Grade;

class GradeController extends Controller
{
    public function ListeGrade()
    {

        $grades = Grade::latest()->get();
        return view("admin.backend.Grade.grade", compact("grades"));
    }

    public function StoreGrade(Request $request)
    {
        // Validation
        $request->validate([
            'nom_grade' => 'required|unique:grades|max:30',

        ]);

        Grade::insert([
            'nom_grade' => $request->nom_grade,
        ]);

        $notification = array(
            'message' => 'Ajout Réussi',
            'alert-type' => 'success'
        );

        return redirect()->route('liste.grade')->with($notification);
    }

    public function UpdateGrade(Request $request)
    {
        $pid = $request->id;

        Grade::findorFail($pid)->update([

            "nom_grade" => $request->nom_grade,
        ]);

        $notification = array(
            'message' => 'Modification Réussie',
            'alert-type' => 'success'
        );

        return redirect()->route('liste.grade')->with($notification);
    }

    public function DeleteGrade($id)
    {
        Grade::findorFail($id)->delete();

        $notification = array(
            'message' => 'Suppression Réussie',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }
}
