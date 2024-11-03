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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="<?= base_url(); ?>/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="<?= base_url(); ?>/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="<?= base_url(); ?>/vendor/css/theme-default.css">
</head>

<body>
    <?= $this->include('temp-home/topbar'); ?>
    <div class="layout-wrapper layout-content-navbar  ">
        <div class="content-wrapper">
            <div class="container-xxl flex-grow-1 container-p-y">
                <div class="row">
                    <?= $this->renderSection('page-content'); ?>
                </div>
            </div>

            <div class="content-backdrop fade"></div>
        </div>
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>

</body>

</html>