@extends('gestionnaire.gestionnaire_dashboard')

@section('gestionnaire')
    <div class="page-content">
        <nav class="page-breadcrumb">


            <div class="d-flex justify-content-between align-items-center mb-3" style="gap: 5px;">

                <!-- Bouton d'activation du modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAcquisitionModal">
                    Ajouter une acquisition
                </button>

                <!-- Formulaire de génération de PDF -->
                <form action="{{ route('acquisition.pdf') }}" method="GET" target="_blank" class="d-flex">
                    <input type="hidden" name="type_equipement" value="{{ request('type_equipement') }}">
                    <button type="submit" class="btn btn-success">
                        Télécharger PDF
                    </button>
                </form>

                <!-- Formulaire de filtre pour les acquisitions -->
                <form id="filterForm" action="{{ route('liste.acquisition') }}" method="GET" class="d-flex"
                    style="gap: 5px;">
                    <div class="btn-group">
                        <select name="type_equipement" id="type_equipement" class="form-select btn btn-primary"
                            onchange="submitFilterForm()"
                            style="border: none; background-color: #1c2dee; color: rgb(255, 255, 255);">
                            <option value="">Tout Afficher</option>
                            @foreach ($types as $type)
                                <option value="{{ $type->id }}"
                                    {{ request('type_equipement') == $type->id ? 'selected' : '' }}>
                                    {{ $type->nom_type }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </form>

            </div>



            <ol class="breadcrumb">

                <!-- Modal pour ajouter une acquisition -->
                <div class="modal fade" id="addAcquisitionModal" tabindex="-1" role="dialog"
                    aria-labelledby="addAcquisitionModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addAcquisitionModalLabel">Enregistrement d'une Acquisition</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!-- Formulaire d'ajout d'acquisition -->
                                <form id="acquisitionForm" method="POST" action="{{ route('store.acquisition') }}"
                                    class="forms-sample">
                                    @csrf

                                    <!-- Informations sur l'acquisition -->
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="fournisseur">Provenance</label>
                                                <input type="text" class="form-control" id="provenance" name="provenance"
                                                    placeholder="Entrez la provenance" required>
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

                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="date_acquisition">Date d'Acquisition</label>
                                                <input type="date" class="form-control" id="date_acquisition"
                                                    name="date_acquisition" value="{{ now()->format('Y-m-d') }}" required>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Section dynamique pour les équipements -->
                                    <div id="equipementsContainer"></div>

                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="mb-3">
                                                <label class="form-label" for="quantite">Quantité d'Équipements</label>
                                                <input type="number" class="form-control" id="quantite" name="quantite"
                                                    value="0" readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="mb-3">
                                                <button type="button" id="addEquipementBtn" class="btn btn-secondary"
                                                    style="margin-top: 32px;">Ajouter un Équipement</button>
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
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="previewModalLabel">Aperçu des Informations
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div id="previewContent"></div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Retourner au formulaire</button>
                                                <button type="button" id="confirmBtn" class="btn btn-primary">Confirmer
                                                    et
                                                    Envoyer</button>
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
                        <h6 class="card-title">Liste des Acquisitions</h6>


                        <div class="table-responsive">
                            <table id="dataTableExample" class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Type Équipement</th>
                                        <th>Marque</th>
                                        <th>Modèle</th>
                                        <th>Numéro de Série</th>
                                        <th>Date d'Acquisition</th>
                                        <th>Provenance</th>
                                        <th>Observations</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($acquisitions as $acquisition)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $acquisition->equipement->typeEquipement->nom_type ?? 'N/A' }}</td>
                                            <td>{{ $acquisition->equipement->marque ?? 'N/A' }}</td>
                                            <td>{{ $acquisition->equipement->modele ?? 'N/A' }}</td>
                                            <td>{{ $acquisition->equipement->numero_serie ?? 'N/A' }}</td>
                                            <td>{{ \Carbon\Carbon::parse($acquisition->date_acquisition)->format('d/m/Y H:i:s') ?? 'N/A' }}
                                            </td>
                                            <td>{{ $acquisition->provenance ?? 'N/A' }}</td>
                                            <td>{{ $acquisition->observations ?? 'N/A' }}</td>
                                            <td>

                                                <!-- Bouton pour afficher les détails de l'acquisition -->
                                                <button type="button" class="btn btn-info" data-toggle="modal"
                                                    data-target="#detailAcquisitionModal{{ $acquisition->id }}">
                                                    <i data-feather="eye"></i> <!-- Icône pour le bouton de détails -->
                                                </button>

                                                <!-- Modal pour afficher les détails de l'acquisition -->
                                                <div class="modal fade" id="detailAcquisitionModal{{ $acquisition->id }}"
                                                    tabindex="-1" role="dialog"
                                                    aria-labelledby="detailAcquisitionModalLabel{{ $acquisition->id }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <!-- Header du modal -->
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="detailAcquisitionModalLabel{{ $acquisition->id }}">
                                                                    Détails de l'Acquisition
                                                                </h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>

                                                            <!-- Body du modal -->
                                                            <div class="modal-body">
                                                                <!-- Informations sur l'acquisition en lecture seule -->
                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Provenance</label>
                                                                            <p>{{ $acquisition->provenance ?? 'N/A' }}</p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Observations</label>
                                                                            <p>{{ $acquisition->observations ?? 'N/A' }}
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <!-- Informations sur l'équipement associé -->
                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Type
                                                                                d'équipement</label>
                                                                            <p>{{ $acquisition->equipement->typeEquipement->nom_type ?? 'N/A' }}
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Marque</label>
                                                                            <p>{{ $acquisition->equipement->marque ?? 'N/A' }}
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Modèle</label>
                                                                            <p>{{ $acquisition->equipement->modele ?? 'N/A' }}
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Numéro de
                                                                                Série</label>
                                                                            <p>{{ $acquisition->equipement->numero_serie ?? 'N/A' }}
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Footer du modal -->
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Fermer</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>




                                                <!-- Bouton pour modifier l'acquisition -->
                                                <button type="button" class="btn btn-warning" data-toggle="modal"
                                                    data-target="#editAcquisitionModal{{ $acquisition->id }}">
                                                    <i data-feather="edit"></i>
                                                </button>

                                                <!-- Modal pour la modification de l'acquisition -->
                                                <div class="modal fade" id="editAcquisitionModal{{ $acquisition->id }}"
                                                    tabindex="-1" role="dialog"
                                                    aria-labelledby="editAcquisitionModalLabel{{ $acquisition->id }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <!-- Header du modal -->
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="editAcquisitionModalLabel{{ $acquisition->id }}">
                                                                    Modifier Acquisition</h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>

                                                            <!-- Body du modal -->
                                                            <div class="modal-body">
                                                                <!-- Formulaire de modification de l'acquisition -->
                                                                <form
                                                                    action="{{ route('update.acquisition', $acquisition->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    <!-- Informations sur l'acquisition -->
                                                                    <div class="row">
                                                                        <div class="col-sm-6">
                                                                            <div class="mb-3">
                                                                                <label class="form-label"
                                                                                    for="provenance">Provenance</label>
                                                                                <input type="text"
                                                                                    class="form-control @error('provenance') is-invalid @enderror"
                                                                                    id="provenance" name="provenance"
                                                                                    value="{{ old('provenance', $acquisition->provenance) }}"
                                                                                    placeholder="Entrez la provenance"
                                                                                    required>
                                                                                @error('provenance')
                                                                                    <span
                                                                                        class="text-danger">{{ $message }}</span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <div class="mb-3">
                                                                                <label class="form-label"
                                                                                    for="observations">Observations</label>
                                                                                <textarea class="form-control @error('observations') is-invalid @enderror" id="observations" name="observations">{{ old('observations', $acquisition->observations) }}</textarea>
                                                                                @error('observations')
                                                                                    <span
                                                                                        class="text-danger">{{ $message }}</span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Informations sur l'équipement associé -->
                                                                    <div class="row">
                                                                        <div class="col-sm-6">
                                                                            <div class="mb-3">
                                                                                <label class="form-label"
                                                                                    for="type_equipement_id">Type
                                                                                    d'équipement</label>
                                                                                <select
                                                                                    class="form-control @error('type_equipement_id') is-invalid @enderror"
                                                                                    id="type_equipement_id"
                                                                                    name="type_equipement_id" required>
                                                                                    <option value="">Sélectionnez le
                                                                                        type d'équipement</option>
                                                                                    @foreach ($types as $type)
                                                                                        <option
                                                                                            value="{{ $type->id }}"
                                                                                            {{ $type->id == $acquisition->equipement->type_equipement_id ? 'selected' : '' }}>
                                                                                            {{ $type->nom_type }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                </select>
                                                                                @error('type_equipement_id')
                                                                                    <span
                                                                                        class="text-danger">{{ $message }}</span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <div class="mb-3">
                                                                                <label class="form-label"
                                                                                    for="marque">Marque</label>
                                                                                <input type="text"
                                                                                    class="form-control @error('marque') is-invalid @enderror"
                                                                                    id="marque" name="marque"
                                                                                    value="{{ old('marque', $acquisition->equipement->marque) }}"
                                                                                    placeholder="Entrez la marque de l'équipement"
                                                                                    required>
                                                                                @error('marque')
                                                                                    <span
                                                                                        class="text-danger">{{ $message }}</span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="col-sm-6">
                                                                            <div class="mb-3">
                                                                                <label class="form-label"
                                                                                    for="modele">Modèle</label>
                                                                                <input type="text"
                                                                                    class="form-control @error('modele') is-invalid @enderror"
                                                                                    id="modele" name="modele"
                                                                                    value="{{ old('modele', $acquisition->equipement->modele) }}"
                                                                                    placeholder="Entrez le modèle de l'équipement"
                                                                                    required>
                                                                                @error('modele')
                                                                                    <span
                                                                                        class="text-danger">{{ $message }}</span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-sm-6">
                                                                            <div class="mb-3">
                                                                                <label class="form-label"
                                                                                    for="numero_serie">Numéro de
                                                                                    Série</label>
                                                                                <input type="text"
                                                                                    class="form-control @error('numero_serie') is-invalid @enderror"
                                                                                    id="numero_serie" name="numero_serie"
                                                                                    value="{{ old('numero_serie', $acquisition->equipement->numero_serie) }}"
                                                                                    placeholder="Entrez le numéro de série"
                                                                                    required>
                                                                                @error('numero_serie')
                                                                                    <span
                                                                                        class="text-danger">{{ $message }}</span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Footer du modal -->
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-dismiss="modal">Fermer</button>
                                                                        <button type="submit"
                                                                            class="btn btn-primary">Enregistrer les
                                                                            modifications</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
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
                const formData = new FormData(document.getElementById('acquisitionForm'));
                const previewContent = document.getElementById('previewContent');

                previewContent.innerHTML = '';

                formData.forEach((value, key) => {
                    const previewItem = document.createElement('div');
                    previewItem.innerHTML = `<strong>${key}</strong>: ${value}`;
                    previewContent.appendChild(previewItem);
                });

                $('#previewModal').modal('show');
            });

            // Gestion de la confirmation dans l'aperçu
            document.getElementById('confirmBtn').addEventListener('click', function() {
                document.getElementById('acquisitionForm').submit();
            });
        });
    </script>

    <script>
        function submitFilterForm() {
            document.getElementById('filterForm').submit();
        }
    </script>
@endsection
