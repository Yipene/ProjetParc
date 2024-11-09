@extends('gestionnaire.gestionnaire_dashboard')

@section('gestionnaire')
    <div class="page-content">
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Stock des Acquisitions par Type d'Équipement</h6>
                        <div class="table-responsive">
                            <table id="dataTableExample" class="table">
                                <thead>
                                    <tr>
                                        <th>Type d'Équipement</th>
                                        <th>Quantité Totale</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($stock as $item)
                                        <tr>
                                            <td>{{ $item->nom_type }}</td>
                                            <td>{{ $item->quantite_totale }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Statistiques du Stock par Type d'équipement</h6>
                        <canvas id="myDonutChart"></canvas>
                        <div id="legend" class="mt-3"></div>
                    </div>
                </div>
            </div>
        </div>




    </div>
@endsection
