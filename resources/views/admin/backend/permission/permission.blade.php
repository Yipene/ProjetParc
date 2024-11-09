@extends('admin.admin_dashboard')

@section('admin')
    <div class="page-content">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">

                <!-- Bouton pour activer le modal -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addTechnicianModal">
                    Ajouter Permission
                </button>

                <!-- Modal pour ajouter un technicien -->
                <div class="modal fade" id="addTechnicianModal" tabindex="-1" role="dialog"
                    aria-labelledby="addTechnicianModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addTechnicianModalLabel">Ajouter Une Permission</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">

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
                        <h6 class="card-title">Les Permissions</h6>
                        <div class="table-responsive">
                            <table id="dataTableExample" class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nom Permission</th>
                                        <th>Nom Groupe</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>



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
