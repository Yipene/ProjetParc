@extends('atelier.atelier_dashboard')

@section('atelier')
    <div class="page-content">
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card"> <!-- Changé de col-md-12 à col-md-6 -->
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Stock des Équipements par Statut</h6>
                        <div class="table-responsive">
                            <table id="dataTableExample" class="table">
                                <thead>
                                    <tr>
                                        <th>Type d'Équipement</th>
                                        <th>Statut</th>
                                        <th>Quantité Totale</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($stock as $item)
                                        <tr>
                                            <td>{{ $item->nom_type }}</td>
                                            <td>{{ $item->statut }}</td>
                                            <td>{{ $item->quantite_totale }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Graphique de Stock</h6>
                        <div class="flot-chart-wrapper">
                            <canvas id="myStockChart" style="height: 400px;"></canvas>
                            <!-- Ajout d'une hauteur pour le canvas -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
