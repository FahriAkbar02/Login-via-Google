<?php

use PhpParser\Node\Stmt\Echo_;
?>
<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Classhome</title>
    <link rel="icon" type="jpg/png" href="<?= base_url(); ?>/img/CH1.png">
    <link href="<?= base_url(); ?>/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="<?= base_url(); ?>/vendor/fonts/boxicons.css" />
    <link rel="stylesheet" href="<?= base_url(); ?>/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="<?= base_url(); ?>/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="<?= base_url(); ?>/css/demo.css" />
    <script src="<?= base_url(); ?>/vendor/js/helpers.js"></script>
    <script src="<?= base_url(); ?>/js/config.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</head>

<body>
    <div class="layout-wrapper layout-content-navbar  ">
        <div class="layout-container ">
            <?= $this->include('all-temp/sidebar'); ?>
            <div class="layout-page ">
                <?= $this->include('all-temp/topbar'); ?>
                <div class="row">
                    <?= $this->renderSection('page-content'); ?>
                </div>

                <div class="content-backdrop fade"></div>
            </div>
        </div>
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <script src="<?= base_url(); ?>/js/Hide.js"></script>
    <script src="<?= base_url(); ?>/vendor/js/bootstrap.js"></script>
    <script src="<?= base_url(); ?>/vendor/js/menu.js"></script>
    <script src="<?= base_url(); ?>/js/main.js"></script>
    <script src="<?= base_url(); ?>/js/style.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function confirmLogout() {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-success",
                    cancelButton: "btn btn-danger"
                },
                buttonsStyling: false
            });
            swalWithBootstrapButtons.fire({
                title: "Siap untuk Keluar ? ",
                text: " Pilih 'Ya' di bawah, jika Anda siap untuk mengakhiri sesi Anda saat ini!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Ya!",
                cancelButtonText: "Tidak!",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Lakukan penghapusan jika dikonfirmasi
                    window.location.href = "<?= base_url('logout/'); ?>";
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    // Tidak melakukan apa pun jika dibatalkan
                }
            });
        }
    </script>

    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>
    =
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <!-- CKEditor -->
    <script src="https://cdn.ckeditor.com/ckeditor5/34.0.0/classic/ckeditor.js"></script>

    <script>
        ClassicEditor
            .create(document.querySelector('#announcementText'))
            .catch(error => {
                console.error(error);
            });
    </script>
</body>

</html>