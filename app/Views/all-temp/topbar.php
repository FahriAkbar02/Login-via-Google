<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme no-print"
    id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="bx bx-menu bx-sm"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center " id="navbar-collapse">
        <!-- Search -->
        <div class="navbar-nav align-items-center menu-item">
            <div class="nav-item d-flex align-items-center">
                <h3 class="tart" style="text-align: center;"><strong>Learning</strong> Classhome</h3></sup>
            </div>
        </div>

        <ul class="navbar-nav flex-row align-items-center ms-auto  ">
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow menu-link
                    href=" javascript:void(0);" data-bs-toggle="dropdown">
                    <i class="menu-icon fas fa-solid fa-plus fa-lg"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="<?= base_url('course/join_course') ?>">
                            <span class="align-middle">Gabung Ke Kelas</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="<?= base_url('/course/create_course'); ?>">
                            <span class="align-middle">Buat Kelas</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow  " href="javascript:void(0);" data-bs-toggle="dropdown">

                    <div class="avatar avatar-online " style="margin-left: 30px;">
                        <img src="<?= $userData->profile; ?>" alt="Profile Picture"
                            class="w-px-40 h-auto rounded-circle" />
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="#">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar avatar-online">
                                        <img src="<?= $userData->profile; ?>" alt
                                            class="w-px-40 h-auto rounded-circle" />
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <span class="fw-semibold d-block"><?= $userData->username; ?></span>
                                    <small class="text-muted"><?= $userData->email; ?></small>
                                </div>
                            </div>

                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#" onclick="confirmLogout()">
                            <i class=" bx bx-power-off me-2"></i>
                            <span class="align-middle">Log Out</span>
                        </a>
                    </li>

                </ul>
            </li>
        </ul>
    </div>
</nav>