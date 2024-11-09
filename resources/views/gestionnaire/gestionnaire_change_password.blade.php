@extends('admin.admin_dashboard')

@section('admin')
    <div class="page-content">


        <div class="row profile-body">
            <!-- left wrapper start -->
            <div class="d-none d-md-block col-md-4 col-xl-3 left-wrapper">
                <div class="card rounded">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-2">

                            <div>
                                <img class="wd-70 rounded-circle"
                                    src=" {{ !empty($profileData->photo) ? url('upload/gestionnaire_images/' . $profileData->photo) : url('upload/no_image.jpeg') }} "
                                    alt="profile">
                                <span class="h4 ms-3 "> {{ $profileData->name }} </span>
                            </div>


                        </div>
                        <p>Hi! I'm Amiah the Senior UI Designer at NobleUI. We hope you enjoy the design and quality of
                            Social.</p>
                        <div class="mt-3">
                            <label class="tx-11 fw-bolder mb-0 text-uppercase">Nom:</label>
                            <p class="text-muted">{{ $profileData->name }}</p>
                        </div>
                        <div class="mt-3">
                            <label class="tx-11 fw-bolder mb-0 text-uppercase">Prénom(s):</label>
                            <p class="text-muted">{{ $profileData->prenom }}</p>
                        </div>
                        <div class="mt-3">
                            <label class="tx-11 fw-bolder mb-0 text-uppercase">Email:</label>
                            <p class="text-muted">{{ $profileData->email }}</p>
                        </div>
                        <div class="mt-3">
                            <label class="tx-11 fw-bolder mb-0 text-uppercase">Téléphone</label>
                            <p class="text-muted">{{ $profileData->telephone }}</p>
                        </div>
                        <div class="mt-3">
                            <label class="tx-11 fw-bolder mb-0 text-uppercase">Adresse</label>
                            <p class="text-muted">{{ $profileData->adresse }}</p>
                        </div>
                        <div class="mt-3">
                            <label class="tx-11 fw-bolder mb-0 text-uppercase">Matricule</label>
                            <p class="text-muted">{{ $profileData->matricule }}</p>
                        </div>

                    </div>
                </div>
            </div>
            <!-- left wrapper end -->
            <!-- middle wrapper start -->
            <div class="col-md-8 col-xl-6 middle-wrapper">
                <div class="row">
                    <div class="card">
                        <div class="card-body">

                            <h6 class="card-title">Changer le Mot de Passe</h6>

                            <form method="POST" action="{{ route('gestionnaire.update.password') }}" class="forms-sample"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <label for="exampleInputUsername1">Ancien Mot de Passe</label>
                                            <input type="password"
                                                class="form-control @error('old_password') is-invalid @enderror"
                                                name="old_password"id="old_password" autocomplete="off" value="">
                                            @error('old_password')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputUsername1">Nouveau Mot de Passe</label>
                                            <input type="password"
                                                class="form-control @error('new_password') is-invalid @enderror"
                                                name="new_password"id="new_password" autocomplete="off" value="">
                                            @error('new_password')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Confirmer nouveau Mot de Passe</label>
                                            <input type="password" class="form-control" name="new_password_confirmation"
                                                id="new_password_confirmation">
                                        </div>

                                        <button type="submit" class="mr-2 btn btn-primary">Mise à jour</button>
                            </form>

                    </div>
                </div>

            </div>
        </div>
        <!-- middle wrapper end -->
        <!-- right wrapper start -->
        <div class="d-none d-xl-block col-xl-3">

        </div>
        <!-- right wrapper end -->
    </div>
@endsection
