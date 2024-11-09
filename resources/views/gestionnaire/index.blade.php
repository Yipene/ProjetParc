@extends('gestionnaire.gestionnaire_dashboard')

@section('gestionnaire')
    <div class="page-content">

        <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
            <div>
                <h4 class="mb-3 mb-md-0"> <strong>Tableau du Gestionnaire </strong></h4>
            </div>
            <div class="d-flex align-items-center flex-wrap text-nowrap">
                <div class="input-group flatpickr wd-200 me-2 mb-2 mb-md-0" id="dashboardDate">
                    <span class="input-group-text input-group-addon bg-transparent border-primary" data-toggle><i
                            data-feather="calendar" class="text-primary"></i></span>
                    <input type="text" class="form-control bg-transparent border-primary" placeholder="Select date"
                        data-input>
                </div>
                <button type="button" class="btn btn-outline-primary btn-icon-text me-2 mb-2 mb-md-0">
                    <i class="btn-icon-prepend" data-feather="printer"></i>
                    Imprimer
                </button>
                <button type="button" class="btn btn-primary btn-icon-text mb-2 mb-md-0">
                    <i class="btn-icon-prepend" data-feather="download-cloud"></i>
                    Télécharger Rapport
                </button>
            </div>
        </div>
        <div class="row">

            <div class="col-xl-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Graphes des Acquisitions</h6>
                        <div class="flot-chart-wrapper">
                            <canvas id="myDonutChart"></canvas>
                        </div>
                        <div id="legend1"></div> <!-- Légende dynamique pour le premier graphique -->
                    </div>
                </div>
            </div>



            <div class="col-xl-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Histogramme des Dotations</h6>
                        <div class="flot-chart-wrapper">
                            <canvas id="myBarChart"></canvas> <!-- Le canvas pour le bar chart -->
                        </div>
                        <div id="legend2"></div> <!-- Légende dynamique pour le bar chart -->
                    </div>
                </div>
            </div>


            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Real-Time chart</h6>
                        <div class="flot-chart-wrapper">
                            <div class="flot-chart" id="flotRealTime"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    </div>




   
@endsection
