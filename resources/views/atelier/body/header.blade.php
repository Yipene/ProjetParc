<nav class="navbar">
    <a href="#" class="sidebar-toggler">
        <i data-feather="menu"></i>
    </a>
    <div class="navbar-content" style="background: black">

        <ul class="navbar-nav">

            @php

                $id = Auth::user()->id;

                $profileData = App\Models\User::find( $id );

            @endphp



            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="wd-30 ht-30 rounded-circle" src="{{ !empty($profileData->photo) ? url('upload/atelier_images/'.$profileData->photo) : url('upload/no_image.jpeg') }} " alt="profile">
                </a>
                <div class="dropdown-menu p-0" aria-labelledby="profileDropdown">
                    <div class="d-flex flex-column align-items-center border-bottom px-5 py-3">
                        <div class="mb-3">
                            <img class="wd-100 ht-80 rounded-circle" src=" {{ !empty($profileData->photo) ? url('upload/atelier_images/'.$profileData->photo) : url('upload/no_image.jpeg') }}"
                                alt="">
                        </div>
                        <div class="text-center">
                            <p class="tx-16 fw-bolder"> {{$profileData->name}} </p>
                            <p class="tx-12 text-muted"> {{$profileData->email}} </p>
                        </div>
                    </div>
                    <ul class="list-unstyled p-1">
                        <li class="dropdown-item py-2">
                            <a href=" {{ route('atelier.profile') }} " class="text-body ms-0">
                                <i class="me-2 icon-md" data-feather="user"></i>
                                <span>Profil</span>
                            </a>
                        </li>
                        <li class="dropdown-item py-2">
                            <a href="{{ route('atelier.change.password') }}"  class="text-body ms-0">
                                <i class="me-2 icon-md" data-feather="edit"></i>
                                <span>Changer le Mot de Passe</span>
                            </a>
                        </li>
                        <li class="dropdown-item py-2">
                            <a href=" {{ route('atelier.logout') }} " class="text-body ms-0">
                                <i class="me-2 icon-md" data-feather="log-out"></i>
                                <span>Déconnexion</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</nav>
