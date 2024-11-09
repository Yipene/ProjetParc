<!-- Bouton pour voir les détails -->
<button type="button" class="btn btn-info" data-toggle="modal" data-target="#detailsModal{{ $maintenance->id }}">
    <i data-feather="eye"></i>
</button>

<!-- Modal pour les détails de la maintenance -->
<div class="modal fade" id="detailsModal{{ $maintenance->id }}" tabindex="-1" role="dialog"
    aria-labelledby="detailsModalLabel{{ $maintenance->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailsModalLabel{{ $maintenance->id }}">Info</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul class="list-unstyled">
                    <li><strong>Nom du Client :</strong>
                        {{ $maintenance->equipement->client->nom }}
                        {{ $maintenance->equipement->client->prenom }}</li>
                    <li><strong>Téléphone du Client :</strong>
                        {{ $maintenance->equipement->client ? $maintenance->equipement->client->telephone : 'Non défini' }}
                    </li>
                    <li><strong>Equipement :</strong>
                        {{ $maintenance->equipement->typeEquipement->nom_type }}
                    </li>
                    <li><strong>Marque :</strong>
                        {{ $maintenance->equipement ? $maintenance->equipement->marque : 'Non défini' }}
                    </li>
                    <li><strong>Modèle :</strong>
                        {{ $maintenance->equipement ? $maintenance->equipement->modele : 'Non défini' }}
                    </li>
                    <li><strong>Numéro de Série :</strong>
                        {{ $maintenance->equipement ? $maintenance->equipement->numero_serie : 'Non défini' }}
                    </li>
                    <li><strong>Date de Réparation :</strong>
                        {{ $maintenance->date_reparation ? $maintenance->date_reparation->format('d-m-Y H:i') : 'Non défini' }}
                    </li>

                    <li><strong>Panne :</strong> {{ $maintenance->panne }}
                    </li>
                    <li><strong>Action de Réparation :</strong>
                        {{ $maintenance->action_reparation }}</li>
                    <li><strong>Date de Fin de Réparation :</strong>
                        {{ $maintenance->date_fin_reparation ? $maintenance->date_fin_reparation->format('d-m-Y') : 'Non défini' }}
                    </li>
                    <li><strong>Observations :</strong>
                        {{ $maintenance->observations }}</li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>
