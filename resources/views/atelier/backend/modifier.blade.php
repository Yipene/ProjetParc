<!-- Bouton pour modifier les détails -->
<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#editModal{{ $maintenance->id }}">
    <i data-feather="edit"></i>
</button>

<!-- Modal pour la modification de la maintenance -->
<div class="modal fade" id="editModal{{ $maintenance->id }}" tabindex="-1" role="dialog"
    aria-labelledby="editModalLabel{{ $maintenance->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" style="max-width: 90%; height: 90%;">
        <div class="modal-content" style="height: 100%;">
            <!-- Header du modal -->
            <div class="modal-header" style="background-color: #007bff; color: #ffffff;">
                <h5 class="modal-title" id="editModalLabel{{ $maintenance->id }}">Modifier Maintenance</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            

            <!-- Body du modal -->
            <div class="modal-body"
                style="background-color: #f8f9fa; overflow-y: auto; color: #080808; font-weight: bold;">
                <!-- Formulaire de modification de maintenance -->
                <form action="{{ route('update.maintenance', $maintenance->id) }}" method="POST">
                    @csrf


                    <!-- Informations Client -->
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="form-label" for="client_nom">Nom du Client</label>
                                <input type="text" class="form-control @error('client_nom') is-invalid @enderror"
                                    id="client_nom" name="client_nom"
                                    value="{{ old('client_nom', $maintenance->equipement->client->nom) }}"
                                    placeholder="Entrez le nom du client" required>
                                @error('client_nom')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="form-label" for="client_prenom">Prénom du Client</label>
                                <input type="text" class="form-control @error('client_prenom') is-invalid @enderror"
                                    id="client_prenom" name="client_prenom"
                                    value="{{ old('client_prenom', $maintenance->equipement->client->prenom) }}"
                                    placeholder="Entrez le prénom du client" required>
                                @error('client_prenom')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="form-label" for="telephone">Téléphone du Client</label>
                                <input type="text" class="form-control @error('telephone') is-invalid @enderror"
                                    id="telephone" name="telephone"
                                    value="{{ old('telephone', $maintenance->equipement->client->telephone) }}"
                                    placeholder="Entrez le téléphone du client" required>
                                @error('telephone')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="form-label" for="type_equipement_id">Type d'équipement</label>
                                <select class="form-control @error('type_equipement_id') is-invalid @enderror"
                                    id="type_equipement_id" name="type_equipement_id" required>+
                                    <option value="">Sélectionnez le type d'équipement</option>
                                    @foreach ($types as $type)
                                        <option value="{{ $type->id }}"
                                            {{ $type->id == $maintenance->equipement->type_equipement_id ? 'selected' : '' }}>
                                            {{ $type->nom_type }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('type_equipement_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Informations sur l'équipement -->
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="form-label" for="marque">Marque</label>
                                <input type="text" class="form-control @error('marque') is-invalid @enderror"
                                    id="marque" name="marque"
                                    value="{{ old('marque', $maintenance->equipement->marque) }}"
                                    placeholder="Entrez la marque de l'équipement" required>
                                @error('marque')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="form-label" for="modele">Modèle</label>
                                <input type="text" class="form-control @error('modele') is-invalid @enderror"
                                    id="modele" name="modele"
                                    value="{{ old('modele', $maintenance->equipement->modele) }}"
                                    placeholder="Entrez le modèle de l'équipement" required>
                                @error('modele')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="form-label" for="numero_serie">Numéro de Série</label>
                                <input type="text" class="form-control @error('numero_serie') is-invalid @enderror"
                                    id="numero_serie" name="numero_serie"
                                    value="{{ old('numero_serie', $maintenance->equipement->numero_serie) }}"
                                    placeholder="Entrez le numéro de série" required>
                                @error('numero_serie')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="form-label" for="date_reparation">Date de Réparation</label>
                                <input type="datetime-local"
                                    class="form-control @error('date_reparation') is-invalid @enderror"
                                    id="date_reparation" name="date_reparation"
                                    value="{{ old('date_reparation', $maintenance->date_reparation ? $maintenance->date_reparation->format('Y-m-d\TH:i') : '') }}"
                                    required>
                                @error('date_reparation')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Informations Maintenance -->
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="form-label" for="panne">Panne</label>
                                <input type="text" class="form-control @error('panne') is-invalid @enderror"
                                    id="panne" name="panne" value="{{ old('panne', $maintenance->panne) }}"
                                    placeholder="Décrivez la panne" required>
                                @error('panne')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="form-label" for="action_reparation">Action de Réparation</label>
                                <textarea class="form-control @error('action_reparation') is-invalid @enderror" id="action_reparation"
                                    name="action_reparation" required>{{ old('action_reparation', $maintenance->action_reparation) }}</textarea>
                                @error('action_reparation')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="form-label" for="observations">Observations</label>
                                <textarea class="form-control @error('observations') is-invalid @enderror" id="observations" name="observations">{{ old('observations', $maintenance->observations) }}</textarea>
                                @error('observations')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Footer du modal -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
