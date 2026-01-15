<div class="layout-page">
    <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
        <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
            <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="bx bx-menu bx-sm"></i>
            </a>
        </div>

        <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">

            <div class="navbar-nav align-items-center">
                <div class="nav-item d-flex align-items-center">
                    {{-- Sesuaikan teks dan ukuran font (fs-4) sesuai selera --}}
                    <span class="fw-bold fs-4 text-primary">BPJS KETENAGAKERJAAN PEKANBARU KOTA</span>
                </div>
            </div>

            <ul class="navbar-nav flex-row align-items-center ms-auto">

                @guest
                <li class="nav-item">
                    <a href="{{ route('login') }}" class="btn btn-primary btn-sm">
                        <i class="bx bx-log-in me-1"></i> Login
                    </a>
                </li>
                @endguest

                @auth
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                    <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                        <div class="avatar avatar-online">
                            <img src="{{ asset('assets/img/avatars/1.png') }}" alt class="w-px-40 h-auto rounded-circle" />
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="#">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="avatar avatar-online">
                                            <img src="{{ asset('assets/img/avatars/1.png') }}" alt class="w-px-40 h-auto rounded-circle" />
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        {{-- TAMPILKAN NAMA USER DARI DATABASE --}}
                                        <span class="fw-semibold d-block">{{ Auth::user()->name ?? 'User' }}</span>
                                        {{-- TAMPILKAN ROLE/EMAIL (Opsional) --}}
                                        <small class="text-muted">{{ Auth::user()->email }}</small>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <div class="dropdown-divider"></div>
                        </li>
                        <!-- <li>
                            <a class="dropdown-item" href="#">
                                <i class="bx bx-user me-2"></i>
                                <span class="align-middle">My Profile</span>
                            </a>
                        </li>
                        <li>
                            <div class="dropdown-divider"></div>
                        </li> -->

                        {{-- TOMBOL LOGOUT --}}
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="bx bx-power-off me-2"></i>
                                <span class="align-middle">Log Out</span>
                            </a>

                            {{-- Form Tersembunyi untuk Logout (Wajib di Laravel) --}}
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>
                @endauth

            </ul>
        </div>
    </nav>