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
            Parc<span>Informatique</span>
        </a>
        <div class="sidebar-toggler not-active">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <div class="sidebar-body">
        <ul class="nav">
            <li class="nav-item nav-category">ATELIER MAINTENANCE</li>
            <li class="nav-item">
                <a href="{{ route('atelier.dashboard') }}" class="nav-link">
                    <i class="link-icon" data-feather="home"></i>
                    <span class="link-title">Accueil</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('liste.technicien') }}" class="nav-link">
                    <i class="link-icon" data-feather="star"></i>
                    <span class="link-title">Les Techniciens de L'atelier</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('liste.maintenance') }}" class="nav-link">
                    <i class="link-icon" data-feather="list"></i>
                    <span class="link-title">Liste de maintenances</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('stock.equipement') }}" class="nav-link">
                    <i class="link-icon" data-feather="briefcase"></i>
                    <span class="link-title">Stock Maintenance</span>
                </a>
            </li>
        </ul>
    </div>
</nav>
