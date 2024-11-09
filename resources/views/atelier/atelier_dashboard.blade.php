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

    <title>Atelier</title>

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

        @include('atelier.body.sidebar')

        <!-- partial -->

        <div class="page-wrapper">

            <!-- partial:partials/_navbar.html -->

            @include('atelier.body.header')

            <!-- partial -->

            @yield('atelier')

            <!-- partial:partials/_footer.html -->

            @include('atelier.body.footer')

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
    <script src="{{ asset('backend/assets/js/code/code.js') }}"></script>

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

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Définir des couleurs personnalisées pour chaque segment
        const colors = [
            '#FF6384',
            '#36A2EB',
            '#FFCE56',
            '#4BC0C0',
            '#9966FF',
            '#FF9F40',
            '#FFB6C1',
            '#8A2BE2',
            '#00FA9A',
            '#808000'
        ];

        // Fonction pour récupérer les données de stock
        async function fetchStockData(url) {
            const response = await fetch(url);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        }

        // Fonction pour créer le graphique
        async function createStockChart(canvasId, url) {
            try {
                const stockData = await fetchStockData(url);

                const labels = stockData.map(item => item.label); // Labels pour chaque segment
                const dataValues = stockData.map(item => item.data); // Quantités correspondantes

                const data = {
                    labels: labels,
                    datasets: [{
                        label: "Quantité de Stocks",
                        data: dataValues,
                        backgroundColor: colors.slice(0, labels.length), // Couleurs des segments
                        borderColor: 'rgba(0, 0, 0, 0.1)', // Couleur des bordures
                        borderWidth: 1
                    }]
                };

                const config = {
                    type: 'bar', // Définir le type comme bar chart
                    data: data,
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: true,
                            },
                            title: {
                                display: true,
                                text: 'Stocks de Maintenance par Type d\'Équipement' // Titre du graphique
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true // Commencer à zéro sur l'axe Y
                            }
                        }
                    },
                };

                new Chart(document.getElementById(canvasId), config);
            } catch (error) {
                console.error("Erreur lors de la création du graphique:", error);
            }
        }

        // Appel de la fonction pour créer le graphique
        createStockChart('myStockChart', '{{ route('maintenance.stock.graphique') }}'); // Route pour récupérer les données
    </script>


</body>

</html>
