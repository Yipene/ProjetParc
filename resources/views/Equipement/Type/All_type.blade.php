@extends('gestionnaire.gestionnaire_dashboard')

@section('gestionnaire')
    <div class="page-content">

        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <!-- Bouton pour activer le modal -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addTypeModal">
                    Enregistrer un Type
                </button>

                <!-- Modal pour ajouter un type -->
                <div class="modal fade" id="addTypeModal" tabindex="-1" role="dialog" aria-labelledby="addTypeModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addTypeModalLabel">Enregistrement d'un Type</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!-- Formulaire d'ajout de type -->
                                <form method="POST" action="{{ route('store.type') }}" class="forms-sample">
                                    @csrf

                                    <div class="form-group">
                                        <label for="nom_client">Nom</label>
                                        <input type="text" class="form-control @error('nom_type') is-invalid @enderror"
                                            id="nom_type" name="nom_type" required>
                                        @error('nom_type')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
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
                        <h6 class="card-title">Les Types d'Equipement</h6>
                        <div class="table-responsive">
                            <table id="dataTableExample" class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nom_type</th>

                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($types as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->nom_type }}</td>

                                            <td>

                                                <a href="{{ route('delete.type', $item->id) }}"
                                                    class="btn btn-danger" id="delete"><i data-feather="trash-2"></i></a>
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
