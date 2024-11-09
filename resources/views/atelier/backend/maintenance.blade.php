@extends('atelier.atelier_dashboard')

@section('atelier')
    <style>
        /* Styles for the select based on the option selected */
        .status-select {
            color: white;
            /* Default text color */
            padding: 5px;
            border-radius: 5px;
        }

        .status-select option[value="En cours"]:checked,
        .status-select[value="En cours"] {
            background-color: orange;
        }

        .status-select option[value="Terminé"]:checked,
        .status-select[value="Terminé"] {
            background-color: green;
        }

        .status-select option[value="Annulé"]:checked,
        .status-select[value="Annulé"] {
            background-color: red;
        }

        .bg-warning {
            background-color: orange;
            color: white;
        }

        .bg-success {
            background-color: green;
            color: white;
        }

        .bg-danger {
            background-color: red;
            color: white;
        }
    </style>
    <div class="page-content">



        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <!-- Bouton pour activer le modal -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addMaintenanceModal">
                    Enregistrer une Maintenance
                </button>

                <form action="{{ route('maintenance.pdf') }}" method="GET" target="_blank" class="d-flex">
                    <input type="hidden" name="type_equipement" value="{{ request('type_equipement') }}">
                    <button type="submit" class="btn btn-success">
                        Générer PDF
                    </button>
                </form>

                <form id="filterForm" action="{{ route('liste.maintenance') }}" method="GET" class="d-flex me-3" style="gap: 10px;">
                    <div class="btn-group">
                        <select name="type_equipement" id="type_equipement" class="form-select btn btn-primary"
                                onchange="submitFilterForm()"
                                style="border: none; background-color: #1c2dee; color: rgb(255, 255, 255);">
                            <option value="">Tout Afficher</option>
                            @foreach ($types as $type)
                                <option value="{{ $type->id }}" {{ request('type_equipement') == $type->id ? 'selected' : '' }}>
                                    {{ $type->nom_type }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </form>



                <!-- Modal pour ajouter une maintenance -->
                <div class="modal fade" id="addMaintenanceModal" tabindex="-1" role="dialog"
                    aria-labelledby="addMaintenanceModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document" style="max-width: 90%; height: 90%;">
                        <div class="modal-content" style="height: 100%;">
                            <!-- Header du modal avec une couleur de fond spécifique -->
                            <div class="modal-header" style="background-color: #007bff; color: #ffffff;">
                                <h5 class="modal-title" id="addMaintenanceModalLabel">Enregistrement d'une Maintenance</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <!-- Body du modal avec une autre couleur de fond -->
                            <div class="modal-body"
                                style="background-color: #f8f9fa; overflow-y: auto; color: #080808;font-weight: bold;">
                                <!-- Formulaire d'ajout de maintenance -->
                                <form id="maintenanceForm" method="POST" action="{{ route('store.maintenance') }}"
                                    class="forms-sample">
                                    @csrf

                                    <!-- Informations Client -->
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="mb-3">
                                                <label class="form-label" for="nom">Nom du Client</label>
                                                <input type="text"
                                                    class="form-control @error('nom') is-invalid @enderror" id="nom"
                                                    name="nom" placeholder="Entrez le nom du client" required>
                                                @error('nom')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="mb-3">
                                                <label class="form-label" for="prenom">Prénom du Client</label>
                                                <input type="text"
                                                    class="form-control @error('prenom') is-invalid @enderror"
                                                    id="prenom" name="prenom" placeholder="Entrez le prénom du client"
                                                    required>
                                                @error('prenom')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="mb-3">
                                                <label class="form-label" for="telephone">Téléphone du Client</label>
                                                <input type="text"
                                                    class="form-control @error('telephone') is-invalid @enderror"
                                                    id="telephone" name="telephone"
                                                    placeholder="Entrez le téléphone du client" required>
                                                @error('telephone')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Informations sur l'équipement -->
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="mb-3">
                                                <label class="form-label" for="grade_id">Grade</label>
                                                <select class="form-control @error('grade_id') is-invalid @enderror"
                                                    id="grade_id" name="grade_id" required>
                                                    <option value="">Sélectionnez le grade</option>
                                                    @foreach ($grades as $grade)
                                                        <option value="{{ $grade->id }}">{{ $grade->nom_grade }}</option>
                                                    @endforeach
                                                </select>
                                                @error('grade_id')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="mb-3">
                                                <label class="form-label" for="service_id">Service</label>
                                                <select class="form-control @error('service_id') is-invalid @enderror"
                                                    id="service_id" name="service_id" required>
                                                    <option value="">Sélectionnez le service</option>
                                                    @foreach ($services as $service)
                                                        <option value="{{ $service->id }}">{{ $service->nom_service }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('service_id')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="mb-3">
                                                <label class="form-label" for="type_equipement_id">Type d'équipement</label>
                                                <select
                                                    class="form-control @error('type_equipement_id') is-invalid @enderror"
                                                    id="type_equipement_id" name="type_equipement_id" required>
                                                    <option value="">Sélectionnez le type d'équipement</option>
                                                    @foreach ($types as $type)
                                                        <option value="{{ $type->id }}">{{ $type->nom_type }}</option>
                                                    @endforeach
                                                </select>
                                                @error('type_equipement_id')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Section dynamique pour les équipements -->
                                    <div id="equipementsContainer"></div>

                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="mb-3">
                                                <label class="form-label" for="quantite">Quantité d'Équipements</label>
                                                <input type="number" class="form-control" id="quantite"
                                                    name="quantite" value="0" readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="mb-3">
                                                <button type="button" id="addEquipementBtn" class="btn btn-secondary"
                                                    style="margin-top: 32px;">Ajouter un Équipement</button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Informations Maintenance -->
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="mb-3">
                                                <label class="form-label" for="panne">Panne</label>
                                                <textarea class="form-control" id="panne" name="panne" placeholder="Décrivez la panne" required></textarea>
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="mb-3">
                                                <label class="form-label" for="action_reparation">Action de
                                                    Réparation</label>
                                                <textarea class="form-control" id="action_reparation" name="action_reparation"
                                                    placeholder="Décrivez l'action de réparation"></textarea>
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="mb-3">
                                                <label class="form-label" for="observations">Observations</label>
                                                <textarea class="form-control" id="observations" name="observations" placeholder="Ajoutez des observations"></textarea>
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="mb-3">
                                                <label class="form-label" for="technicien_id">Technicien</label>
                                                <select class="form-control" id="technicien_id" name="technicien_id"
                                                    required>
                                                    <option value="">Sélectionnez le technicien</option>
                                                    @foreach ($techniciens as $technicien)
                                                        <option value="{{ $technicien->id }}">
                                                            {{ $technicien->nom }} {{ $technicien->prenom }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="mb-3">
                                                <label class="form-label" for="date_reprise">Date de Reprise</label>
                                                <input type="date" class="form-control" id="date_reprise"
                                                    name="date_reprise">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Aperçu et soumission -->
                                    <button type="button" id="previewBtn" class="btn btn-warning">Aperçu</button>
                                    <button type="submit" id="submitBtn" class="btn btn-primary"
                                        style="display:none;">Enregistrer</button>
                                </form>

                                <!-- Modal d'Aperçu -->
                                <div class="modal fade" id="previewModal" tabindex="-1" role="dialog"
                                    aria-labelledby="previewModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document"
                                        style="max-width: 90%; height: 90%;">
                                        <div class="modal-content" style="height: 100%;">
                                            <!-- Header du modal d'aperçu avec une couleur de fond spécifique -->
                                            <div class="modal-header" style="background-color: #28a745; color: #ffffff;">
                                                <h5 class="modal-title" id="previewModalLabel">Aperçu de la Maintenance
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                            <!-- Body du modal d'aperçu avec une autre couleur de fond -->
                                            <div class="modal-body" id="previewContent"
                                                style="background-color: #ffffff; overflow-y: auto;">
                                                <!-- Le contenu de l'aperçu sera inséré ici par JavaScript -->
                                            </div>

                                            <!-- Footer du modal d'aperçu avec encore une autre couleur de fond -->
                                            <div class="modal-footer" style="background-color: #343a40; color: #ffffff;">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Fermer</button>
                                                <button type="button" id="editBtn" class="btn btn-warning">Retour au
                                                    formulaire</button>
                                                <button type="button" id="confirmBtn" class="btn btn-primary">Confirmer
                                                    et Envoyer</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>




            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Liste des Maintenances</h6>
                        <div class="table-responsive">
                            <table id="dataTableExample" class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Client</th>
                                        <th>Type Équipement</th>
                                        <th>Marque</th>
                                        <th>Modèle</th>
                                        <th>Numero de serie</th>
                                        <th>Panne</th>
                                        <th>Date de Réparation</th>
                                        <th>Statut</th>

                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($maintenances as $key => $maintenance)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $maintenance->equipement->client->nom }}
                                                {{ $maintenance->equipement->client->prenom }}</td>
                                            <td>{{ $maintenance->equipement->typeEquipement->nom_type }}</td>
                                            <td>{{ $maintenance->equipement->marque }}</td>
                                            <td>{{ $maintenance->equipement->modele }}</td>
                                            <td>{{ $maintenance->equipement->numero_serie }}</td>
                                            <td>{{ $maintenance->panne }}</td>
                                            <td>{{ $maintenance->date_reparation }}</td>
                                            <td>
                                                <!-- Vue: dans votre vue de la liste des maintenances -->
                                                <form action="{{ route('store.statut', $maintenance->id) }}"
                                                    method="POST" style="display: inline;">
                                                    @csrf
                                                    <select name="statut" onchange="this.form.submit()"
                                                        class="form-control status-select">
                                                        <option value="En cours"
                                                            {{ $maintenance->statut == 'En cours' ? 'selected' : '' }}>En
                                                            cours</option>
                                                        <option value="Terminé"
                                                            {{ $maintenance->statut == 'Terminé' ? 'selected' : '' }}>
                                                            Terminé</option>
                                                        <option value="Annulé"
                                                            {{ $maintenance->statut == 'Annulé' ? 'selected' : '' }}>Annulé
                                                        </option>
                                                    </select>
                                                </form>


                                            </td>


                                            <td>
                                                @include('atelier.backend.info')

                                                @include('atelier.backend.modifier')



                                                <!-- Action comme supprimer -->
                                                <a href="{{ route('delete.maintenance', $maintenance->id) }}"
                                                    class="btn btn-danger" id="delete"><i
                                                        data-feather="trash-2"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selects = document.querySelectorAll('.status-select');

            selects.forEach(select => {
                updateSelectStyle(select); // Apply initial style

                select.addEventListener('change', function() {
                    updateSelectStyle(select);
                });
            });

            function updateSelectStyle(select) {
                select.classList.remove('bg-warning', 'bg-success', 'bg-danger');

                if (select.value === 'En cours') {
                    select.classList.add('bg-warning');
                } else if (select.value === 'Terminé') {
                    select.classList.add('bg-success');
                } else if (select.value === 'Annulé') {
                    select.classList.add('bg-danger');
                }
            }
        });


        // ajout Dynamique ////

        document.addEventListener('DOMContentLoaded', function() {
            let equipementCounter = 0;

            // Bouton pour ajouter un équipement
            document.getElementById('addEquipementBtn').addEventListener('click', function() {
                equipementCounter++;

                const equipementContainer = document.createElement('div');
                equipementContainer.classList.add('row');
                equipementContainer.classList.add('equipement-group');
                equipementContainer.setAttribute('data-equipement', equipementCounter);

                equipementContainer.innerHTML = `
            <div class="col-sm-4">
                <div class="mb-3">
                    <label class="form-label" for="equipements[${equipementCounter}][marque]">Marque</label>
                    <input type="text" class="form-control" name="equipements[${equipementCounter}][marque]" placeholder="Entrez la marque de l'équipement" required>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="mb-3">
                    <label class="form-label" for="equipements[${equipementCounter}][modele]">Modèle</label>
                    <input type="text" class="form-control" name="equipements[${equipementCounter}][modele]" placeholder="Entrez le modèle de l'équipement" required>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="mb-3">
                    <label class="form-label" for="equipements[${equipementCounter}][numero_serie]">Numéro de série</label>
                    <input type="text" class="form-control" name="equipements[${equipementCounter}][numero_serie]" placeholder="Entrez le numéro de série de l'équipement" required>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="mb-3">
                    <label class="form-label" for="equipements[${equipementCounter}][quantite]">Quantité</label>
                    <input type="number" class="form-control" name="equipements[${equipementCounter}][quantite]" value="1" min="1" required>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="mb-3">
                    <button type="button" class="btn btn-danger removeEquipementBtn" style="margin-top: 32px;">Supprimer</button>
                </div>
            </div>
        `;

                document.getElementById('equipementsContainer').appendChild(equipementContainer);

                updateQuantiteField();
            });

            // Bouton pour supprimer un équipement
            document.getElementById('equipementsContainer').addEventListener('click', function(event) {
                if (event.target.classList.contains('removeEquipementBtn')) {
                    event.target.closest('.equipement-group').remove();
                    updateQuantiteField();
                }
            });

            // Mettre à jour le champ de quantité
            function updateQuantiteField() {
                const equipementGroups = document.querySelectorAll('.equipement-group');
                document.getElementById('quantite').value = equipementGroups.length;
            }

            // Gestion de l'aperçu
            document.getElementById('previewBtn').addEventListener('click', function() {
                const formData = new FormData(document.getElementById('maintenanceForm'));
                const previewContent = document.getElementById('previewContent');

                previewContent.innerHTML = '';

                formData.forEach((value, key) => {
                    const previewItem = document.createElement('div');
                    previewItem.innerHTML = `<strong>${key}</strong>: ${value}`;
                    previewContent.appendChild(previewItem);
                });

                $('#previewModal').modal('show');
            });

            // Confirmation de l'envoi après l'aperçu
            document.getElementById('confirmBtn').addEventListener('click', function() {
                document.getElementById('submitBtn').click();
            });
        });
    </script>
@endsection
