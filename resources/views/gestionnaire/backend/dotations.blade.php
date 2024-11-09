@extends('gestionnaire.gestionnaire_dashboard')

@section('gestionnaire')
    <div class="page-content">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">


                <div class="d-flex justify-content-between align-items-center mb-3" style="gap: 15px;">

                    <!-- Bouton Ajouter une dotation -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDotationModal">
                        Ajouter une dotation
                    </button>

                    <!-- Formulaire de génération de PDF -->
                    <form action="{{ route('dotation.pdf') }}" method="GET" target="_blank" class="d-flex">
                        <input type="hidden" name="type_equipement" value="{{ request('type_equipement') }}">
                        <button type="submit" class="btn btn-success">
                            Générer PDF
                        </button>
                    </form>

                    <!-- Formulaire de filtre pour les dotations -->
                    <form id="filterForm" action="{{ route('liste.dotation') }}" method="GET" class="d-flex me-3"
                        style="gap: 10px;">
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

                <!-- Modal pour ajouter une dotation -->
                <div class="modal fade" id="addDotationModal" tabindex="-1" role="dialog"
                    aria-labelledby="addDotationModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addDotationModalLabel">Enregistrement d'une Dotation</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!-- Formulaire d'ajout de dotation -->
                                <form id="dotationForm" method="POST" action="{{ route('store.dotation') }}"
                                    class="forms-sample">
                                    @csrf

                                    <!-- Informations sur la dotation -->
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="beneficiare">Bénéficiaire</label>
                                                <input type="text" class="form-control" id="beneficiare"
                                                    name="beneficiare" placeholder="Entrez le bénéficiaire" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="date_dotation">Date de Dotation</label>
                                                <input type="date" class="form-control" id="date_dotation"
                                                    name="date_dotation" value="{{ now()->format('Y-m-d') }}" required>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Section dynamique pour les équipements -->
                                    <div id="equipementsContainer"></div>

                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="mb-3">
                                                <label class="form-label" for="quantite">Quantité Totale</label>
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
                        <!-- Affichage du message de succès -->
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <h6 class="card-title">Liste des Dotations</h6>
                        <div class="table-responsive">
                            <table id="dataTableExample" class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Équipement</th>
                                        <th>Marque</th>
                                        <th>Modèle</th>
                                        <th>Numéro de Série</th>
                                        <th>Quantité</th>
                                        <th>Date de Dotation</th>
                                        <th>Bénéficiaire</th>
                                        <th>Observations</th>
                                        <th>Actions</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dotations as $dotation)
                                        <tr>
                                            <td>{{ $dotation->id }}</td>
                                            <td>{{ $dotation->equipement->typeEquipement->nom_type }}</td>
                                            <td>{{ $dotation->equipement->marque }}</td>
                                            <td>{{ $dotation->equipement->modele }}</td>
                                            <td>{{ $dotation->equipement->numero_serie }}</td>
                                            <td>{{ $dotation->quantite }}</td>
                                            <td>{{ \Carbon\Carbon::parse($dotation->date_dotation)->format('d/m/Y') }}</td>
                                            <td>{{ $dotation->beneficiare }}</td>
                                            <td>{{ $dotation->observations ?? 'N/A' }}</td>
                                            <td>
                                                <button type="button" class="btn btn-danger" data-toggle="modal"
                                                    data-target="#restituerModal{{ $dotation->equipement->id }}">
                                                    Restituer
                                                </button>

                                                <!-- Modal pour la restitution de l'équipement -->
                                                <div class="modal fade"
                                                    id="restituerModal{{ $dotation->equipement->id }}" tabindex="1"
                                                    role="dialog"
                                                    aria-labelledby="restituerModalLabel{{ $dotation->equipement->id }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="restituerModalLabel{{ $dotation->equipement->id }}">
                                                                    Motif de Restitution</h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>

                                                            <div class="modal-body">
                                                                <form
                                                               action="{{ route('restituer.dotation', $dotation->id) }}"

                                                                    method="POST">
                                                                    @csrf
                                                                    <div class="mb-3">
                                                                        <label for="date_restitution"
                                                                            class="form-label">Date de la
                                                                            restitution</label>
                                                                        <input type="date"
                                                                            class="form-control @error('date_restitution') is-invalid @enderror"
                                                                            id="date_restitution" name="date_restitution"
                                                                            value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                                            required>
                                                                        @error('date_restitution')
                                                                            <span
                                                                                class="text-danger">{{ $message }}</span>
                                                                        @enderror
                                                                    </div>


                                                                    <div class="mb-3">
                                                                        <label for="motif" class="form-label">Motif de
                                                                            la restitution</label>
                                                                        <textarea class="form-control @error('motif') is-invalid @enderror" id="motif" name="motif" required></textarea>
                                                                        @error('motif')
                                                                            <span
                                                                                class="text-danger">{{ $message }}</span>
                                                                        @enderror
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label for="condition_equipement"
                                                                            class="form-label">Condition de
                                                                            l'équipement</label>
                                                                        <select
                                                                            class="form-control @error('condition_equipement') is-invalid @enderror"
                                                                            id="condition_equipement"
                                                                            name="condition_equipement" required>
                                                                            <option value="">Sélectionnez l'état de
                                                                                l'équipement</option>
                                                                            <option value="Neuf">Neuf</option>
                                                                            <option value="Bon état">Bon état</option>
                                                                            <option value="Moyen état">Moyen état</option>
                                                                            <option value="Mauvais état">Mauvais état
                                                                            </option>
                                                                        </select>
                                                                        @error('condition_equipement')
                                                                            <span
                                                                                class="text-danger">{{ $message }}</span>
                                                                        @enderror
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label for="commentaires"
                                                                            class="form-label">Commentaires</label>
                                                                        <textarea class="form-control @error('commentaires') is-invalid @enderror" id="commentaires" name="commentaires"></textarea>
                                                                        @error('commentaires')
                                                                            <span
                                                                                class="text-danger">{{ $message }}</span>
                                                                        @enderror
                                                                    </div>

                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-dismiss="modal">Fermer</button>
                                                                        <button type="submit"
                                                                            class="btn btn-primary">Restituer
                                                                            l'équipement</button>
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
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label class="form-label" for="equipement_id_${equipementCounter}">Équipement</label>
                            <select class="form-control" id="equipement_id_${equipementCounter}" name="equipements[${equipementCounter}][equipement_id]" required>
                                <option value="">Sélectionnez un équipement</option>
                                @foreach ($equipements as $equipement)
                                    <option value="{{ $equipement->id }}">
                                        {{ $equipement->typeEquipement->nom_type }} - {{ $equipement->marque }} - {{ $equipement->modele }} ({{ $equipement->quantite }} en stock)
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="mb-3">
                            <label class="form-label" for="marque_${equipementCounter}">Marque</label>
                            <input type="text" class="form-control" id="marque_${equipementCounter}" name="equipements[${equipementCounter}][marque]" readonly>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="mb-3">
                            <label class="form-label" for="modele_${equipementCounter}">Modèle</label>
                            <input type="text" class="form-control" id="modele_${equipementCounter}" name="equipements[${equipementCounter}][modele]" readonly>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="mb-3">
                            <label class="form-label" for="numero_serie_${equipementCounter}">Numéro de série</label>
                            <input type="text" class="form-control" id="numero_serie_${equipementCounter}" name="equipements[${equipementCounter}][numero_serie]" readonly>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="mb-3">
                            <label class="form-label" for="quantite_dotee_${equipementCounter}">Quantité à doter</label>
                            <input type="number" class="form-control" id="quantite_dotee_${equipementCounter}" name="equipements[${equipementCounter}][quantite_dotee]" value="1" min="1" required>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="mb-3">
                            <button type="button" class="btn btn-danger removeEquipementBtn" style="margin-top: 32px;">Supprimer</button>
                        </div>
                    </div>
                `;

                document.getElementById('equipementsContainer').appendChild(equipementContainer);

                // Ajouter un événement change pour mettre à jour les champs marque, modèle et numéro de série
                document.getElementById(`equipement_id_${equipementCounter}`).addEventListener('change',
                    function() {
                        const selectedOption = this.options[this.selectedIndex];
                        const marqueInput = document.getElementById(`marque_${equipementCounter}`);
                        const modeleInput = document.getElementById(`modele_${equipementCounter}`);
                        const numeroSerieInput = document.getElementById(
                            `numero_serie_${equipementCounter}`);

                        marqueInput.value = selectedOption.textContent.split(' - ')[1];
                        modeleInput.value = selectedOption.textContent.split(' - ')[2].split(' ')[0];
                        numeroSerieInput.value = selectedOption.textContent.split(' (')[0].split(' - ')[
                            2];
                    });
            });

            // Événement pour supprimer un groupe d'équipements
            document.getElementById('equipementsContainer').addEventListener('click', function(event) {
                if (event.target.classList.contains('removeEquipementBtn')) {
                    event.target.closest('.equipement-group').remove();
                    // Mettre à jour la quantité totale
                    updateQuantiteTotale();
                }
            });

            // Fonction pour mettre à jour la quantité totale
            function updateQuantiteTotale() {
                let totalQuantite = 0;
                document.querySelectorAll('.equipement-group').forEach(group => {
                    const quantiteInput = group.querySelector('input[name$="[quantite_dotee]"]');
                    if (quantiteInput) {
                        totalQuantite += parseInt(quantiteInput.value) || 0;
                    }
                });
                document.getElementById('quantite').value = totalQuantite;
            }

            // Bouton pour l'aperçu
            document.getElementById('previewBtn').addEventListener('click', function() {
                const previewContent = document.getElementById('previewContent');
                previewContent.innerHTML = '';

                document.querySelectorAll('.equipement-group').forEach(group => {
                    const equipementId = group.querySelector('select[name$="[equipement_id]"]')
                        .value;
                    const marque = group.querySelector('input[name$="[marque]"]').value;
                    const modele = group.querySelector('input[name$="[modele]"]').value;
                    const numeroSerie = group.querySelector('input[name$="[numero_serie]"]').value;
                    const quantiteDotee = group.querySelector('input[name$="[quantite_dotee]"]')
                        .value;

                    previewContent.innerHTML += `
                        <div class="mb-3">
                            <strong>Équipement:</strong> ${marque} - ${modele} <br>
                            <strong>Numéro de série:</strong> ${numeroSerie} <br>
                            <strong>Quantité à doter:</strong> ${quantiteDotee} <br><br>
                        </div>
                    `;
                });

                // Afficher le modal d'aperçu
                $('#previewModal').modal('show');
            });

            // Bouton de confirmation dans le modal d'aperçu
            document.getElementById('confirmBtn').addEventListener('click', function() {
                document.getElementById('submitBtn').click();
            });
        });
    </script>

    <script>
        function submitFilterForm() {
            document.getElementById('filterForm').submit();
        }
    </script>
@endsection
