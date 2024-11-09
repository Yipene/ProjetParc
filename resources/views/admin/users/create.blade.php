@extends('admin.admin_dashboard')

@section('admin')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ajouter un Utilisateur</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <!-- Core CSS -->
    <link rel="stylesheet" href="../../../assets/vendors/core/core.css">
    <link rel="stylesheet" href="../../../assets/fonts/feather-font/css/iconfont.css">
    <link rel="stylesheet" href="../../../assets/css/demo1/style.css">
    <link rel="shortcut icon" href="../../../assets/images/favicon.png" />
</head>
<body>
    <div class="main-wrapper">
        <div class="page-wrapper full-page">
            <div class="page-content d-flex align-items-center justify-content-center">
                <div class="row w-100 mx-0 auth-page">
                    <div class="col-md-8 col-xl-6 mx-auto">
                        <div class="card">
                            <div class="row">
                                
                                <div class="col-md-8 ps-md-0">
                                    <div class="auth-form-wrapper px-4 py-5">
                                        <h1 class="text-muted fw-normal mb-4">Ajouter un Utilisateur</h1>

                                        @if ($errors->any())
                                            <div class="alert alert-danger">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif

                                        <form action="{{ route('admin.users.store') }}" method="POST">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="name" class="form-label">Nom</label>
                                                <input type="text" class="form-control" name="name" id="name" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="prenom" class="form-label">Prénom</label>
                                                <input type="text" class="form-control" name="prenom" id="prenom">
                                            </div>
                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email</label>
                                                <input type="email" class="form-control" name="email" id="email" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="password" class="form-label">Mot de passe</label>
                                                <input type="password" class="form-control" name="password" id="password" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="role" class="form-label">Rôle</label>
                                                <select class="form-select" name="role" id="role" required>
                                                    <option value="admin">Admin</option>
                                                    <option value="gestionnaire">Gestionnaire</option>
                                                    <option value="technicien">Technicien</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="statut" class="form-label">Statut</label>
                                                <select class="form-select" name="statut" id="statut" required>
                                                    <option value="actif">Actif</option>
                                                    <option value="inactif">Inactif</option>
                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Créer l'utilisateur</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Core JS -->
    <script src="../../../assets/vendors/core/core.js"></script>
    <script src="../../../assets/vendors/feather-icons/feather.min.js"></script>
    <script src="../../../assets/js/template.js"></script>
</body>
</html>
@endsection
