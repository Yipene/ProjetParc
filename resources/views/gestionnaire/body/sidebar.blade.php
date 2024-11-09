<style>
    /* Changer la couleur de fond du sidebar */
    .sidebar {
        background-color: #2c3e50;
    }

    /* Faire toutes les écritures en blanc dans le sidebar */
    .sidebar,
    .sidebar a,
    .sidebar .nav-category,
    .sidebar .nav-link {
        color: #ffffff !important;
    }

    /* Changer la couleur du texte dans le sidebar */
    .sidebar,
    .sidebar a {
        color: #ecf0f1;
    }

    /* Modifier la couleur des liens au survol */
    .sidebar .nav-link:hover {
        color: #3498db;
    }

    /* Pour les titres de catégories */
    .sidebar .nav-category {
        color: #ffffff;
    }
</style>

<nav class="sidebar">
    <div class="sidebar-header">
        <a href="#" class="sidebar-brand">
            Bureau<span>Gestionnaire</span>
        </a>
    </div>
    <div class="sidebar-body">
        <ul class="nav">
            <li class="nav-item nav-category">Bureau Gestionnaire</li>
            <li class="nav-item">
                <a href="{{ route('gestionnaire.dashboard') }}" class="nav-link">
                    <i class="link-icon" data-feather="home"></i>
                    <span class="link-title">Accueil</span>
                </a>
            </li>

            <li class="nav-item nav-category">Gestion Matériel</li>
            <li class="nav-item">
                <a href="{{ route('liste.acquisition') }}" class="nav-link">
                    <i class="link-icon" data-feather="package"></i>
                    <span class="link-title">Acquisitions</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('stock.acquisition') }}" class="nav-link">
                    <i class="link-icon" data-feather="package"></i>
                    <span class="link-title">Stock Acquisition</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('liste.dotation') }}" class="nav-link">
                    <i class="link-icon" data-feather="package"></i>
                    <span class="link-title">Dotations</span>
                </a>
            </li>

            <li class="nav-item nav-category">Prédéfinition</li>
            <li class="nav-item">
                <a href="{{ route('liste.type') }}" class="nav-link">
                    <i class="link-icon" data-feather="list"></i>
                    <span class="link-title">Les Types d'Equipement</span>
                </a>
            </li>
            
        </ul>
    </div>
</nav>
