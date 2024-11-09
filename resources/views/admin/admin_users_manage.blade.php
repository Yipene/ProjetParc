@extends('admin.admin_dashboard')
@section('admin')


<div class="page-content">

    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <button type="button" class="btn btn-inverse-info" data-toggle="modal" data-target="#exampleModal">
                Ajouter Un Utilisateur
            </button>
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Ajouter Un utilisateur</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="card">
                                <div class=" card-body">
                                    <form method="POST" action="{{ route('users.store') }}" class="forms-sample" enctype="multipart/form-data">
                                        @csrf

                                        <div class="form-group">
                                            <label for="exampleInputUsername1">Matricule de l'Utilisateur</label>
                                            <input type="text" class="form-control @error('matricule') is-invalid @enderror" name="matricule" autocomplete="off" value="">
                                            @error('matricule')
                                            <span class="text-danger">{{ $message}}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputUsername1">Nom de l'Utilisateur</label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" autocomplete="off" value="">
                                            @error('name')
                                            <span class="text-danger">{{ $message}}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputUsername1">Prenom de l'Utilisateur</label>
                                            <input type="text" class="form-control @error('prenom') is-invalid @enderror" name="prenom" autocomplete="off" value="">
                                            @error('prenom')
                                            <span class="text-danger">{{ $message}}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="grade">Grade de l'utilisateur</label>
                                            <select required class="form-control @error('grade') is-invalid @enderror" id="grade" name="grade">
                                                <option value="" disabled selected>Choisir le
                                                    grade de l'Utilisateur</option>
                                                @if ($grades)
                                                @foreach ($grades as $item)
                                                <option value="{{ $item->nom }}">
                                                    {{ $item->nom }}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputUsername1">Email de l'Utilisateur</label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" autocomplete="off" value="">
                                            @error('email')
                                            <span class="text-danger">{{ $message}}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputUsername1">Telephone de l'Utilisateur</label>
                                            <input type="number" class="form-control @error('telephone') is-invalid @enderror" name="telephone" autocomplete="off" value="">
                                            @error('telephone')
                                            <span class="text-danger">{{ $message}}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputUsername1">Mot de passe de l'Utilisateur</label>
                                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="off" value="">
                                            @error('password')
                                            <span class="text-danger">{{ $message}}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="status">Status du User :</label>
                                            <select name="status" id="status" class="form-control">
                                                <option value="actif">Actif</option>
                                                <option value="inactif">Inactif</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="roles">Rôles :</label>
                                            <select name="roles[]" multiple class="form-control" required>
                                                @foreach($roles as $role)
                                                <option value="{{ $role }}">
                                                    {{ $role }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">
                                                <i class="fas fa-times"></i>Annuler
                                            </button>
                                            <button type="submit" class="btn btn-success">
                                                <i class="fas fa-save"></i> Enregistrer
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>


                        </div>

                    </div>
                </div>

            </div>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Les Differents utilisateurs</h6>
                    <div class="table-responsive" style="border-radius: 20px 20px 20px 20px;">

                        <table id="dataTableExample" class="table">
                            <thead>
                                <tr>
                                    <th>Id#</th>
                                    <th>Matricule</th>
                                    <th>Nom et Prenom de l'utilisateur</th>
                                    <th>Grade </th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Telephone</th>
                                    <th>Role</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($users as $key => $item )
                                <tr>
                                    <td>{{$key + 1}}</td>
                                    <td>{{$item->matricule}}</td>
                                    <td>{{$item->name}}--{{$item->prenom}}</td>
                                    <td>{{$item->grade}}</td>
                                    <td>{{$item->email}}</td>
                                    <td>{{$item->status}}</td>
                                    <td>{{$item->telephone}}</td>
                                    <td>
                                        @if (!empty($item->getRoleNames()))
                                        @foreach ($item->getRoleNames() as $rolename)
                                        <label class="badge bg-primary mx-1">{{ $rolename}}</label>
                                        @endforeach
                                        @else
                                        Aucun role associé
                                        @endif

                                    </td>
                                    <td>
                                        <!-- Button to trigger the modal pour modifier un user-->
                                        <button type="button" class="btn btn-inverse-warning" data-toggle="modal" data-target="#editModal{{$item->id}}">
                                            <i data-feather="edit"></i>
                                        </button>

                                        <!-- ouverture du modal de modification des donnees d'un User-->
                                        <div class="modal fade" id="editModal{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editModalLabel">Modifier l'Utilisateur</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <h6 class="card-title">Modifier les donnees de l'utilisateur</h6>
                                                                <form method="POST" action="{{ route('user.update') }}" class="forms-sample" enctype="multipart/form-data">
                                                                    @csrf
                                                                   
                                                                    <input type="hidden" name="id" value="{{$item->id}}">

                                                                    <div class="form-group">
                                                                        <label for="exampleInputUsername1">Matricule de l'Utilisateur</label>
                                                                        <input type="text" class="form-control @error('matriule') is-invalid @enderror" name="matricule" autocomplete="off" value="{{$item->matricule}}">
                                                                        @error('matricule')
                                                                        <span class="text-danger">{{ $message}}</span>
                                                                        @enderror
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="exampleInputUsername1">Nom de l'Utilisateur</label>
                                                                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" autocomplete="off" value="{{$item->name}}">
                                                                        @error('name')
                                                                        <span class="text-danger">{{ $message}}</span>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="exampleInputUsername1">Prenom de l'Utilisateur</label>
                                                                        <input type="text" class="form-control @error('prenom') is-invalid @enderror" name="prenom" autocomplete="off" value="{{$item->prenom}}">
                                                                        @error('prenom')
                                                                        <span class="text-danger">{{ $message}}</span>
                                                                        @enderror
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="exampleInputUsername1">Grade de l'Utilisateur</label>
                                                                        <input type="text" class="form-control @error('grade') is-invalid @enderror" name="grade" autocomplete="off" value="{{$item->grade}}">
                                                                        @error('grade')
                                                                        <span class="text-danger">{{ $message}}</span>
                                                                        @enderror
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="exampleInputUsername1">Email de l'Utilisateur</label>
                                                                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" autocomplete="off" value="{{$item->email}}">
                                                                        @error('email')
                                                                        <span class="text-danger">{{ $message}}</span>
                                                                        @enderror
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="exampleInputUsername1">Status de l'Utilisateur</label>
                                                                        <input type="text" class="form-control @error('status') is-invalid @enderror" name="status" autocomplete="off" value="{{$item->status}}">
                                                                        @error('status')
                                                                        <span class="text-danger">{{ $message}}</span>
                                                                        @enderror
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="exampleInputUsername1">Telephone de l'Utilisateur</label>
                                                                        <input type="text" class="form-control @error('telephone') is-invalid @enderror" name="telephone" autocomplete="off" value="{{$item->telephone}}">
                                                                        @error('telephone')
                                                                        <span class="text-danger">{{ $message}}</span>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="form-group">
                                                                   
                                                                        <label for="roles">Rôles :</label>
                                                                        <select name="roles[]" multiple class="form-control" required>
                                                                            @foreach($roles as $role)
                                                                            <option value="{{ $role }}">
                                                                                {{ $role }}
                                                                            </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>

                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">
                                                                            <i class="fas fa-times"></i>Annuler
                                                                        </button>
                                                                        <button type="submit" class="btn btn-success">
                                                                            <i class="fas fa-save"></i> Enregistrer
                                                                        </button>
                                                                    </div>


                                                                </form>

                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Button de supression d'un user -->
                                        <a href="{{route('delete.user',$item->id)}}" class="btn btn-inverse-danger" id="delete"><i data-feather="trash-2"></i></a>


                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


@endsection
