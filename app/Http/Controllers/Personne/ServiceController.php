<?php

namespace App\Http\Controllers\Personne;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service\Service;

class ServiceController extends Controller
{
    public function ListeService()
    {

        $services = Service::latest()->get();
        return view("admin.backend.Service.service", compact("services"));
    }

    public function StoreService(Request $request)
    {
        // Validation
        $request->validate([
            'nom_service' => 'required|unique:services|max:30',

        ]);

        Service::insert([
            'nom_service' => $request->nom_service,
        ]);

        $notification = array(
            'message' => 'Ajout Réussi',
            'alert-type' => 'success'
        );

        return redirect()->route('liste.service')->with($notification);
    }

    public function UpdateService(Request $request)
    {
        $pid = $request->id;

        Service::findorFail($pid)->update([

            "nom_service" => $request->nom_service,
        ]);

        $notification = array(
            'message' => 'Modification Réussie',
            'alert-type' => 'success'
        );

        return redirect()->route('liste.service')->with($notification);
    }

    public function DeleteService($id)
    {
        Service::findorFail($id)->delete();

        $notification = array(
            'message' => 'Suppression Réussie',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }
}
