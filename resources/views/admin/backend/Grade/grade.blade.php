@extends('admin.admin_dashboard')

@section('admin')
    <div class="page-content">

        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <ol class="breadcrumb">
                    <!-- Bouton pour activer le modal -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addGradeModal">
                        Enregistrement d'un Grade
                    </button>

                    <!-- Modal pour ajouter une maintenance -->
                    <div class="modal fade" id="addGradeModal" tabindex="-1" role="dialog"
                        aria-labelledby="addGradeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addGradeModalLabel">Ajouter Un Grade</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <!-- Formulaire d'ajout de maintenance -->
                                    <form method="POST" action="{{ route('store.grade') }}" class="forms-sample">
                                        @csrf

                                        <div class="form-group">
                                            <label for="nom_client">Intitulé de Grade</label>
                                            <input type="text"
                                                class="form-control @error('nom_client') is-invalid @enderror"
                                                id="nom_grade" name="nom_grade" required>
                                            @error('nom_grade')
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

            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Les Grades</h6>
                        <div class="table-responsive">
                            <table id="dataTableExample" class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Grades</th>

                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($grades as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->nom_grade }}</td>

                                            <td>
                                                <button type="button" class="btn btn-warning" data-toggle="modal"
                                                    data-target="#editGradeModal{{ $item->id }}">
                                                    <i data-feather="edit"></i>
                                                </button> 
                                                <!-- Modal -->
                                                <div class="modal fade" id="editGradeModal{{ $item->id }}"
                                                    tabindex="-1" role="dialog" aria-labelledby="editGradeModalLabel"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="editGradeModalLabel{{ $item->id }}">Modifier

                                                                </h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form method="POST" action="{{ route('update.grade') }}"
                                                                    class="forms-sample" enctype="multipart/form-data">
                                                                    @csrf
                                                                    <input type="hidden" name="id"
                                                                        value="{{ $item->id }}">



                                                                    <div class="form-group">
                                                                        <label for="nom_grade">Nom Grade</label>
                                                                        <input type="text"
                                                                            class="form-control @error('nom_grade') is-invalid @enderror"
                                                                            name="nom_grade"
                                                                            value="{{ old('nom_grade', $item->nom_grade) }}">
                                                                        @error('nom_grade')
                                                                            <span
                                                                                class="text-danger">{{ $message }}</span>
                                                                        @enderror
                                                                    </div>

                                                                    <button type="submit"
                                                                        class="mr-2 btn btn-primary">Enregistrer</button>
                                                                </form>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Fermer</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <a href="{{ route('delete.grade', $item->id) }}" class="btn btn-danger"
                                                    id="delete"><i data-feather="trash-2"></i></a>
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
                $('#addGradeModal').modal('show');
            });
        });
    </script>
@endsection
