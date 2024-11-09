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
                                    src=" {{ !empty($profileData->photo) ? url('upload/admin_images/' . $profileData->photo) : url('upload/no_image.jpeg') }} "
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
                    <div class="col-md-12">
                        <div class="card">
                        <div class="card-body">

                            <h6 class="card-title">Profile Administrateur</h6>

                            <form class="forms-sample" method="POST" action=" {{route('admin.profile.store')}} " enctype="multipart/form-data">

                              @csrf

                                <div class="mb-3">
                                    <label for="exampleInputUsername1" class="form-label">Nom</label>
                                    <input type="text" class="form-control" name="name" id="exampleInputUsername1"
                                        autocomplete="off" value="{{ $profileData->name }}">
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputUsername1" class="form-label">Prénom(s)</label>
                                    <input type="text" class="form-control" name="prenom" id="exampleInputUsername1"
                                        autocomplete="off" value="{{ $profileData->prenom }}">
                                </div>

                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" id="exampleInputEmail1"
                                        value="{{ $profileData->email }}">
                                </div>

                                <div class="mb-3">
                                    <label for="exampleInputUsername1" class="form-label">Téléphone</label>
                                    <input type="text" class="form-control" name="telephone" id="exampleInputUsername1"
                                        autocomplete="off" value="{{ $profileData->telephone }}">
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputUsername1" class="form-label">adresse</label>
                                    <input type="text" class="form-control" name="adresse" id="exampleInputUsername1"
                                        autocomplete="off" value="{{ $profileData->adresse }}">
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputUsername1" class="form-label">Photo</label>
                                    <input type="file" class="form-control" name="photo" id="image"
                                        value="{{ $profileData->matricule }}">
                                </div>

                                <div class="mb-3">
                                    <label for="exampleInputUsername1" class="form-label"></label>
                                    <img id="showImage" class="wd-80 rounded-circle"
                                        src=" {{ !empty($profileData->photo) ? url('upload/admin_images/' . $profileData->photo) : url('upload/no_image.jpeg') }} "
                                        alt="profile">
                                </div>

                        </div>
                        <button type="submit" class="mr-2 btn btn-primary">Mise à jour</button>

                        </form>

                    </div>
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


    <script type="text/javascript">
        $(document).ready(function() {

            $('#image').change(function() {

                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);

            });


        });
    </script>
@endsection
