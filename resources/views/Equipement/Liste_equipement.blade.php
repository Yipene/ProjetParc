@extends('gestionnaire.gestionnaire_dashboard')

@section('gestionnaire')
    <div class="page-content">



        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Stock des Equipements</h6>
                        <div class="table-responsive">
                            <table id="dataTableExample" class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>

                                        <th>Marque</th>
                                        <th>Modèle</th>
                                        <th>Numéro de Série</th>
                                        <th>Type de l'équipement</th>

                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($equipements as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->marque }}</td>
                                            <td>{{ $item->modele }}</td>
                                            <td>{{ $item->numero_serie }}</td>
                                            <td>{{ $item->typeEquipement->nom_type }}</td>



                                            <td>

                                                <a href="{{ route('delete.equipement', $item->id) }}"
                                                    class="btn btn-inverse-danger" id="delete">Supprimer</a>
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
@endsection
