<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme no-print">
    <div class="app-brand demo">
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
            <div class="sidebar-brand-icon ">
                <img class="img-responsive" src="<?= base_url() ?>/img/CH.png" alt="">
            </div>
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>
    <div class="menu-inner-shadow"></div>
    <ul class="menu-inner py-1">
        <li class="menu-item ">
            <a href="<?= base_url('course/userCourses/' . session()->get('google_id')) ?>" class="menu-link">
                <i class="menu-icon fas fa-users-class"></i>
                <div data-i18n="Analytics">Kelas</div>
            </a>
        </li>
        <li class="menu-item ">
            <a href="<?= base_url('notifications'); ?>" class="menu-link">
                <i class="menu-icon fas fa-solid fa-bell"></i>
                <div data-i18n="Analytics">Notifications</div>
            </a>
        </li>
        <li class="menu-header small text-uppercase   border-top">
            <span class="menu-header-text">Terdaftar</span>
        </li>

        <li class="menu-item ">
            <a href="<?= base_url('daftar_tugas/' . session()->get('google_id')) ?>" class="menu-link">
                <i class="menu-icon  fas fa-solid fa-tasks"></i>
                <div data-i18n="Analytics">Daftar tugas</div>
            </a>
        </li>
        <li class="menu-item ">
            <a href="<?= base_url('tentang') ?>" class="menu-link">
                <i class="menu-icon  fas fa-solid fa-exclamation-circle"></i>
                <div data-i18n="Analytics">Tentang</div>
            </a>
        </li>
    </ul>
</aside>