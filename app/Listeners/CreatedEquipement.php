<?php

namespace App\Listeners;

use App\Events\ClientCreated;
use App\Models\Atelier\Equipment;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateEquipement
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ClientCreated $event)
    {
        $client = $event->client;

        Equipment::create([
            'marque' => $client->marque,
            'modele' => $client->modele,
            'numero_serie' => $client->numero_serie,
            'type_id' => $client->type_equipement_id,
            'statut' => 'En Attente',
        ]);
    }
}
