@extends('atelier.atelier_dashboard')

@section('atelier')
    <div class="page-content">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">

                <!-- Bouton pour activer le modal -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addTechnicianModal">
                    Enregistrer un Technicien
                </button>

                <!-- Modal pour ajouter un technicien -->
                <div class="modal fade" id="addTechnicianModal" tabindex="-1" role="dialog"
                    aria-labelledby="addTechnicianModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addTechnicianModalLabel">Ajouter Un Technicien</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!-- Formulaire d'ajout de technicien -->
                                <form method="POST" action="{{ route('store.technicien') }}" class="forms-sample">
                                    @csrf

                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="mb-3">
                                                <label class="form-label" for="nom">Nom</label>
                                                <input type="text"
                                                    class="form-control @error('nom') is-invalid @enderror" id="nom"
                                                    name="nom" placeholder="Entrez le nom du technicien" required>
                                                @error('nom')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="mb-3">
                                                <label class="form-label" for="prenom">Prénom</label>
                                                <input type="text"
                                                    class="form-control @error('prenom') is-invalid @enderror"
                                                    id="prenom" name="prenom"
                                                    placeholder="Entrez le prénom du technicien" required>
                                                @error('prenom')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

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
                                    </div>

                                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                                </form>
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
                        <h6 class="card-title">Les Différents Techniciens</h6>
                        <div class="table-responsive">
                            <table id="dataTableExample" class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nom</th>
                                        <th>Prénom</th>
                                        <th>Grade</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($techniciens as $key => $technicien)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $technicien->nom }}</td>
                                            <td>{{ $technicien->prenom }}</td>
                                            <td>{{ $technicien->grade->nom_grade }}</td>

                                            <td>
                                                <!-- Bouton pour activer le modal de modification -->
                                                <button type="button" class="btn btn-warning" data-toggle="modal"
                                                    data-target="#editTechnicianModal-{{ $technicien->id }}">
                                                    <i data-feather="edit"></i>
                                                </button>

                                                <!-- Modal pour modifier un technicien -->
                                                <div class="modal fade" id="editTechnicianModal-{{ $technicien->id }}"
                                                    tabindex="-1" role="dialog" aria-labelledby="editTechnicianModalLabel"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="editTechnicianModalLabel">
                                                                    Modifier le Technicien</h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <!-- Formulaire de modification du technicien -->
                                                                <form method="POST"
                                                                    action="{{ route('update.technicien', $technicien->id) }}"
                                                                    class="forms-sample">
                                                                    @csrf


                                                                    <div class="row">
                                                                        <div class="col-sm-4">
                                                                            <div class="mb-3">
                                                                                <label class="form-label"
                                                                                    for="nom">Nom</label>
                                                                                <input type="text"
                                                                                    class="form-control @error('nom') is-invalid @enderror"
                                                                                    id="nom" name="nom"
                                                                                    value="{{ $technicien->nom }}"
                                                                                    placeholder="Entrez le nom du technicien"
                                                                                    required>
                                                                                @error('nom')
                                                                                    <span
                                                                                        class="text-danger">{{ $message }}</span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-sm-4">
                                                                            <div class="mb-3">
                                                                                <label class="form-label"
                                                                                    for="prenom">Prénom</label>
                                                                                <input type="text"
                                                                                    class="form-control @error('prenom') is-invalid @enderror"
                                                                                    id="prenom" name="prenom"
                                                                                    value="{{ $technicien->prenom }}"
                                                                                    placeholder="Entrez le prénom du technicien"
                                                                                    required>
                                                                                @error('prenom')
                                                                                    <span
                                                                                        class="text-danger">{{ $message }}</span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-sm-4">
                                                                            <div class="mb-3">
                                                                                <label class="form-label"
                                                                                    for="grade_id">Grade</label>
                                                                                <select
                                                                                    class="form-control @error('grade_id') is-invalid @enderror"
                                                                                    id="grade_id" name="grade_id"
                                                                                    required>
                                                                                    <option value="">Sélectionnez le
                                                                                        grade</option>
                                                                                    @foreach ($grades as $grade)
                                                                                        <option
                                                                                            value="{{ $grade->id }}"
                                                                                            {{ $technicien->grade_id == $grade->id ? 'selected' : '' }}>
                                                                                            {{ $grade->nom_grade }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                </select>
                                                                                @error('grade_id')
                                                                                    <span
                                                                                        class="text-danger">{{ $message }}</span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <button type="submit" class="btn btn-primary">Mettre
                                                                        à jour</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <a href="{{ route('delete.technicien', $technicien->id) }}"
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
        $(document).ready(function() {
            // Afficher le modal lors du clic sur le bouton "Ajouter un Client"
            $('.btn-inverse-info').click(function() {
                $('#addTypeModal').modal('show');
            });
        });
    </script>
@endsection
