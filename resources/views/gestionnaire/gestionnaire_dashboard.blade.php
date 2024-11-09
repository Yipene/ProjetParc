<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Responsive HTML Admin Dashboard Template based on Bootstrap 5">
    <meta name="author" content="NobleUI">
    <meta name="keywords"
        content="nobleui, bootstrap, bootstrap 5, bootstrap5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

    <title>Gestionnaire</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <!-- End fonts -->

    <!-- core:css -->
    <link rel="stylesheet" href=" {{ asset('../assets/vendors/core/core.css') }} ">
    <!-- endinject -->

    <!-- Plugin css for this page -->
    <link rel="stylesheet" href=" {{ asset('../assets/vendors/flatpickr/flatpickr.min.css') }} ">
    <!-- End plugin css for this page -->

    <!-- inject:css -->
    <link rel="stylesheet" href=" {{ asset('../assets/fonts/feather-font/css/iconfont.css') }} ">
    <link rel="stylesheet" href=" {{ asset('../assets/vendors/flag-icon-css/css/flag-icon.min.css') }} ">
    <!-- endinject -->

    <!-- Layout styles -->
    <link rel="stylesheet" href=" {{ asset('../assets/css/demo1/style.css') }}  ">
    <!-- End layout styles -->

    <link rel="shortcut icon" href=" {{ asset('../assets/images/favicon.png') }} ">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">

    <link rel="stylesheet" href="{{ asset('../assets/vendors/datatables.net-bs5/dataTables.bootstrap5.css') }}">
</head>

<body>
    <div class="main-wrapper">

        <!-- partial:partials/_sidebar.html -->

        @include('gestionnaire.body.sidebar')

        <!-- partial -->

        <div class="page-wrapper">

            <!-- partial:partials/_navbar.html -->

            @include('gestionnaire.body.header')

            <!-- partial -->

            @yield('gestionnaire')

            <!-- partial:partials/_footer.html -->

            @include('gestionnaire.body.footer')

            <!-- partial -->

        </div>
    </div>
<!-- core:js -->
<script src=" {{ asset('../assets/vendors/core/core.js') }} "></script>
<!-- endinject -->

<!-- Plugin js for this page -->
<script src=" {{ asset('../assets/vendors/flatpickr/flatpickr.min.js') }} "></script>
<script src=" {{ asset('../assets/vendors/apexcharts/apexcharts.min.js') }} "></script>
<!-- End plugin js for this page -->

 <!-- Plugin js for this page -->
 <script src="{{ asset('../assets/vendors/datatables.net/jquery.dataTables.js') }}"></script>
 <script src="{{ asset('../assets/vendors/datatables.net-bs5/dataTables.bootstrap5.js') }}"></script>
 <!-- End plugin js for this page -->

 <!-- Custom js for this page -->
 <script src="{{ asset('../assets/js/data-table.js') }}"></script>
 <!-- End custom js for this page -->
<!-- inject:js -->
<script src="../assets/vendors/feather-icons/feather.min.js"></script>
<script src="../assets/js/template.js"></script>
<!-- endinject -->

<!-- Custom js for this page -->
<script src=" {{ asset('../assets/js/dashboard-dark.js') }} "></script>
<!-- End custom js for this page -->

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- Plugin js for this page -->
    <script src="../../../assets/vendors/jquery.flot/jquery.flot.js"></script>
    <script src="../../../assets/vendors/jquery.flot/jquery.flot.resize.js"></script>
    <script src="../../../assets/vendors/jquery.flot/jquery.flot.pie.js"></script>
    <script src="../../../assets/vendors/jquery.flot/jquery.flot.categories.js"></script>
    <!-- End plugin js for this page -->

    <!-- inject:js -->
    <script src="../../../assets/vendors/feather-icons/feather.min.js"></script>
    <script src="../../../assets/js/template.js"></script>
    <!-- endinject -->

    <!-- Custom js for this page -->
    <script src="../../../assets/js/jquery.flot-dark.js"></script>


    <!-- Plugin js for this page -->
    <script src="../../../assets/vendors/apexcharts/apexcharts.min.js"></script>
    <!-- End plugin js for this page -->


    <!-- Custom js for this page -->
    <script src="../../../assets/js/apexcharts-dark.js"></script>

    <script>
        @if (Session::has('message'))
            var type = "{{ Session::get('alert-type', 'info') }}"
            switch (type) {
                case 'info':
                    toastr.info(" {{ Session::get('message') }} ");
                    break;

                case 'success':
                    toastr.success(" {{ Session::get('message') }} ");
                    break;

                case 'warning':
                    toastr.warning(" {{ Session::get('message') }} ");
                    break;

                case 'error':
                    toastr.error(" {{ Session::get('message') }} ");
                    break;
            }
        @endif
    </script>



    <script src="https://cdnjs.cloudflare.com/ajax/libs/flot/0.8.3/jquery.flot.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flot/0.8.3/jquery.flot.pie.min.js"></script>
    <!-- Plugin js for this page -->
    <script src="../../../assets/vendors/jquery.flot/jquery.flot.js"></script>
    <script src="../../../assets/vendors/jquery.flot/jquery.flot.resize.js"></script>
    <script src="../../../assets/vendors/jquery.flot/jquery.flot.pie.js"></script>
    <script src="../../../assets/vendors/jquery.flot/jquery.flot.categories.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="../../../assets/vendors/feather-icons/feather.min.js"></script>
    <script src="../../../assets/js/template.js"></script>
    <!-- endinject -->

    <!-- Custom js for this page -->
    <script src="../../../assets/js/jquery.flot-dark.js"></script>
    <!-- End custom js for this page -->

    <script type="text/javascript">
        /// Non fonctionnel a gerer plutard ///
        $(function() {
            // Fonction pour récupérer les données de stock via AJAX
            function recupererDonneesStock() {
                $.ajax({
                    url: '{{ route('stock.graphique') }}',
                    method: 'GET',
                    success: function(donnees) {
                        afficherGraphique(donnees);
                    },
                    error: function(err) {
                        console.log("Erreur lors de la récupération des données de stock:", err);
                    }
                });
            }

            // Fonction pour afficher le graphique en utilisant Flot.js
            function afficherGraphique(donneesStock) {
                $.plot('#flotPie', donneesStock, {
                    series: {
                        pie: {
                            show: true,
                            radius: 1,
                            label: {
                                show: true,
                                radius: 0.8,
                                formatter: formatteurEtiquette,
                                background: {
                                    opacity: 0.8
                                }
                            }
                        }
                    },
                    legend: {
                        show: false
                    }
                });
            }

            // Formatteur pour afficher les étiquettes sur le graphique
            function formatteurEtiquette(label, serie) {
                return '<div style="font-size:8pt;text-align:center;padding:2px;color:black;">' +
                    label + '<br/>' + Math.round(serie.percent) + '%</div>';
            }

            // Appel pour récupérer et afficher les données
            recupererDonneesStock();
        });
    </script>


    <!-- Inclure Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="{{ asset('backend/assets/js/code/code.js') }}"></script>

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

                const labels = stockData.map(item => item.label); // Les labels pour chaque segment
                const dataValues = stockData.map(item => item.data); // Quantités correspondantes

                // Utiliser les couleurs prédéfinies jusqu'à la taille des labels
                const backgroundColors = donutColors.slice(0, labels.length);
                const borderColors = backgroundColors;

                const data = {
                    labels: labels,
                    datasets: [{
                        label: "Quantité",
                        data: dataValues,
                        backgroundColor: backgroundColors, // Couleurs des segments
                        borderColor: borderColors, // Couleur des bordures des segments
                        borderWidth: 2
                    }]
                };

                const config = {
                    type: 'doughnut', // Définir le type comme doughnut (donut chart)
                    data: data,
                    options: {
                        cutout: '40%', // Créer l'effet de "donut"
                        responsive: true,
                        plugins: {
                            legend: {
                                display: true, // Afficher la légende
                            },
                            title: {
                                display: true,
                                text: 'Répartition des acquisitions par Types' // Titre du graphique
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
                    return i === index ? color : 'rgba(0, 0, 0, 0.3)'; // Atténuer les segments non sélectionnés
                });
                chart.data.datasets[0].backgroundColor = newBackgroundColors;
                chart.update(); // Mettre à jour le graphique
            }
        }

        // Appel de la fonction pour créer le Donut Chart
        createDonutChart('myDonutChart', 'legend1', '/Graphique/Stock'); // Route pour les données du donut chart
    </script>

    <style>
        #legend1 {
            font-size: 16px;
            font-weight: bold;
            margin-top: 10px;
        }
    </style>

    <script>
        // Définir des couleurs personnalisées pour chaque barre du bar chart
        const barColors = [
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

        // Fonction pour créer le bar chart
        async function createBarChart(canvasId, legendId, url) {
            try {
                const stockData = await fetchStockData(url);

                const labels = stockData.map(item => item.label); // Les labels pour chaque catégorie
                const dataValues = stockData.map(item => item.data); // Quantités correspondantes

                // Utiliser les couleurs prédéfinies pour chaque barre
                const backgroundColors = barColors.slice(0, labels.length);
                const borderColors = backgroundColors;

                const data = {
                    labels: labels,
                    datasets: [{
                        label: "Quantité",
                        data: dataValues,
                        backgroundColor: backgroundColors, // Couleurs des barres
                        borderColor: borderColors, // Couleur des bordures
                        borderWidth: 2
                    }]
                };

                const config = {
                    type: 'bar', // Définir le type comme bar chart
                    data: data,
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: false, // Cacher la légende interne du chart
                            },
                            title: {
                                display: true,
                                text: 'Répartition des dotations par Types'
                            }
                        },
                        scales: {
                            x: {
                                beginAtZero: true, // L'axe X commence à 0
                            },
                            y: {
                                beginAtZero: true, // L'axe Y commence à 0
                            }
                        },
                        onClick: (event, elements) => {
                            if (elements.length > 0) {
                                const index = elements[0].index;
                                const label = data.labels[index];
                                const value = data.datasets[0].data[index];
                                updateLegend(legendId, label, value);
                                highlightBar(canvasId, index);
                            }
                        }
                    }
                };

                new Chart(document.getElementById(canvasId), config);
            } catch (error) {
                console.error("Erreur lors de la création du Bar Chart:", error);
            }
        }

        // Fonction pour mettre à jour la légende dynamique
        function updateLegend(legendId, label, value) {
            const legendDiv = document.getElementById(legendId);
            legendDiv.innerHTML = `<strong>${label}</strong>: ${value}`;
        }

        // Fonction pour mettre en surbrillance la barre cliquée
        function highlightBar(canvasId, index) {
            const chart = Chart.instances.find(c => c.canvas.id === canvasId);
            if (chart) {
                const newBackgroundColors = chart.data.datasets[0].backgroundColor.map((color, i) => {
                    return i === index ? color : 'rgba(0, 0, 0, 0.3)'; // Atténuer les barres non sélectionnées
                });
                chart.data.datasets[0].backgroundColor = newBackgroundColors;
                chart.update(); // Mettre à jour le graphique
            }
        }

        // Appel de la fonction pour créer le Bar Chart
        createBarChart('myBarChart', 'legend2', '/Dotation/Stock'); // Route pour les données du bar chart
    </script>

    <style>
        #legend2 {
            font-size: 16px;
            font-weight: bold;
            margin-top: 10px;
        }
    </style>





</body>

</html>
