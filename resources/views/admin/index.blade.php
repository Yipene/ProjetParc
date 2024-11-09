@extends('admin.admin_dashboard')

@section('admin')
    <div class="page-content">

        <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
            <div>
                <h4 class="mb-3 mb-md-0"> <strong>Tableau Administrateur</strong></h4>
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
            <div class="col-lg-7 col-xl-8 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex justify-content-between align-items-baseline mb-2">
                    <h6 class="card-title mb-0">Rapports mensuel</h6>
                    <div class="dropdown mb-2">
                      <a type="button" id="dropdownMenuButton4" data-bs-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                      </a>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton4">
                        <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="eye"
                            class="icon-sm me-2"></i> <span class="">Voir</span></a>
                        <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="edit-2"
                            class="icon-sm me-2"></i> <span class="">Modifier</span></a>
                        <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="trash"
                            class="icon-sm me-2"></i> <span class="">Supprimer</span></a>
                        <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="printer"
                            class="icon-sm me-2"></i> <span class="">Imprimer</span></a>
                        <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="download"
                            class="icon-sm me-2"></i> <span class="">Télécharger</span></a>
                      </div>
                    </div>
                  </div>

                  <div id="monthlySalesChart"></div>
                </div>
              </div>
            </div>
            <div class="col-lg-5 col-xl-4 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex justify-content-between align-items-baseline">
                    <h6 class="card-title mb-0">Stockage</h6>
                    <div class="dropdown mb-2">
                      <a type="button" id="dropdownMenuButton5" data-bs-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                      </a>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton5">
                        <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="eye"
                            class="icon-sm me-2"></i> <span class="">View</span></a>
                        <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="edit-2"
                            class="icon-sm me-2"></i> <span class="">Edit</span></a>
                        <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="trash"
                            class="icon-sm me-2"></i> <span class="">Delete</span></a>
                        <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="printer"
                            class="icon-sm me-2"></i> <span class="">Print</span></a>
                        <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="download"
                            class="icon-sm me-2"></i> <span class="">Download</span></a>
                      </div>
                    </div>
                  </div>
                  <div id="storageChart"></div>
                  <div class="row mb-3">
                    <div class="col-6 d-flex justify-content-end">
                      <div>
                        <label class="d-flex align-items-center justify-content-end tx-10 text-uppercase fw-bolder">Stockage total <span class="p-1 ms-1 rounded-circle bg-secondary"></span></label>
                        <h5 class="fw-bolder mb-0 text-end">8TB</h5>
                      </div>
                    </div>
                    <div class="col-6">
                      <div>
                        <label class="d-flex align-items-center tx-10 text-uppercase fw-bolder"><span
                            class="p-1 me-1 rounded-circle bg-primary"></span> Espace Utilisé</label>
                        <h5 class="fw-bolder mb-0">~5TB</h5>
                      </div>
                    </div>
                  </div>
                  <div class="d-grid">
                    <button class="btn btn-primary">Mettre à jour le stockage</button>
                  </div>
                </div>
              </div>
            </div>
          </div>



    </div>

    <script>
        // Définir des couleurs personnalisées pour chaque segment du donut chart
        const donutColors = [
            '#FF6384', // Rouge
            '#36A2EB', // Bleu
            '#FFCE56', // Jaune
            '#4BC0C0', // Vert Eau
            '#9966FF', // Violet
            '#FF9F40', // Orange
            '#FFB6C1', // Rose Clair
            '#8A2BE2', // Bleu Violet
            '#00FA9A', // Vert Clair
            '#808000' // Olive
        ];

        // Fonction pour récupérer les données de stock
        async function fetchStockData(url) {
            const response = await fetch(url);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        }

        // Fonction pour créer le donut chart
        async function createDonutChart(canvasId, legendId, url) {
            try {
                const stockData = await fetchStockData(url);

                console.log('Données de stock récupérées:', stockData); // Debugging ici

                const labels = stockData.map(item => item.label);
                const dataValues = stockData.map(item => item.data);

                // Vérifier les labels et les valeurs
                console.log('Labels:', labels);
                console.log('Données:', dataValues);

                // Utiliser les couleurs prédéfinies jusqu'à la taille des labels
                const backgroundColors = donutColors.slice(0, labels.length);
                const borderColors = backgroundColors;

                const data = {
                    labels: labels,
                    datasets: [{
                        label: "Quantité",
                        data: dataValues,
                        backgroundColor: backgroundColors,
                        borderColor: borderColors,
                        borderWidth: 2
                    }]
                };

                const config = {
                    type: 'doughnut',
                    data: data,
                    options: {
                        cutout: '40%',
                        responsive: true,
                        plugins: {
                            legend: {
                                display: true,
                            },
                            title: {
                                display: true,
                                text: 'Répartition des acquisitions par Types'
                            }
                        },
                        onClick: (event, elements) => {
                            if (elements.length > 0) {
                                const index = elements[0].index;
                                const label = data.labels[index];
                                const value = data.datasets[0].data[index];
                                updateLegend(legendId, label, value);
                                highlightSegment(canvasId, index);
                            }
                        }
                    },
                };

                new Chart(document.getElementById(canvasId), config);
            } catch (error) {
                console.error("Erreur lors de la création du Donut Chart:", error);
            }
        }

        // Fonction pour mettre à jour la légende dynamique
        function updateLegend(legendId, label, value) {
            const legendDiv = document.getElementById(legendId);
            legendDiv.innerHTML = `<strong>${label}</strong>: ${value}`;
        }

        // Fonction pour mettre en surbrillance le segment cliqué
        function highlightSegment(canvasId, index) {
            const chart = Chart.instances.find(c => c.canvas.id === canvasId);
            if (chart) {
                const newBackgroundColors = chart.data.datasets[0].backgroundColor.map((color, i) => {
                    return i === index ? color : 'rgba(0, 0, 0, 0.3)';
                });
                chart.data.datasets[0].backgroundColor = newBackgroundColors;
                chart.update(); // Mettre à jour le graphique
            }
        }

        // Appel de la fonction pour créer le Donut Chart avec les routes adaptées
        createDonutChart('myDonutChart', 'legend1', '/admin/Graphique/Stock'); // Route pour les données du donut chart
    </script>

<style>
    #legend1 {
        font-size: 16px;
        font-weight: bold;
        margin-top: 10px;
    }
</style>


@endsection
