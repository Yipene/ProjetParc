@extends('admin.admin_dashboard')

@section('admin')
    <div class="page-content">

        <h1>Modifier l'utilisateur : {{ $user->name }}</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Nom</label>
                <input type="text" class="form-control" name="name" id="name" value="{{ $user->name }}" required>
            </div>
            <div class="mb-3">
                <label for="prenom" class="form-label">Prénom</label>
                <input type="text" class="form-control" name="prenom" id="prenom" value="{{ $user->prenom }}">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" id="email" value="{{ $user->email }}"
                    required>
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">Rôle</label>
                <select class="form-select" name="role" id="role" required>
                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="gestionnaire" {{ $user->role == 'gestionnaire' ? 'selected' : '' }}>Gestionnaire</option>
                    <option value="technicien" {{ $user->role == 'technicien' ? 'selected' : '' }}>Technicien</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="statut" class="form-label">Statut</label>
                <select class="form-select" name="statut" id="statut" required>
                    <option value="actif" {{ $user->statut == 'actif' ? 'selected' : '' }}>Actif</option>
                    <option value="inactif" {{ $user->statut == 'inactif' ? 'selected' : '' }}>Inactif</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Mettre à jour l'utilisateur</button>
        </form>

    </div>
@endsection
