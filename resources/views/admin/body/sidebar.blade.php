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
        <a href="#" class="sidebar-brand" style="color: rgb(204, 27, 27)">
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
            <li class="nav-item nav-category">BUREAU ADMINISTRATEUR</li>
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link">
                    <i class="link-icon" data-feather="home"></i>
                    <span class="link-title">Accueil</span>
                </a>
            </li>

            <li class="nav-item nav-category">Rôles et Permissions</li>
            <li class="nav-item">
                <a href="{{ route('all.permission') }}" class="nav-link">
                    <i class="link-icon" data-feather="mail"></i>
                    <span class="link-title">Toutes les permissions</span>
                </a>
            </li>

            <li class="nav-item nav-category">Gestion des Utilisateurs</li>
            <li class="nav-item">
                <a href="{{ route('admin.users.liste') }}" class="nav-link">
                    <i class="link-icon" data-feather="users"></i>
                    <span class="link-title">Liste des utilisateurs</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('liste.service') }}" class="nav-link">
                    <i class="link-icon" data-feather="list"></i>
                    <span class="link-title">Les Services</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('liste.grade') }}" class="nav-link">
                    <i class="link-icon" data-feather="list"></i>
                    <span class="link-title">Les Grades</span>
                </a>
            </li>
        </ul>
    </div>
</nav>
